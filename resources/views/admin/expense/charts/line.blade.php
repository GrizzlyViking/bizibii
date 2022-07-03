<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Line Chart') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-12 px-12 py-12 h-screen bg-white border-dark rounded">
        <livewire:livewire-line-chart :line-chart-model="$lineChartModel" class="h-80"  />
    </div>
</x-app-layout>
