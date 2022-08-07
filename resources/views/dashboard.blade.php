<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if($lineChartModel instanceof  \Asantibanez\LivewireCharts\Models\LineChartModel)
        <!-- Chart start -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg h-80">
                <livewire:livewire-line-chart :line-chart-model="$lineChartModel"/>
            </div>
        </div>
        <!-- Chart end -->
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                hit it
            </div>
        </div>
    </div>
</x-app-layout>
