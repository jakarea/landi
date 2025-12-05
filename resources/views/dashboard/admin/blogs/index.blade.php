@extends('layouts.instructor-tailwind')
@section('title', 'Manage Blogs')
@section('header-title', 'AI আপডেট ম্যানেজমেন্ট')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">All Blog Posts</h2>
                <a href="{{ route('cms.ai-update.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Blog
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search and Filter -->
            <form action="{{ route('cms.ai-update.index') }}" method="GET" class="mb-6">
                <div class="flex gap-4">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by title..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <select 
                        name="status" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Filter
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Thumbnail</th>
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Category</th>
                            <th class="px-4 py-2 border">Author</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Published</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border text-center">
                                    <img src="{{ $blog->thumbnail ? asset($blog->thumbnail) : asset('images/default-blog.jpg') }}" 
                                         alt="{{ $blog->title }}" 
                                         class="w-16 h-16 rounded object-cover mx-auto">
                                </td>
                                <td class="px-4 py-2 border">
                                    <div class="max-w-xs">
                                        <p class="font-semibold">{{ $blog->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $blog->slug }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border">
                                    @if($blog->category)
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">{{ $blog->category }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $blog->author->name }}</td>
                                <td class="px-4 py-2 border text-center">
                                    @if($blog->status === 'published')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Published</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if($blog->published_at)
                                        {{ $blog->published_at->format('M d, Y') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('blog.show', $blog->slug) }}" 
                                           target="_blank"
                                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('cms.ai-update.edit', $blog->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('cms.ai-update.destroy', $blog->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 border text-center text-gray-500">
                                    No blog posts found. <a href="{{ route('cms.ai-update.create') }}" class="text-blue-500 hover:underline">Create your first blog post</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
@endsection
