<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'options.1.content' => ['required', 'string', 'max:255'],
            'options.2.content' => ['required', 'string', 'max:255'],
            'options.3.content' => ['required', 'string', 'max:255'],
            'options.4.content' => ['required', 'string', 'max:255'],
            'options.1.is_correct' => ['required', 'in:0,1'],
            'options.2.is_correct' => ['required', 'in:0,1'],
            'options.3.is_correct' => ['required', 'in:0,1'],
            'options.4.is_correct' => ['required', 'in:0,1'],
        ];
}
}
