<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         // Assuming an admin middleware will handle authorization for product management
         // For now, return true if authenticated admin, false otherwise.
         // Example: return auth()->check() && auth()->user()->hasRole('admin');
         return true; // Placeholder - implement proper authorization check
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Assuming the product ID is part of the route, e.g., /products/{product}
        // Use route parameter for unique rule if updating name/email to avoid conflict with itself
        return [
            'name' => 'sometimes|required|string|max:255', // 'sometimes' means validate only if present
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
         return [
            'name.required' => 'The product name is required.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'stock.required' => 'The product stock quantity is required.',
            'stock.integer' => 'The product stock must be an integer.',
         ];
    }
}