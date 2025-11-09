<?php

namespace App\Repositories\Implementations;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
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
        $product = $this->findById($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null; // Or throw an exception if product not found
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        if ($product) {
            return $product->delete();
        }
        return false; // Or throw an exception if product not found
    }
}