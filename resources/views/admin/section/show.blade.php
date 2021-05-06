<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Landing page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden mx-auto w-6/12 bg-white shadow-xl sm:rounded-lg relative">
                <a class="absolute top-4 right-2 transform rotate-90" href="{{ route('section.edit', [$section->page->slug, $section->slug]) }}">Edit</a>
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="absolute top-4 left-15 m-2 w-20 transform rotate-90">
                    <h1 class="text-8xl text-gray-500 m-2 text-opacity-50">{{ $section->title }}</h1>
                </div>
                <div class="text-2xl">{{ $section->subtitle }}</div>
                <div>{!! $section->content !!}</div>
            </div>
            </div>
        </div>
    </div>

</x-app-layout>
