@extends('layouts.instructor-tailwind')
@section('title', 'Manage Reviews')
@section('header-title', 'Manage Reviews')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">All Reviews</h2>
                <a href="{{ route('cms.reviews.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Review
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Order</th>
                            <th class="px-4 py-2 border">Avatar</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Designation</th>
                            <th class="px-4 py-2 border">Review</th>
                            <th class="px-4 py-2 border">Rating</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border text-center">{{ $review->display_order }}</td>
                                <td class="px-4 py-2 border text-center">
                                    <img src="{{ asset($review->reviewer_avatar ?? 'images/avatar.webp') }}" 
                                         alt="{{ $review->reviewer_name }}" 
                                         class="w-12 h-12 rounded-full mx-auto object-cover">
                                </td>
                                <td class="px-4 py-2 border">{{ $review->reviewer_name }}</td>
                                <td class="px-4 py-2 border">{{ $review->reviewer_designation }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="max-w-xs truncate" title="{{ $review->review_text }}">
                                        {{ Str::limit($review->review_text, 50) }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <span class="text-yellow-500">{{ str_repeat('⭐', $review->rating) }}</span>
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if($review->is_active)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Active</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('cms.reviews.edit', $review->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('cms.reviews.destroy', $review->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this review?');">
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
                                <td colspan="8" class="px-4 py-8 border text-center text-gray-500">
                                    No reviews found. <a href="{{ route('cms.reviews.create') }}" class="text-blue-500 hover:underline">Add your first review</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
