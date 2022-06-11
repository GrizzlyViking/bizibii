<?php

namespace App\Http\Requests;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateExpensesRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_account_id' => 'sometimes|required|exists:bank_accounts,id',
            'description'     => 'sometimes|required',
            'category'        => ['sometimes', 'required', new Enum(Category::class)],
            'frequency'       => ['sometimes', 'required', new Enum(Frequency::class)],
            'due_date'        => ['sometimes', 'required', new Enum(DueDate::class)],
            'due_date_meta'   => ['sometimes', Rule::requiredIf(fn () => $this->request->get('due_date') == DueDate::DateInMonth->value)],
            'amount'          => 'sometimes|required|numeric',
            'applied'         => 'nullable|boolean',
            'start'           => 'nullable|date',
            'end'             => 'nullable|date',
        ];
    }

}
