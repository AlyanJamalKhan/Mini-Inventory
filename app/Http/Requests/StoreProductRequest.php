<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming an admin middleware will handle authorization for product management
        // For now, return true if authenticated admin, false otherwise.
        // You might check for a specific role or permission here.
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
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
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