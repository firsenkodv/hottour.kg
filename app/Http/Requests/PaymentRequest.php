<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PaymentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()->id;
    }


    public function rules(): array
    {
        return [
            'payment_desc' => ['nullable', 'string' , 'min:2', 'max:30'],
        ];

    }

    protected function prepareForValidation()
    {

    }
}
