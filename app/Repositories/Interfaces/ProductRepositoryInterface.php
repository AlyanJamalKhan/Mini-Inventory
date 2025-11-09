<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    // Add other methods as needed, e.g., findByStock($minStock)
}