<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'explanation' => ['required', 'string', 'max:1000'],

            'options' => ['required', 'array', 'size:4'],
            'options.*.content' => ['required', 'string', 'max:255'],
            'options.*.is_correct' => ['required', 'in:0,1'],
            'options.*.optionId' => ['required', 'integer', 'exists:options,id'],
        ];
    }
}
