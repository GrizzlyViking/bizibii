<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    @if($lineChartModel instanceof  \Asantibanez\LivewireCharts\Models\LineChartModel)
        <!-- Chart start -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg">
                <div class="h-96">
                    <livewire:livewire-line-chart :line-chart-model="$lineChartModel"/>
                </div>
            </div>
        </div>
        <!-- Chart end -->
    @endif

    @if($expensesBarChart instanceof  \Asantibanez\LivewireCharts\Models\BaseChartModel)
        <!-- Chart start -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 px-6 p-8 bg-white shadow-xl sm:rounded-lg">
                <div class="h-96">
                    <livewire:livewire-column-chart :column-chart-model="$expensesBarChart"/>
                </div>
            </div>
        </div>
        <!-- Chart end -->
    @endif

    <div class="py-12">
        <livewire:list-expenses :user="Auth::user()" />
    </div>
</x-app-layout>
