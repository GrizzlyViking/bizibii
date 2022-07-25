<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Expense;
use App\Models\Reality;
use App\Rules\DueDateMetaRules;
use App\Rules\DueDateRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ExpenseForm extends Component
{

    public Expense $expense;

    public bool $show_modal = false;

    public $start_date;

    public $end_date;

    public $submit = 'Save';

    public string $checkpoint_date = '';

    public float|string $checkpoint_amount = 0.0;

    protected array $messages = [
        'amount.numeric' => 'The amount must be numeric, with no more than 2 decimals.',
    ];

    protected array $validationAttributes = [
        'start'      => 'start date',
        'end'        => 'end date',
        'account_id' => 'account',
    ];

    protected function getRules(): array
    {
        return [
            'expense.account_id'             => 'required|exists:accounts,id',
            'expense.description'            => 'required',
            'expense.transfer_to_account_id' => [
                'nullable',
                Rule::requiredIf(fn() => Category::Transfer->equals($this->expense->category)),
                function ($attribute, $value, $fail) {
                    if ($value == $this->expense->account_id) {
                        $fail('The account transferred to must be different from the account transfered from.');
                    }
                },
                Rule::prohibitedIf(fn() => !Category::Transfer->equals($this->expense->category)),
            ],
            'expense.category'               => ['required'],
            'expense.frequency'              => ['required'],
            'expense.highlight'              => 'nullable|boolean',
            'expense.due_date'               => ['required', new Enum(DueDate::class), new DueDateRules()],
            'expense.due_date_meta'          => [
                Rule::requiredIf(fn() => DueDate::DateInMonth->equals($this->expense->due_date)),
                new DueDateMetaRules()
            ],
            'expense.amount'                 => 'required|numeric',
            'start_date'                     => [
                'nullable',
                Rule::requiredIf(function () {
                    return Frequency::all()->filter(function (Frequency $frequency) {
                        return $frequency->type() == Frequency::CalendarElementsGrouping && $frequency->equals($this->expense->frequency);
                    })->isNotEmpty();
                }),
                'date',
                'before_or_equal:now',
            ],
            'end_date'                       => 'nullable|date|after:start',
            'checkpoint_date'                => 'nullable|date',
            'checkpoint_amount'              => 'nullable|numeric',
        ];
    }

    public function mount(?Expense $expense)
    {
        $this->expense = $expense ?? new Expense();
        $this->expense->account_id = $expense->account_id ?? Auth::user()->accounts->first()->id;
        $this->expense->frequency = $expense->frequency ?? Frequency::all()->first();
        $this->expense->category = $expense->category ?? Category::all()->first();
        $this->expense->due_date = $expense->due_date ?? DueDate::all()->first();
        $this->start_date = $expense->start?->format('Y-m-d');
        $this->end_date = $expense->end?->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.expense-form');
    }

    public function updated($propertName)
    {
        $this->validateOnly($propertName);
    }

    public function submit()
    {
        $validated = $this->validate();

        if ($this->start_date) {
            $this->expense->start = $this->start_date;
        }

        if ($this->end_date) {
            $this->expense->end = $this->end_date;
        }

        $this->expense->save();

        return redirect()->route('expenses.list');
    }

    public function delete(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()->route('expenses.list');
    }

    public function changeCategory()
    {
        if (Category::DayToDayConsumption->equals($this->expense->category)) {
            $this->expense->due_date = DueDate::LastDayOfMonth->value;
            $this->expense->frequency = Frequency::Daily->value;
            if (empty($this->expense->description)) {
                $this->expense->description = ucfirst(Category::DayToDayConsumption->value);
            }
        } elseif (Category::Transfer->equals($this->expense->category)) {
            $this->expense->due_date = DueDate::LastWorkingDayOfMonth->value;
            $this->expense->frequency = Frequency::Monthly->value;
            $this->expense->transfer_to_account_id = $this->expense->user->accounts->get(1)->id;
        } else {
            $this->expense->transfer_to_account_id = null;
        }
    }

    public function changeFrequency()
    {
        // TODO: set defaults when changing frequency
    }

    public function changeDueDate()
    {
        // TODO: set defaults when changing due date
    }

    public function addCheckpoint()
    {
        $this->expense->checkpoints()->create([
            'amount'          => $this->checkpoint_amount,
            'registered_date' => $this->checkpoint_date,
        ]);


        $this->checkpoint_amount = 0.0;
        $this->checkpoint_date = '';

        $this->expense->refresh();

        $this->show_modal = false;
    }

    public function deleteCheckpoint(Reality $reality)
    {
        $reality->delete();

        $this->expense->refresh();
    }

}
