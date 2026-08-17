<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SignUpFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string' , 'min:2'],
            'email' => ['required', 'email', 'email:dns', 'unique:users'],
            'phone' => ['required', 'string', 'min:5', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'inn' => ['nullable', 'string', 'max:50'],
            'passport' => ['nullable', 'string', 'max:50'],
            'passport_issued_at' => ['nullable', 'string', 'max:50'],
            'passport_issued_by' => ['nullable', 'string', 'max:255'],
        ];


    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value(),
                'phone' => phone($this->phone),

            ]
        );
    }
}
