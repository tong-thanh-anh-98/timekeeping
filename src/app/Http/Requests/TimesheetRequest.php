<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
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
            // 'type' => 'required|string|in:checkin,checkout',
            'type' => 'required|in:checkin,checkout',
            'date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Type is required.',
            // 'type.string' => 'Type must be a string.',
            'type.in' => 'Type must be either checkin or checkout.',
            'date.required' => 'Date is required.',
            'date.date' => 'Please provide a valid date.',
        ];
    }
}
