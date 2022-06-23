<?php

namespace App\Http\Livewire;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ExpenseForm extends Component
{

    /** @var int */
    public $bank_account_id;

    public $description;

    public $category;

    public $frequency;

    public $due_date;

    public $due_date_meta;

    public $amount;

    public $start;

    public $end;

    public $submit = 'Save';

    protected array $messages = [
        'amount.numeric' => 'The amount must be numeric, with no more than 2 decimals.',
    ];

    protected array $validationAttributes = [
        'start' => 'start date',
        'end'   => 'end date',
    ];

    public ?int $expense_id = null;

    protected function getRules(): array
    {
        return [
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'description'     => 'required',
            'category'        => ['required', new Enum(Category::class)],
            'frequency'       => ['required'],
            'due_date'        => ['required', new Enum(DueDate::class)],
            'due_date_meta'   => [Rule::requiredIf(fn() => $this->due_date == DueDate::DateInMonth->value)],
            'amount'          => 'required|numeric',
            'start'           => [
                'date',
                Rule::requiredIf(function () {
                    return Frequency::all()->filter(function (Frequency $frequency) {
                        return $frequency->type() == Frequency::CalendarElementsGrouping && $frequency->value == $this->frequency;
                    })->isNotEmpty();
                }),
                'before_or_equal:now',
            ],
            'end'             => 'nullable|date|after:start',
        ];
    }

    public function mount(Expense $expense = null)
    {
        if (!$expense->id) {
            $this->reset('expense_id', 'description', 'amount', 'due_date_meta', 'start', 'end', 'expense_id');
            $this->bank_account_id = Auth::user()->bankAccounts->first()->id;
            $this->category = Category::all()->first()->value;
            $this->due_date = DueDate::all()->first()->value;
            $this->frequency = Frequency::all()->first()->value;
        } else {
            $this->expense_id = $expense->id;
            $this->description = $expense->description;
            $this->amount = $expense->amount;
            $this->due_date_meta = $expense->due_date_meta;
            $this->start = $expense->start?->format('Y-m-d');;
            $this->end = $expense->end?->format('Y-m-d');
            $this->bank_account_id = $expense->bank_account_id;
            $this->category = $expense->category?->value;
            $this->due_date = $expense->due_date?->value;
            $this->frequency = $expense->frequency?->value;
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

        return redirect()->route('expenses.index');
    }

    public function delete(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index');
    }

}
