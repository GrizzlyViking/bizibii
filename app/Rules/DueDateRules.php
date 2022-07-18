<?php

namespace App\Rules;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class DueDateRules implements InvokableRule, DataAwareRule
{

    protected array $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __invoke($attribute, $value, $fail)
    {
        if (
            $this->data['expense']['category'] == Category::DayToDayConsumption->value &&
            $value != DueDate::LastDayOfMonth->value
        ) {
            $fail('If category is "'.Category::DayToDayConsumption->value.'" then Due Date must be '. DueDate::LastDayOfMonth->value);
        }

        if (DueDate::FirstDayOfYear->equals($value) && !Frequency::Yearly->equals($this->data['expense']['frequency'])) {
            $fail('If :attribute is "'.DueDate::FirstDayOfYear->value.'", then logically frequency can only be "'.Frequency::Yearly->value.'"');
        }

        if ($this->data['expense']['frequency'] == Frequency::Single->value && $value != DueDate::DateInMonth->value) {
            $fail('Frequency is set to one time only, then due date must be "'.DueDate::DateInMonth->value.'"');
        }
    }

}
