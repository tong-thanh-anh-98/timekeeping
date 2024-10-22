<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => [
                'required',
                'string',
                'min:8', // ít nhất 8 ký tự
                'regex:/[a-z]/', // ít nhất một chữ thường
                'regex:/[A-Z]/', // ít nhất một chữ hoa
                'regex:/[0-9]/', // ít nhất một số
                'regex:/[@$!%*#?&]/', // ít nhất một ký tự đặc biệt
                'confirmed', // yêu cầu phải xác nhận (cặp password và password_confirmation)
            ],
            'password_confirmation' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
