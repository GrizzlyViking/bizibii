<?php

namespace App\Services;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Graph
{
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

    public static function multiLineChart(string $title, Collection $collection): LineChartModel
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

    public static function lineChart(string $title, Collection $collection): LineChartModel
    {
        return $collection
            ->reduce(function (LineChartModel $lineChart, $data) {
                [$name, $date, $value] = $data;
                return $lineChart->addPoint(self::getMonth($date), $value);
            }, (new LineChartModel())
                ->setTitle($title)
                ->singleLine()
            );
    }

    public static function barChart(string $title, Collection $collection, bool $stacked = true): ColumnChartModel
    {
        $column_model = (new ColumnChartModel())
            ->setTitle($title)
            ->multiColumn()
            ->withOnColumnClickEventName('onColumnClick');

        if ($stacked) {
            $column_model = $column_model->stacked();
        }

        return $collection
            ->reduce(function (ColumnChartModel $columnCart, $data) {
                [$name, $date, $value] = $data;
                return $columnCart->addSeriesColumn($name, self::getMonth($date), $value);
            }, $column_model);
    }


    public static function getMonth(string $yearMonth): string
    {
        if (preg_match('/^(\d{4})-(\d{2})$/', $yearMonth, $matched)) {
            return Carbon::create($matched[1], $matched[2], '1')->monthName;
        }

        return $yearMonth;
    }

}
