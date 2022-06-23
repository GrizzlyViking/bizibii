<?php

namespace App\Http\Livewire\Component;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;

class Datepicker extends ModalComponent
{
    public CarbonInterface $date;

    public Collection $grid;

    public function mount(CarbonInterface $date)
    {
        $this->date = $date->toImmutable();
        $this->grid = $this->buildDateGrid($date);
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.component.datepicker');
    }

    public function buildDateGrid(CarbonInterface $date): Collection
    {
        $step = (clone $date)->toMutable();
        $step->startOfMonth()->startOfWeek();

        $month = [];
        $week_number = $date->startOfMonth()->weekOfYear;
        while ($step <= $date->endOfMonth()->endOfWeek()) {
            $month[$week_number][] = (clone $step)->toImmutable();
            if ($step->format('N') == 7) {
                $week_number++;
            }
            $step->addDay();
        }

        return collect($month);
    }
}
