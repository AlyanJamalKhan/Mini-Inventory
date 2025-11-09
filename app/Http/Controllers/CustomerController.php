<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    protected $customerService;


    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): View
    {
        $customers = $this->customerService->getAllCustomers();
        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->customerService->createCustomer($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(int $id): View
    {
        $customer = $this->customerService->getCustomerById($id);
        if (!$customer) {
            abort(404, 'Customer not found');
        }
        return view('customers.show', compact('customer'));
    }

    public function edit(int $id): View
    {
        $customer = $this->customerService->getCustomerById($id);
        if (!$customer) {
            abort(404, 'Customer not found');
        }
        return view('customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $updatedCustomer = $this->customerService->updateCustomer($id, $validatedData);

        if (!$updatedCustomer) {
            abort(404, 'Customer not found');
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->customerService->deleteCustomer($id);

        if (!$deleted) {
            abort(404, 'Customer not found');
        }

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}