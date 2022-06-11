<?php

namespace App\Http\Requests;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreExpenseRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'description'     => 'required',
            'category'        => ['required', new Enum(Category::class)],
            'frequency'       => ['required', new Enum(Frequency::class)],
            'due_date'        => ['required', new Enum(DueDate::class)],
            'due_date_meta'   => [Rule::requiredIf(fn () => $this->request->get('due_date') == DueDate::DateInMonth->value)],
            'amount'          => 'required|numeric',
            'applied'         => 'nullable|boolean',
            'start'           => ['date', Rule::requiredIf(function() {
                return Frequency::all()->filter(function (Frequency $frequency) {
                    return $frequency->type() == Frequency::CalendarElementsGrouping &&
                        $frequency->value == $this->request->get('frequency');
                })->isNotEmpty();
            })],
            'end'             => 'nullable|date',
        ];
    }

}
