@extends('layouts.instructor-tailwind')
@section('title', 'Edit Review')
@section('header-title', 'Edit Review')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Edit Review</h2>
                <a href="{{ route('cms.reviews.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>

            <form action="{{ route('cms.reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="reviewer_name" class="block text-gray-700 font-bold mb-2">Reviewer Name *</label>
                    <input type="text" id="reviewer_name" name="reviewer_name" value="{{ old('reviewer_name', $review->reviewer_name) }}" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reviewer_name') border-red-500 @enderror" 
                           required>
                    @error('reviewer_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="reviewer_designation" class="block text-gray-700 font-bold mb-2">Designation</label>
                    <input type="text" id="reviewer_designation" name="reviewer_designation" value="{{ old('reviewer_designation', $review->reviewer_designation) }}" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reviewer_designation') border-red-500 @enderror">
                    @error('reviewer_designation')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="review_text" class="block text-gray-700 font-bold mb-2">Review Text *</label>
                    <textarea id="review_text" name="review_text" rows="5" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('review_text') border-red-500 @enderror" 
                              required>{{ old('review_text', $review->review_text) }}</textarea>
                    @error('review_text')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Current Avatar</label>
                    @if($review->reviewer_avatar)
                        <img src="{{ asset($review->reviewer_avatar) }}" alt="{{ $review->reviewer_name }}" 
                             class="w-20 h-20 rounded-full object-cover mb-2">
                    @else
                        <p class="text-gray-500 text-sm">No avatar uploaded</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="reviewer_avatar" class="block text-gray-700 font-bold mb-2">Upload New Avatar (Optional)</label>
                    <input type="file" id="reviewer_avatar" name="reviewer_avatar" accept="image/*" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reviewer_avatar') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB</p>
                    @error('reviewer_avatar')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 font-bold mb-2">Rating *</label>
                    <select id="rating" name="rating" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('rating') border-red-500 @enderror" 
                            required>
                        <option value="">Select Rating</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} {{ str_repeat('⭐', $i) }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="display_order" class="block text-gray-700 font-bold mb-2">Display Order *</label>
                    <input type="number" id="display_order" name="display_order" value="{{ old('display_order', $review->display_order) }}" min="0" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('display_order') border-red-500 @enderror" 
                           required>
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                    @error('display_order')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $review->is_active) ? 'checked' : '' }} 
                               class="mr-2 leading-tight">
                        <span class="text-gray-700 font-bold">Active (Show on website)</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Review
                    </button>
                    <a href="{{ route('cms.reviews.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
