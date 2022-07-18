<?php

namespace App\Rules;

use App\Enums\DueDate;
use App\Enums\Frequency;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class DueDateMetaRules implements InvokableRule, DataAwareRule
{

    protected array $data;

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (empty($value) && (DueDate::DateInMonth->equals($this->data['expense']['due_date']))) {
            $fail('If due date is '.DueDate::DateInMonth->value.', then further info must be provided.');
        }

        if (
            Frequency::Single->equals($this->data['expense']['frequency']) &&
            strtotime($value) === false
        ) {
            $fail('Please provide a valid date.');
        } elseif (
            Frequency::Single->equals($this->data['expense']['frequency']) &&
            !preg_match('/\d{1,2}/', $value, $matched)
        ) {
            dump($value, $matched);
            $fail('Please provide a valid date of the month, ex. on the 12th of each month.');
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

}
