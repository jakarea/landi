@extends('layouts.instructor-tailwind')
@section('title', 'CMS Management')
@section('header-title', 'CMS Management')

@section('content')
    <div class="p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Page Sections</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white text-start">
                        <tr>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-start">Section Image</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-start">Page Name</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-start">Section Name</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($pageSections as $key => $section)
                            <tr class="odd:bg-[#f1f1f1] even:bg-[#fff]">
                                <td width="20%" class="py-3 px-4">
                                     <img src="{{ asset($section->sectionImage) }}" alt="{{ $section->sectionName }}" class="w-[270px] h-[70px] mr-auto object-contain rounded-xl overflow-hidden">
                                </td>
                                <td class="py-3 px-4">{{ $section->pageName }}</td>
                                <td class="py-3 px-4">{{ $section->sectionName }}</td>
                                <td class="py-3 px-4" width="10%">
                                    <a href="{{ route('cms.page-section.edit', $section->id) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
