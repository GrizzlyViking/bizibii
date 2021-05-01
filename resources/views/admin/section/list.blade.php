<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Landing page') }}
        </h2>
    </x-slot>

    <livewire:list-items :items="$sections" />
</x-app-layout>
