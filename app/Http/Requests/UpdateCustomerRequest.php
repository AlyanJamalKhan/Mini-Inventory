<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Add this import

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * This might require admin privileges or ownership check.
     */
    public function authorize(): bool
    {
        // Example: return auth()->check() && auth()->user()->hasRole('admin');
        return true; // Placeholder - implement proper authorization check
    }

    /**
     * Get the validation rules that apply to the request.
     * Uses Rule::unique to ignore the current customer's email during update.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the customer ID being updated from the route parameters
        $customerId = $this->route('customer');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('customers')->ignore($customerId) // Ignore the current customer's email during update check
            ],
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