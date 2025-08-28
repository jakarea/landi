<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LandingPageBuilderController extends Controller
{
    public function editor($course_id)
    {
        $course = Course::where('id', $course_id)
                       ->where('user_id', Auth::id())
                       ->firstOrFail();
        
        $landingPage = LandingPage::where('course_id', $course_id)
                                 ->where('user_id', Auth::id())
                                 ->first();

        return view('builder.editor', compact('course', 'landingPage'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content_json' => 'required|json',
            'seo_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string',
            'og_image' => 'nullable|string',
        ]);

        $course = Course::where('id', $request->course_id)
                       ->where('user_id', Auth::id())
                       ->firstOrFail();

        $slug = Str::slug($request->title . '-' . $course->slug);
        
        $landingPage = LandingPage::updateOrCreate(
            [
                'course_id' => $request->course_id,
                'user_id' => Auth::id()
            ],
            [
                'title' => $request->title,
                'slug' => $slug,
                'content_json' => $request->content_json,
                'seo_title' => $request->seo_title,
                'seo_meta_description' => $request->seo_meta_description,
                'seo_keywords' => $request->seo_keywords,
                'og_image' => $request->og_image,
                'status' => 'draft'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Landing page saved successfully',
            'landing_page' => $landingPage
        ]);
    }

    public function preview($id)
    {
        $landingPage = LandingPage::where('id', $id)
                                 ->where('user_id', Auth::id())
                                 ->firstOrFail();

        $htmlContent = $this->convertJsonToHtml($landingPage->content_json);
        
        return view('builder.preview', compact('landingPage', 'htmlContent'));
    }

    public function publish($id)
    {
        $landingPage = LandingPage::where('id', $id)
                                 ->where('user_id', Auth::id())
                                 ->firstOrFail();

        if (empty($landingPage->content_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot publish empty landing page'
            ], 400);
        }

        $htmlContent = $this->convertJsonToHtml($landingPage->content_json);
        
        $landingPage->update([
            'rendered_html' => $htmlContent,
            'status' => 'published'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Landing page published successfully',
            'url' => route('landing.show', $landingPage->slug)
        ]);
    }

    public function show($slug)
    {
        $landingPage = LandingPage::where('slug', $slug)
                                 ->where('status', 'published')
                                 ->firstOrFail();

        return view('builder.show', compact('landingPage'));
    }

    private function convertJsonToHtml($contentJson)
    {
        if (is_string($contentJson)) {
            $contentJson = json_decode($contentJson, true);
        }

        if (!is_array($contentJson) || !isset($contentJson['sections'])) {
            return '<div class="text-center py-16"><p>No content available</p></div>';
        }

        $html = '';
        
        foreach ($contentJson['sections'] as $section) {
            $html .= $this->renderSection($section);
        }

        return $html;
    }

    private function renderSection($section)
    {
        switch ($section['type']) {
            case 'hero':
                return $this->renderHeroSection($section);
            case 'text':
                return $this->renderTextSection($section);
            case 'image':
                return $this->renderImageSection($section);
            case 'video':
                return $this->renderVideoSection($section);
            case 'faq':
                return $this->renderFaqSection($section);
            case 'testimonial':
                return $this->renderTestimonialSection($section);
            case 'pricing':
                return $this->renderPricingSection($section);
            case 'cta':
                return $this->renderCtaSection($section);
            default:
                return '';
        }
    }

    private function renderHeroSection($section)
    {
        $title = $section['data']['title'] ?? 'Default Title';
        $subtitle = $section['data']['subtitle'] ?? 'Default Subtitle';
        $buttonText = $section['data']['button_text'] ?? 'Get Started';
        $buttonLink = $section['data']['button_link'] ?? '#';

        return "
        <section class=\"bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20 text-center\">
            <div class=\"container mx-auto px-4\">
                <h1 class=\"text-5xl font-bold mb-6\">{$title}</h1>
                <p class=\"text-xl mb-8 max-w-2xl mx-auto\">{$subtitle}</p>
                <a href=\"{$buttonLink}\" class=\"inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors\">
                    {$buttonText}
                </a>
            </div>
        </section>
        ";
    }

    private function renderTextSection($section)
    {
        $content = $section['data']['content'] ?? 'Default text content';
        
        return "
        <section class=\"py-16\">
            <div class=\"container mx-auto px-4\">
                <div class=\"prose max-w-4xl mx-auto\">
                    {$content}
                </div>
            </div>
        </section>
        ";
    }

    private function renderImageSection($section)
    {
        $imageUrl = $section['data']['image_url'] ?? '/placeholder.jpg';
        $alt = $section['data']['alt_text'] ?? 'Image';
        $caption = $section['data']['caption'] ?? '';

        return "
        <section class=\"py-16\">
            <div class=\"container mx-auto px-4 text-center\">
                <img src=\"{$imageUrl}\" alt=\"{$alt}\" class=\"mx-auto rounded-lg shadow-lg max-w-full\">
                " . ($caption ? "<p class=\"mt-4 text-gray-600\">{$caption}</p>" : "") . "
            </div>
        </section>
        ";
    }

    private function renderVideoSection($section)
    {
        $videoUrl = $section['data']['video_url'] ?? '';
        $title = $section['data']['title'] ?? '';

        return "
        <section class=\"py-16 bg-gray-50\">
            <div class=\"container mx-auto px-4\">
                " . ($title ? "<h2 class=\"text-3xl font-bold text-center mb-8\">{$title}</h2>" : "") . "
                <div class=\"max-w-4xl mx-auto\">
                    <div class=\"relative pb-9/16\">
                        <iframe src=\"{$videoUrl}\" class=\"absolute inset-0 w-full h-full rounded-lg\" frameborder=\"0\" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>
        ";
    }

    private function renderFaqSection($section)
    {
        $title = $section['data']['title'] ?? 'Frequently Asked Questions';
        $faqs = $section['data']['faqs'] ?? [];

        $faqHtml = '';
        foreach ($faqs as $index => $faq) {
            $question = $faq['question'] ?? '';
            $answer = $faq['answer'] ?? '';
            $faqHtml .= "
            <div class=\"border-b border-gray-200 pb-6 mb-6\">
                <h3 class=\"text-lg font-semibold mb-2\">{$question}</h3>
                <p class=\"text-gray-600\">{$answer}</p>
            </div>
            ";
        }

        return "
        <section class=\"py-16\">
            <div class=\"container mx-auto px-4\">
                <h2 class=\"text-3xl font-bold text-center mb-12\">{$title}</h2>
                <div class=\"max-w-3xl mx-auto\">
                    {$faqHtml}
                </div>
            </div>
        </section>
        ";
    }

    private function renderTestimonialSection($section)
    {
        $testimonials = $section['data']['testimonials'] ?? [];

        $testimonialHtml = '';
        foreach ($testimonials as $testimonial) {
            $name = $testimonial['name'] ?? '';
            $content = $testimonial['content'] ?? '';
            $image = $testimonial['image'] ?? '';
            $role = $testimonial['role'] ?? '';

            $testimonialHtml .= "
            <div class=\"bg-white rounded-lg shadow-md p-6\">
                <p class=\"text-gray-600 mb-4\">\"{$content}\"</p>
                <div class=\"flex items-center\">
                    " . ($image ? "<img src=\"{$image}\" alt=\"{$name}\" class=\"w-12 h-12 rounded-full mr-4\">" : "") . "
                    <div>
                        <p class=\"font-semibold\">{$name}</p>
                        " . ($role ? "<p class=\"text-sm text-gray-500\">{$role}</p>" : "") . "
                    </div>
                </div>
            </div>
            ";
        }

        return "
        <section class=\"py-16 bg-gray-50\">
            <div class=\"container mx-auto px-4\">
                <h2 class=\"text-3xl font-bold text-center mb-12\">What Our Students Say</h2>
                <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8\">
                    {$testimonialHtml}
                </div>
            </div>
        </section>
        ";
    }

    private function renderPricingSection($section)
    {
        $title = $section['data']['title'] ?? 'Pricing';
        $plans = $section['data']['plans'] ?? [];

        $planHtml = '';
        foreach ($plans as $plan) {
            $name = $plan['name'] ?? '';
            $price = $plan['price'] ?? '';
            $features = $plan['features'] ?? [];
            $buttonText = $plan['button_text'] ?? 'Get Started';
            $buttonLink = $plan['button_link'] ?? '#';
            $featured = $plan['featured'] ?? false;

            $featureList = '';
            foreach ($features as $feature) {
                $featureList .= "<li class=\"flex items-center mb-2\"><svg class=\"w-5 h-5 text-green-500 mr-2\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg>{$feature}</li>";
            }

            $cardClass = $featured ? 'bg-blue-600 text-white transform scale-105' : 'bg-white';
            $buttonClass = $featured ? 'bg-white text-blue-600 hover:bg-gray-100' : 'bg-blue-600 text-white hover:bg-blue-700';

            $planHtml .= "
            <div class=\"{$cardClass} rounded-lg shadow-lg p-8 text-center\">
                <h3 class=\"text-2xl font-bold mb-4\">{$name}</h3>
                <div class=\"text-4xl font-bold mb-6\">{$price}</div>
                <ul class=\"text-left mb-8\">
                    {$featureList}
                </ul>
                <a href=\"{$buttonLink}\" class=\"{$buttonClass} px-8 py-3 rounded-lg font-semibold transition-colors block\">
                    {$buttonText}
                </a>
            </div>
            ";
        }

        return "
        <section class=\"py-16\">
            <div class=\"container mx-auto px-4\">
                <h2 class=\"text-3xl font-bold text-center mb-12\">{$title}</h2>
                <div class=\"grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto\">
                    {$planHtml}
                </div>
            </div>
        </section>
        ";
    }

    private function renderCtaSection($section)
    {
        $title = $section['data']['title'] ?? 'Ready to Get Started?';
        $subtitle = $section['data']['subtitle'] ?? 'Join thousands of satisfied customers today';
        $buttonText = $section['data']['button_text'] ?? 'Get Started Now';
        $buttonLink = $section['data']['button_link'] ?? '#';

        return "
        <section class=\"py-20 bg-blue-600 text-white text-center\">
            <div class=\"container mx-auto px-4\">
                <h2 class=\"text-4xl font-bold mb-4\">{$title}</h2>
                <p class=\"text-xl mb-8 max-w-2xl mx-auto\">{$subtitle}</p>
                <a href=\"{$buttonLink}\" class=\"inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors\">
                    {$buttonText}
                </a>
            </div>
        </section>
        ";
    }
}