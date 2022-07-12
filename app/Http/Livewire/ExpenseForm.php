<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Expense;
use App\Rules\DueDateRules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ExpenseForm extends Component
{
    public Expense $expense;

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
            'expense.due_date'               => ['required', new Enum(DueDate::class), new DueDateRules()],
            'expense.due_date_meta'          => [Rule::requiredIf(fn() => DueDate::DateInMonth->equals($this->expense->due_date))],
            'expense.amount'                 => 'required|numeric',
            'expense.start'                  => [
                'nullable',
                Rule::requiredIf(function () {
                    return Frequency::all()->filter(function (Frequency $frequency) {
                        return $frequency->type() == Frequency::CalendarElementsGrouping && $frequency->equals($this->expense->frequency);
                    })->isNotEmpty();
                }),
                'date',
                'before_or_equal:now',
            ],
            'expense.end'                    => 'nullable|date|after:start',
        ];
    }

    public function mount(?Expense $expense)
    {
        $this->expense = $expense ?? new Expense();
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
        $this->validate();

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
