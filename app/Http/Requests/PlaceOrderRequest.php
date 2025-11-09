<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * This might require the user to be authenticated and have permission to place orders.
     * Also, implicitly assumes the cart session exists and is not empty (checked in the service).
     */
    public function authorize(): bool
    {
        // Example: return auth()->check(); // Or specific role check
        return true; // Placeholder - implement proper authorization check
    }

    /**
     * Get the validation rules that apply to the request.
     * Validates that the customer ID provided exists in the database.
     * The actual cart items are validated for stock availability within the OrderService.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id', // Validates the selected customer exists
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
         return [
            'customer_id.required' => 'A customer must be selected to place an order.',
            'customer_id.exists' => 'The selected customer does not exist.',
         ];
    }
}