@extends('layouts.instructor-tailwind')
@section('title', 'Create Blog Post')
@section('header-title', 'নতুন ব্লগ পোস্ট')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Create New Blog Post</h2>
                <a href="{{ route('cms.ai-update.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cms.ai-update.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required
                        onkeyup="generateSlug()"
                    >
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">
                        Slug (URL)
                    </label>
                    <input 
                        type="text" 
                        name="slug" 
                        id="slug" 
                        value="{{ old('slug') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Leave empty to auto-generate from title"
                    >
                    <p class="text-gray-600 text-xs mt-1">Preview: <span id="slug-preview" class="font-mono text-blue-600"></span></p>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-2">
                        Category
                    </label>
                    <input 
                        type="text" 
                        name="category" 
                        id="category" 
                        value="{{ old('category') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="e.g., AI Tools, Tutorial, News"
                    >
                </div>

                <!-- Thumbnail -->
                <div class="mb-6">
                    <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">
                        Thumbnail Image
                    </label>
                    <input 
                        type="file" 
                        name="thumbnail" 
                        id="thumbnail" 
                        accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        onchange="previewImage(event)"
                    >
                    <div id="thumbnail-preview" class="mt-4 hidden">
                        <img id="preview-img" src="" alt="Preview" class="max-w-xs rounded shadow">
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="mb-6">
                    <label for="excerpt" class="block text-gray-700 text-sm font-bold mb-2">
                        Excerpt (Short Description)
                    </label>
                    <textarea 
                        name="excerpt" 
                        id="excerpt" 
                        rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="A brief summary of the blog post..."
                    >{{ old('excerpt') }}</textarea>
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                        Content <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="15"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-sm"
                        required
                        placeholder="Write your blog content here..."
                    >{{ old('content') }}</textarea>
                    <p class="text-gray-600 text-xs mt-1">You can use HTML tags for formatting if needed.</p>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required
                    >
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between">
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline"
                    >
                        Create Blog Post
                    </button>
                    <a href="{{ route('cms.ai-update.index') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    // Generate slug from title
    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        
        document.getElementById('slug').value = slug;
        document.getElementById('slug-preview').textContent = '/ai-update/' + slug + '/';
    }

    // Update slug preview when manually edited
    document.getElementById('slug').addEventListener('input', function() {
        document.getElementById('slug-preview').textContent = '/ai-update/' + this.value + '/';
    });

    // Preview thumbnail image
    function previewImage(event) {
        const preview = document.getElementById('thumbnail-preview');
        const previewImg = document.getElementById('preview-img');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endsection
