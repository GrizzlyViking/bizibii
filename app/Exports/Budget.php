<?php

namespace App\Exports;

use App\Enums\Category;
use App\Models\Expense;
use App\Services\ExpensesWalker;
use App\Traits\MonthNameTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;

class Budget implements FromArray
{
    use MonthNameTrait;

    protected array $column_headers = [];

    public function array(): array
    {
        $walker = new ExpensesWalker(
            Carbon::now()->startOfMonth(),
            Carbon::now()->addYear()->startOfMonth()->subDay(),
            Expense::all()->reject(fn (Expense $expense) => $expense->category->type() === Category::ADMINISTRATIVE)
        );

        // $response is used to divide the expenses out to months and years divided into expense categories
        $response = $walker->getData()->reduce(function (array $carry, Collection $value, string $date) {
            preg_match('/^(\d+)-(\d+)-\d+$/', $date, $matched);
            [$date, $year, $month] = $matched;
            $column = $year . ' ' . $this->getMonth($date);
            $this->column_headers[$column] = null;
            $value->each(function (Expense $expense) use ($date, &$carry, $column) {
                $carry[$expense->category->value][$column][] = $expense->setDateToCheck($date);
            });
            return $carry;
        }, []);

        // normalised
        $response = Arr::map($response, fn ($value) => array_merge($this->column_headers, $value));

        // expenses are summed
        $response = Arr::map($response, function (array $expenses) {
            return Arr::map($expenses, function ($expense) {
                return collect($expense)->sum(fn (Expense $expense) => $expense->getCost());
            });
        });

        // prepend expense.
        foreach ($response as $key => &$month) {
            array_unshift($month, $key);
        }

        // prepend expense column header
        array_unshift($this->column_headers, 'expenses');
        array_unshift($response, array_keys($this->column_headers));

        return $response;
    }
}
