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
            'description' => 'required',
            'category' => ['required', new Enum(Category::class)],
            'frequency' => ['required', new Enum(Frequency::class)],
            'due_date' => [new Enum(DueDate::class)],
            'due_date_meta' => 'required_if:due_date,'.DueDate::DateInMonth->value,
            'amount' => 'nullable|numeric',
            'applied' => 'nullable|boolean',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ];
    }

}
