<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For customer creation, you might allow any user, or require admin
        // For this project scope, let's assume it's open or handled by a broader auth check.
        return true; // Or implement specific logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email', // Ensure email is unique
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
         return [
            'name.required' => 'The customer name is required.',
            'email.required' => 'The customer email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'A customer with this email address already exists.',
         ];
    }
}