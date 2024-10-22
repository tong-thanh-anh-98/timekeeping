<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',  // Password must be at least 8 characters
                'regex:/[a-z]/', // Must contain at least one lowercase letter
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[0-9]/', // Must contain at least one digit
                'regex:/[@$!%*?&.]/', // Must contain at least one special character
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must include an uppercase letter, a lowercase letter, a number, and a special character.',
        ];
    }
}
