<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $productService;

    
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): View
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->productService->createProduct($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(int $id): View
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            abort(404, 'Product not found');
        }
        return view('products.show', compact('product'));
    }

    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            abort(404, 'Product not found');
        }
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $updatedProduct = $this->productService->updateProduct($id, $validatedData);

        if (!$updatedProduct) {
            abort(404, 'Product not found');
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->productService->deleteProduct($id);

        if (!$deleted) {
            abort(404, 'Product not found');
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}