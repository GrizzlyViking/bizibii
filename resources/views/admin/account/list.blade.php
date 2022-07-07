<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <livewire:list-items :items="$accounts" />
    </div>
</x-app-layout>
