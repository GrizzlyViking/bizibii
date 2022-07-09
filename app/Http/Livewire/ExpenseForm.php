<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Expense;
use App\Rules\DueDateRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ExpenseForm extends Component
{

    public ?int $expense_id = null;

    /** @var int */
    public $account_id;

    public $transfer_to_account_id;

    public $description;

    public string $category = '';

    public $frequency;

    public $due_date;

    public $due_date_meta;

    public $amount;

    public $start;

    public $end;

    public bool $show_transfer_to_accounts = false;

    public $submit = 'Save';

    protected array $messages = [
        'amount.numeric' => 'The amount must be numeric, with no more than 2 decimals.',
    ];

    protected array $validationAttributes = [
        'start'                  => 'start date',
        'end'                    => 'end date',
        'account_id'             => 'account',
    ];

    protected function getRules(): array
    {
        return [
            'account_id'             => 'required|exists:accounts,id',
            'description'            => 'required',
            'transfer_to_account_id' => [
                'nullable',
                Rule::requiredIf(fn() => $this->category == Category::Transfer->value),
                function ($attribute, $value, $fail) {
                    if ($value == $this->account_id) {
                        $fail('The account transferred to must be different from the account transfered from.');
                    }
                },
                Rule::prohibitedIf(fn() => $this->category !== Category::Transfer->value),
            ],
            'category'               => ['required'],
            'frequency'              => ['required'],
            'due_date'               => ['required', new Enum(DueDate::class), new DueDateRules()],
            'due_date_meta'          => [Rule::requiredIf(fn() => $this->due_date == DueDate::DateInMonth->value)],
            'amount'                 => 'required|numeric',
            'start'                  => [
                'nullable',
                Rule::requiredIf(function () {
                    return Frequency::all()->filter(function (Frequency $frequency) {
                        return $frequency->type() == Frequency::CalendarElementsGrouping && $frequency->value == $this->frequency;
                    })->isNotEmpty();
                }),
                'date',
                'before_or_equal:now',
            ],
            'end'                    => 'nullable|date|after:start',
        ];
    }

    public function mount(?Expense $expense = null)
    {
        if (!$expense->id) {
            $this->reset('expense_id', 'description', 'amount', 'due_date_meta', 'start', 'end', 'expense_id');
            $this->account_id = Auth::user()->accounts->first()->id;
            $this->category = Category::all()->first()->value;
            $this->due_date = DueDate::all()->first()->value;
            $this->frequency = Frequency::all()->first()->value;
        } else {
            $this->expense_id = $expense->id;
            $this->transfer_to_account_id = $expense->transfer_to_account_id;
            $this->description = $expense->description;
            $this->amount = $expense->amount;
            $this->due_date_meta = $expense->due_date_meta;
            $this->start = $expense->start?->format('Y-m-d');;
            $this->end = $expense->end?->format('Y-m-d');
            $this->account_id = $expense->account_id;
            $this->category = $expense->category->value;
            $this->due_date = $expense->due_date->value;
            $this->frequency = $expense->frequency->value;
            $this->submit = 'Update';
        }
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

        Expense::updateOrInsert(
            [
                'id' => $this->expense_id,
            ],
            $validated
        );

        return redirect()->route('expenses.list');
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.list');
    }

    public function changeCategory()
    {
        if ($this->category == Category::DayToDayConsumption->value) {
            $this->due_date = DueDate::LastDayOfMonth->value;
            $this->frequency = Frequency::Daily->value;
        } elseif (Category::Transfer->equals($this->category)) {
            $this->due_date = DueDate::LastWorkingDayOfMonth->value;
            $this->frequency = Frequency::Monthly->value;
            $this->show_transfer_to_accounts = true;
        } else {
            $this->transfer_to_account_id = null;
            $this->show_transfer_to_accounts = false;
        }
    }

}
