<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers(): Collection
    {
        return $this->customerRepository->all();
    }

    public function getCustomerById(int $id)
    {
        return $this->customerRepository->findById($id);
    }

    public function createCustomer(array $data)
    {
        // Add any specific business logic here if needed before creating
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(int $id, array $data)
    {
        // Add any specific business logic here if needed before updating
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer(int $id)
    {
        // Add any specific business logic here if needed before deleting
        return $this->customerRepository->delete($id);
    }
}