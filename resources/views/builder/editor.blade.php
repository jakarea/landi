<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Builder - {{ $course->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://unpkg.com/vuedraggable@4/dist/vuedraggable.umd.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div id="app">
        <div class="min-h-screen flex">
            <!-- Sidebar with components -->
            <div class="w-80 bg-white shadow-lg">
                <div class="p-6 border-b">
                    <h1 class="text-xl font-bold">Landing Page Builder</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ $course->title }}</p>
                </div>
                
                <!-- SEO Settings -->
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold mb-4">SEO Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Page Title</label>
                            <input v-model="pageData.title" type="text" class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">SEO Title</label>
                            <input v-model="pageData.seo_title" type="text" class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Meta Description</label>
                            <textarea v-model="pageData.seo_meta_description" class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Keywords</label>
                            <input v-model="pageData.seo_keywords" type="text" class="w-full border rounded-lg px-3 py-2" placeholder="keyword1, keyword2">
                        </div>
                    </div>
                </div>

                <!-- Components -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Components</h3>
                    <div class="space-y-3">
                        <div v-for="component in availableComponents" :key="component.type"
                             @click="addComponent(component.type)"
                             class="p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                    <span class="text-blue-600 text-sm font-bold">@{{ component.icon }}</span>
                                </div>
                                <div>
                                    <div class="font-medium">@{{ component.name }}</div>
                                    <div class="text-sm text-gray-500">@{{ component.description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-6 border-t">
                    <div class="space-y-2">
                        <button @click="savePage" :disabled="saving"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50">
                            @{{ saving ? 'Saving...' : 'Save Draft' }}
                        </button>
                        <button @click="previewPage" v-if="landingPageId"
                                class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                            Preview
                        </button>
                        <button @click="publishPage" v-if="landingPageId" :disabled="publishing"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 disabled:opacity-50">
                            @{{ publishing ? 'Publishing...' : 'Publish' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main editor area -->
            <div class="flex-1">
                <div class="p-6">
                    <div class="bg-white rounded-lg shadow-lg min-h-screen">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-6">@{{ pageData.title || 'Untitled Page' }}</h2>
                            
                            <!-- Drop zone when empty -->
                            <div v-if="sections.length === 0" 
                                 class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                                <div class="text-gray-500">
                                    <p class="text-lg mb-2">Start building your landing page</p>
                                    <p class="text-sm">Drag components from the sidebar to begin</p>
                                </div>
                            </div>

                            <!-- Sections -->
                            <draggable v-model="sections" group="sections" @change="updateSections" item-key="id">
                                <template #item="{element, index}">
                                    <div class="relative group mb-6">
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                            <button @click="editSection(index)" class="bg-blue-600 text-white p-2 rounded mr-2 hover:bg-blue-700">
                                                ✎
                                            </button>
                                            <button @click="removeSection(index)" class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                                                ×
                                            </button>
                                        </div>
                                        <div class="border rounded-lg p-6 hover:border-blue-300 transition-colors">
                                            <div v-html="renderSectionPreview(element)"></div>
                                        </div>
                                    </div>
                                </template>
                            </draggable>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div v-if="editingSection !== null" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-96 overflow-y-auto">
                <h3 class="text-lg font-bold mb-4">Edit @{{ sections[editingSection].type.charAt(0).toUpperCase() + sections[editingSection].type.slice(1) }} Section</h3>
                
                <!-- Dynamic form based on section type -->
                <div v-if="sections[editingSection].type === 'hero'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <input v-model="sections[editingSection].data.title" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Subtitle</label>
                        <textarea v-model="sections[editingSection].data.subtitle" class="w-full border rounded-lg px-3 py-2" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Button Text</label>
                        <input v-model="sections[editingSection].data.button_text" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Button Link</label>
                        <input v-model="sections[editingSection].data.button_link" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                </div>

                <div v-else-if="sections[editingSection].type === 'text'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Content</label>
                        <textarea v-model="sections[editingSection].data.content" class="w-full border rounded-lg px-3 py-2" rows="6"></textarea>
                    </div>
                </div>

                <div v-else-if="sections[editingSection].type === 'image'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Image URL</label>
                        <input v-model="sections[editingSection].data.image_url" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Alt Text</label>
                        <input v-model="sections[editingSection].data.alt_text" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Caption</label>
                        <input v-model="sections[editingSection].data.caption" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                </div>

                <div v-else-if="sections[editingSection].type === 'cta'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <input v-model="sections[editingSection].data.title" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Subtitle</label>
                        <textarea v-model="sections[editingSection].data.subtitle" class="w-full border rounded-lg px-3 py-2" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Button Text</label>
                        <input v-model="sections[editingSection].data.button_text" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Button Link</label>
                        <input v-model="sections[editingSection].data.button_link" type="text" class="w-full border rounded-lg px-3 py-2">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="editingSection = null" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                    <button @click="saveSection" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue;
        const { VueDraggableNext } = vuedraggable;

        createApp({
            components: {
                draggable: VueDraggableNext
            },
            data() {
                return {
                    courseId: {{ $course->id }},
                    landingPageId: {{ $landingPage->id ?? 'null' }},
                    pageData: {
                        title: '{{ $landingPage->title ?? '' }}',
                        seo_title: '{{ $landingPage->seo_title ?? '' }}',
                        seo_meta_description: '{{ $landingPage->seo_meta_description ?? '' }}',
                        seo_keywords: '{{ $landingPage->seo_keywords ?? '' }}',
                        og_image: '{{ $landingPage->og_image ?? '' }}'
                    },
                    sections: @json($landingPage->content_json['sections'] ?? []),
                    editingSection: null,
                    saving: false,
                    publishing: false,
                    availableComponents: [
                        {
                            type: 'hero',
                            name: 'Hero Section',
                            description: 'Main banner with title and CTA',
                            icon: 'H'
                        },
                        {
                            type: 'text',
                            name: 'Text Block',
                            description: 'Rich text content',
                            icon: 'T'
                        },
                        {
                            type: 'image',
                            name: 'Image',
                            description: 'Single image with caption',
                            icon: 'I'
                        },
                        {
                            type: 'video',
                            name: 'Video',
                            description: 'Embedded video player',
                            icon: 'V'
                        },
                        {
                            type: 'faq',
                            name: 'FAQ',
                            description: 'Frequently asked questions',
                            icon: 'Q'
                        },
                        {
                            type: 'testimonial',
                            name: 'Testimonials',
                            description: 'Customer testimonials',
                            icon: '★'
                        },
                        {
                            type: 'pricing',
                            name: 'Pricing Table',
                            description: 'Pricing plans comparison',
                            icon: '$'
                        },
                        {
                            type: 'cta',
                            name: 'Call to Action',
                            description: 'Action button section',
                            icon: '→'
                        }
                    ]
                }
            },
            methods: {
                addComponent(type) {
                    const newSection = {
                        id: Date.now(),
                        type: type,
                        data: this.getDefaultSectionData(type)
                    };
                    this.sections.push(newSection);
                },
                getDefaultSectionData(type) {
                    const defaults = {
                        hero: {
                            title: 'Your Amazing Course Title',
                            subtitle: 'Learn everything you need to know',
                            button_text: 'Enroll Now',
                            button_link: '#'
                        },
                        text: {
                            content: '<h2>About This Course</h2><p>Add your course description here...</p>'
                        },
                        image: {
                            image_url: '',
                            alt_text: 'Course Image',
                            caption: ''
                        },
                        video: {
                            video_url: '',
                            title: 'Course Preview'
                        },
                        faq: {
                            title: 'Frequently Asked Questions',
                            faqs: [
                                { question: 'What will I learn?', answer: 'You will learn...' }
                            ]
                        },
                        testimonial: {
                            testimonials: [
                                {
                                    name: 'John Doe',
                                    content: 'This course was amazing!',
                                    image: '',
                                    role: 'Student'
                                }
                            ]
                        },
                        pricing: {
                            title: 'Course Pricing',
                            plans: [
                                {
                                    name: 'Basic',
                                    price: '৳৯৯',
                                    features: ['Feature 1', 'Feature 2'],
                                    button_text: 'Enroll',
                                    button_link: '#',
                                    featured: false
                                }
                            ]
                        },
                        cta: {
                            title: 'Ready to Start Learning?',
                            subtitle: 'Join thousands of successful students',
                            button_text: 'Enroll Now',
                            button_link: '#'
                        }
                    };
                    return defaults[type] || {};
                },
                renderSectionPreview(section) {
                    const previews = {
                        hero: `<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded text-center">
                            <h1 class="text-3xl font-bold mb-4">${section.data.title}</h1>
                            <p class="mb-6">${section.data.subtitle}</p>
                            <button class="bg-white text-blue-600 px-6 py-2 rounded">${section.data.button_text}</button>
                        </div>`,
                        text: `<div class="prose">${section.data.content}</div>`,
                        image: `<div class="text-center">
                            ${section.data.image_url ? `<img src="${section.data.image_url}" alt="${section.data.alt_text}" class="max-w-full rounded">` : '<div class="bg-gray-200 h-48 rounded flex items-center justify-center">Image Placeholder</div>'}
                            ${section.data.caption ? `<p class="mt-2 text-gray-600">${section.data.caption}</p>` : ''}
                        </div>`,
                        cta: `<div class="bg-blue-600 text-white p-8 rounded text-center">
                            <h2 class="text-2xl font-bold mb-4">${section.data.title}</h2>
                            <p class="mb-6">${section.data.subtitle}</p>
                            <button class="bg-white text-blue-600 px-6 py-2 rounded">${section.data.button_text}</button>
                        </div>`
                    };
                    return previews[section.type] || `<div class="p-4 bg-gray-100 rounded">${section.type.toUpperCase()} Section</div>`;
                },
                editSection(index) {
                    this.editingSection = index;
                },
                saveSection() {
                    this.editingSection = null;
                },
                removeSection(index) {
                    this.sections.splice(index, 1);
                },
                updateSections() {
                    // Called when sections are reordered
                },
                async savePage() {
                    this.saving = true;
                    try {
                        const response = await fetch('/builder/save', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                course_id: this.courseId,
                                title: this.pageData.title,
                                content_json: JSON.stringify({
                                    sections: this.sections
                                }),
                                seo_title: this.pageData.seo_title,
                                seo_meta_description: this.pageData.seo_meta_description,
                                seo_keywords: this.pageData.seo_keywords,
                                og_image: this.pageData.og_image
                            })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.landingPageId = data.landing_page.id;
                            alert('Page saved successfully!');
                        } else {
                            alert('Error saving page');
                        }
                    } catch (error) {
                        alert('Error saving page');
                    }
                    this.saving = false;
                },
                previewPage() {
                    if (this.landingPageId) {
                        window.open(`/builder/preview/${this.landingPageId}`, '_blank');
                    }
                },
                async publishPage() {
                    if (!this.landingPageId) {
                        alert('Please save the page first');
                        return;
                    }
                    
                    this.publishing = true;
                    try {
                        const response = await fetch(`/builder/publish/${this.landingPageId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            alert('Page published successfully!');
                            window.open(data.url, '_blank');
                        } else {
                            alert('Error publishing page');
                        }
                    } catch (error) {
                        alert('Error publishing page');
                    }
                    this.publishing = false;
                }
            }
        }).mount('#app');
    </script>
</body>
</html>