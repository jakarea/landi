@extends('layouts.instructor-tailwind')
@section('title', 'Edit Section')
@section('header-title', 'Edit Section')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Edit Section: {{ $pageSection->sectionName }} on {{ $pageSection->pageName }}</h2>
                <a href="{{ route('cms.list') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back to List
                </a>
            </div>

            {{-- section image --}}
            <div class="my-4">
                <img src="{{ asset($pageSection->sectionImage) }}" alt="{{ $pageSection->sectionName }}" class="w-full h-[360px] object-contain rounded-xl">
            </div>

            <form action="{{ route('cms.page-section.update', $pageSection->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="pageName" class="block text-gray-700 font-bold mb-2">Page Name</label>
                    <input type="text" id="pageName" name="pageName" value="{{ $pageSection->pageName }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label for="sectionName" class="block text-gray-700 font-bold mb-2">Section Name</label>
                    <input type="text" id="sectionName" name="sectionName" value="{{ $pageSection->sectionName }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" readonly>
                </div>

                @if($pageSection->sectionName === 'hero_slider')
                    {{-- Special UI for Hero Slider --}}
                    <h3 class="text-xl font-bold mb-4 mt-6">Hero Slider Slides</h3>
                    <p class="text-gray-600 mb-4">Manage your hero slider slides. You can edit content and upload new background images.</p>
                    
                    @if(isset($pageSection->content['slides']) && is_array($pageSection->content['slides']))
                        @foreach($pageSection->content['slides'] as $index => $slide)
                            <div class="mb-8 p-6 border-2 border-gray-300 rounded-lg bg-gray-50">
                                <h4 class="text-lg font-semibold mb-4 text-gray-800">Slide {{ $index + 1 }}</h4>
                                
                                {{-- Current Background Image --}}
                                @if(isset($slide['bg_image']))
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2">Current Background Image</label>
                                        <img src="{{ asset($slide['bg_image']) }}" alt="Slide {{ $index + 1 }}" class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                                    </div>
                                @endif
                                
                                {{-- Upload New Image --}}
                                <div class="mb-4">
                                    <label for="slide_image_{{ $index }}" class="block text-gray-700 font-bold mb-2">Upload New Background Image (Optional)</label>
                                    <input type="file" id="slide_image_{{ $index }}" name="slide_image_{{ $index }}" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size: 5MB</p>
                                </div>
                                
                                {{-- Hidden field to preserve current image path --}}
                                <input type="hidden" name="content[slides][{{ $index }}][bg_image]" value="{{ $slide['bg_image'] ?? '' }}">
                                
                                {{-- Title --}}
                                <div class="mb-4">
                                    <label for="slide_title_{{ $index }}" class="block text-gray-700 font-bold mb-2">Title (HTML allowed for gradient text)</label>
                                    <textarea id="slide_title_{{ $index }}" name="content[slides][{{ $index }}][title]" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $slide['title'] ?? '' }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Use &lt;span class="text-gradient"&gt;text&lt;/span&gt; for gradient effect</p>
                                </div>
                                
                                {{-- Description --}}
                                <div class="mb-4">
                                    <label for="slide_description_{{ $index }}" class="block text-gray-700 font-bold mb-2">Description</label>
                                    <textarea id="slide_description_{{ $index }}" name="content[slides][{{ $index }}][description]" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $slide['description'] ?? '' }}</textarea>
                                </div>
                                
                                {{-- CTA Text --}}
                                <div class="mb-4">
                                    <label for="slide_cta_text_{{ $index }}" class="block text-gray-700 font-bold mb-2">CTA Button Text</label>
                                    <input type="text" id="slide_cta_text_{{ $index }}" name="content[slides][{{ $index }}][cta_text]" value="{{ $slide['cta_text'] ?? '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                
                                {{-- CTA Link --}}
                                <div class="mb-4">
                                    <label for="slide_cta_link_{{ $index }}" class="block text-gray-700 font-bold mb-2">CTA Button Link</label>
                                    <input type="text" id="slide_cta_link_{{ $index }}" name="content[slides][{{ $index }}][cta_link]" value="{{ $slide['cta_link'] ?? '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="#section or /page">
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <p class="text-sm text-blue-700">
                            <strong>Note:</strong> To add or remove slides, you'll need to manually edit the database or contact a developer. Currently, you can edit existing slides and upload new images.
                        </p>
                    </div>
                
                @elseif($pageSection->sectionName === 'upcomming')
                    {{-- Special UI for Upcoming Course Section --}}
                    <h3 class="text-xl font-bold mb-4 mt-6">Upcoming Course Settings</h3>
                    <p class="text-gray-600 mb-4">Manage the countdown timer and content for your upcoming course.</p>
                    
                    {{-- Countdown Date/Time --}}
                    <div class="mb-6 p-6 border-2 border-purple-300 rounded-lg bg-purple-50">
                        <h4 class="text-lg font-semibold mb-4 text-purple-800">⏰ Countdown Timer</h4>
                        
                        <div class="mb-4">
                            <label for="countdown_date" class="block text-gray-700 font-bold mb-2">Course Launch Date & Time</label>
                            <input 
                                type="datetime-local" 
                                id="countdown_date" 
                                name="content[countdown_date]" 
                                value="{{ isset($pageSection->content['countdown_date']) ? date('Y-m-d\TH:i', strtotime($pageSection->content['countdown_date'])) : '' }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            >
                            <p class="text-xs text-gray-500 mt-1">Select the date and time when the course will launch. The countdown will update automatically.</p>
                        </div>
                    </div>
                    
                    {{-- Other Content Fields --}}
                    <h4 class="text-lg font-semibold mb-4 text-gray-800">Content</h4>
                    @foreach($pageSection->content as $key => $value)
                        @if($key !== 'countdown_date')
                            <div class="mb-4">
                                <label for="content_{{ $key }}" class="block text-gray-700 font-bold mb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                @if(is_array($value))
                                    @foreach($value as $index => $item)
                                        @if(is_array($item))
                                            @foreach($item as $subKey => $subValue)
                                                <div class="ml-4 mb-2">
                                                    <label for="content_{{ $key }}_{{ $index }}_{{ $subKey }}" class="block text-gray-600 mb-1">{{ ucfirst(str_replace('_', ' ', $subKey)) }} [{{$index}}]</label>
                                                    @if(is_array($subValue))
                                                        @foreach($subValue as $ssKey => $ssValue)
                                                        <input type="text" id="content_{{ $key }}_{{ $index }}_{{ $subKey }}_{{ $ssKey }}" name="content[{{ $key }}][{{ $index }}][{{ $subKey }}][{{ $ssKey }}]" value="{{ $ssValue }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-1">
                                                        @endforeach
                                                    @else
                                                        <input type="text" id="content_{{ $key }}_{{ $index }}_{{ $subKey }}" name="content[{{ $key }}][{{ $index }}][{{ $subKey }}]" value="{{ $subValue }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" id="content_{{ $key }}_{{ $index }}" name="content[{{ $key }}][{{ $index }}]" value="{{ $item }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
                                        @endif
                                    @endforeach
                                @else
                                    <input type="text" id="content_{{ $key }}" name="content[{{ $key }}]" value="{{ $value }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @endif
                            </div>
                        @endif
                    @endforeach
                
                @else
                    {{-- Default UI for other sections --}}
                    <h3 class="text-xl font-bold mb-2">Content</h3>
                    @foreach($pageSection->content as $key => $value)
                        <div class="mb-4">
                            <label for="content_{{ $key }}" class="block text-gray-700 font-bold mb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                            @if(is_array($value))
                                @foreach($value as $index => $item)
                                    @if(is_array($item))
                                        @foreach($item as $subKey => $subValue)
                                            <div class="ml-4 mb-2">
                                                <label for="content_{{ $key }}_{{ $index }}_{{ $subKey }}" class="block text-gray-600 mb-1">{{ ucfirst(str_replace('_', ' ', $subKey)) }} [{{$index}}]</label>
                                                @if(is_array($subValue))
                                                    @foreach($subValue as $ssKey => $ssValue)
                                                    <input type="text" id="content_{{ $key }}_{{ $index }}_{{ $subKey }}_{{ $ssKey }}" name="content[{{ $key }}][{{ $index }}][{{ $subKey }}][{{ $ssKey }}]" value="{{ $ssValue }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-1">
                                                    @endforeach
                                                @else
                                                    <input type="text" id="content_{{ $key }}_{{ $index }}_{{ $subKey }}" name="content[{{ $key }}][{{ $index }}][{{ $subKey }}]" value="{{ $subValue }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <input type="text" id="content_{{ $key }}_{{ $index }}" name="content[{{ $key }}][{{ $index }}]" value="{{ $item }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2">
                                    @endif
                                @endforeach
                            @else
                                <input type="text" id="content_{{ $key }}" name="content[{{ $key }}]" value="{{ $value }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @endif
                        </div>
                    @endforeach
                @endif

                <div class="flex items-center justify-between mt-6">
                    <button type="submit" class="bg-[#000] text-[#fff] cursor-pointer   font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Section
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
