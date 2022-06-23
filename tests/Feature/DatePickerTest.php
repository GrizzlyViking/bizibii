<?php

namespace Tests\Feature;

use App\Http\Livewire\Component\Datepicker;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DatePickerTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function build_date_grid()
    {
        $picker = new Datepicker();

        $month = $picker->buildDateGrid($now = Carbon::now());

        $month->each(function ($week, $weekNumber) {
            $this->assertCount(7, $week, 'In the grid, every week must have exactly 7 entries. Week ' . $weekNumber . ' only had ' . count($week));
        });

        $month->each(function (array $week) {
            foreach ($week as $carbon) {
                echo $carbon->format('Y-m-d');
            }
        });

        foreach ($month->get($now->weekOfYear) as $day) {
            $this->assertInstanceOf(CarbonInterface::class, $day);
        }

        $this->assertTrue(true);
    }
}
