<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ReplacementFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       // return auth()->user()->id;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_text' => ['required', 'string' , 'min:2'],
            'new_text' => ['required', 'string' , 'min:2'],

        ];


    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
/*                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value(),*/

            ]
        );
    }
}
