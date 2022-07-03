<?php

namespace App\Rules;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class DueDateRules implements InvokableRule, DataAwareRule
{

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __invoke($attribute, $value, $fail)
    {
        if (
            $this->data['category'] == Category::DayToDayConsumption->value &&
            $value != DueDate::LastDayOfMonth->value
        ) {
            $fail('If category is "'.Category::DayToDayConsumption->value.'" then Due Date must be '. DueDate::LastDayOfMonth->value);
        }

        if ($value == DueDate::FirstDayOfYear->value && $this->data['frequency'] != Frequency::Yearly->value) {
            $fail('If :attribute is "'.DueDate::FirstDayOfYear->value.'", then logically frequency can only be "'.Frequency::Yearly->value.'"');
        }
    }

}
