<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->all();
    }

    public function getProductById(int $id)
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data)
    {
        // Add any specific business logic here if needed before creating
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        // Add any specific business logic here if needed before updating
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        // Add any specific business logic here if needed before deleting
        return $this->productRepository->delete($id);
    }

    // Example: Method to check stock availability
    public function isStockSufficient(int $productId, int $quantity): bool
    {
        $product = $this->getProductById($productId);
        return $product && $product->stock >= $quantity;
    }
}