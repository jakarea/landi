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
                <img src="{{ asset($pageSection->sectionImage) }}" alt="{{ $pageSection->sectionName }}" class="w-full h-[360px] object-cover rounded-xl">
            </div>

            <form action="{{ route('cms.page-section.update', $pageSection->id) }}" method="POST">
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

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
