<?php

namespace App\Repositories\Implementations;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $customer = $this->findById($id);
        if ($customer) {
            $customer->update($data);
            return $customer;
        }
        return null; // Or throw an exception if customer not found
    }

    public function delete(int $id)
    {
        $customer = $this->findById($id);
        if ($customer) {
            return $customer->delete();
        }
        return false; // Or throw an exception if customer not found
    }
}