<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface; // Need to mock this too
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Mockery;

class OrderServiceTest extends TestCase
{
    private $mockOrderRepository;
    private $mockProductRepository;
    private $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks for both required repositories
        $this->mockOrderRepository = Mockery::mock(OrderRepositoryInterface::class);
        $this->mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);

        // Inject the mock repositories into the OrderService
        // The OrderService constructor is: __construct(OrderRepositoryInterface $orderRepo, ProductRepositoryInterface $productRepo)
        $this->orderService = new OrderService(
            $this->mockOrderRepository, // Mocked OrderRepository
            $this->mockProductRepository // Mocked ProductRepository
        );
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Clean up Mockery after each test
        parent::tearDown();
    }

    /** @test */
    public function it_checks_if_stock_is_sufficient()
    {
        // Arrange: Define the inputs and expected behavior of dependencies
        $productId = 1;
        $quantityRequested = 5;

        // Create a mock Product model instance
        $mockProduct = Mockery::mock(Product::class);
        // Expect the 'stock' attribute to be accessed and return 10
        $mockProduct->shouldReceive('__get')->with('stock')->andReturn(10);

        // Configure the ProductRepository mock
        // Expect findById to be called with $productId and return the mock product
        $this->mockProductRepository->shouldReceive('findById')
                                   ->with($productId)
                                   ->andReturn($mockProduct);

        // Act: Call the method under test
        $isSufficient = $this->orderService->isStockSufficient($productId, $quantityRequested);

        // Assert: Check the result
        $this->assertTrue($isSufficient, 'Stock should be sufficient (10 >= 5)');
    }

     /** @test */
     public function it_checks_if_stock_is_insufficient()
     {
         // Arrange: Define the inputs and expected behavior of dependencies
         $productId = 2;
         $quantityRequested = 8;

         // Create a mock Product model instance
         $mockProduct = Mockery::mock(Product::class);
         // Expect the 'stock' attribute to be accessed and return 5
         $mockProduct->shouldReceive('__get')->with('stock')->andReturn(5);

         // Configure the ProductRepository mock
         // Expect findById to be called with $productId and return the mock product
         $this->mockProductRepository->shouldReceive('findById')
                                    ->with($productId)
                                    ->andReturn($mockProduct);

         // Act: Call the method under test
         $isSufficient = $this->orderService->isStockSufficient($productId, $quantityRequested);

         // Assert: Check the result
         $this->assertFalse($isSufficient, 'Stock should be insufficient (5 < 8)');
     }

     /** @test */
     public function it_checks_if_stock_is_insufficient_when_product_not_found()
     {
         // Arrange: Define the inputs and expected behavior of dependencies
         $productId = 999; // Non-existent product ID
         $quantityRequested = 1;

         // Configure the ProductRepository mock
         // Expect findById to be called with $productId and return null (product not found)
         $this->mockProductRepository->shouldReceive('findById')
                                    ->with($productId)
                                    ->andReturn(null);

         // Act: Call the method under test
         $isSufficient = $this->orderService->isStockSufficient($productId, $quantityRequested);

         // Assert: Check the result
         $this->assertFalse($isSufficient, 'Stock should be insufficient if product is not found');
     }
}