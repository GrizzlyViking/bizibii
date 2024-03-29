<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

        <div class="pt-1 px-12 pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <x-alert-warning title="{{ $title }}">{{ $message }}</x-alert-warning>
                </div>
            </div>
        </div>
</x-app-layout>
