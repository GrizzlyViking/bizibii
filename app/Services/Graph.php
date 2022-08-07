<?php

namespace App\Services;

use App\Enums\Category;
use App\Models\Account;
use App\Models\Expense;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Graph
{

    public static function getAccumulateExpenses(Collection $expenses, CarbonInterface $startAt, CarbonInterface $endAt): LineChartModel
    {
        $graphs = collect();
        $expenses->groupBy(fn(Expense $expense) => $expense->account_id)
            ->each(function (Collection $expenses) use ($startAt, $endAt, &$graphs) {
                /** @var Account $account */
                $account = $expenses->first()->account;
                $graphs->put($account->name, self::accumulateExpenses($expenses, $startAt, $endAt));
            });

        $lineChartModel = (new LineChartModel())
            ->multiLine()
            ->setTitle('Accumulated expenses.');
        $graphs->each(function ($graph, $name) use ($lineChartModel) {
            $graph->each(function ($balance, $date) use ($name, $lineChartModel) {
                $lineChartModel->addSeriesPoint($name, self::getMonth($date), $balance);
            });
        });

        return $lineChartModel;
    }

    protected static function accumulateExpenses(Collection $expenses, CarbonInterface $startAt, CarbonInterface $endAt): Collection
    {
    }

    public static function pieChart(string $title, Collection $collection): PieChartModel
    {
        return $collection
            ->reduce(function (PieChartModel $pieChartModel, $data) {
                [$name, $value, $colour] = $data;
                return $pieChartModel->addSlice($name, $value, $colour);
            }, (new PieChartModel())
                ->setTitle($title)
            );
    }

    public static function lineChart(string $title, Collection $collection): LineChartModel
    {
        return $collection
            ->reduce(function (LineChartModel $lineChart, $data) {
                [$name, $date, $value] = $data;
                return $lineChart->addSeriesPoint($name, self::getMonth($date), $value);
            }, (new LineChartModel())
                ->setTitle($title)
                ->multiLine()
            );
    }

    public static function barChart(string $title, Collection $collection): ColumnChartModel
    {
        return $collection
            ->reduce(function (ColumnChartModel $columnCart, $data) {
                [$name, $date, $value] = $data;
                return $columnCart->addSeriesColumn($name, self::getMonth($date), $value);
            }, (new ColumnChartModel())
                ->setTitle($title)
                ->multiColumn()
                ->stacked()
                ->withOnColumnClickEventName('onColumnClick')
            );
    }


    public static function getMonth(string $yearMonth): string
    {
        if (preg_match('/(\d{4})-(\d{2})/', $yearMonth, $matched)) {
            return Carbon::create($matched[1], $matched[2], '1')->monthName;
        }

        return $yearMonth;
    }

}
