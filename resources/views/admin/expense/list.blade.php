<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    <!-- Chart start -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg h-80">
            <livewire:livewire-line-chart :line-chart-model="$lineChartModel"/>
        </div>
    </div>
    <!-- Chart end -->

    <!-- Chart start -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg h-80">
            <livewire:livewire-column-chart :column-chart-model="$expensesBarChart"/>
        </div>
    </div>
    <!-- Chart end -->

    <div class="py-12">
        <livewire:list-expenses :items="$expenses"/>
    </div>
</x-app-layout>
