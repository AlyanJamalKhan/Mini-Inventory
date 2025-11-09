<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function all(): Collection
    {
        return $this->model->with('customer')->get(); // Eager load customer
    }

    public function findById(int $id)
    {
        return $this->model->with(['customer', 'orderItems.product'])->find($id); // Eager load related data
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $order = $this->findById($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null; // Or throw an exception if order not found
    }

    public function delete(int $id)
    {
        $order = $this->findById($id);
        if ($order) {
            return $order->delete();
        }
        return false; // Or throw an exception if order not found
    }
}