# Mini Inventory & Orders Management System

This is a Laravel application built to demonstrate core architectural principles like the Repository-Service-Controller pattern, dependency injection, session handling for carts, and proper business logic separation, as required by the project guidelines.

## Structure & Approach

The application follows the Repository-Service-Controller (RSC) architecture to keep the code organized and maintainable:

1.  **Models (`app/Models`):** Eloquent models (`Product`, `Customer`, `Order`, `OrderItem`) represent the database tables and define their relationships (e.g., `Order` has many `OrderItem`s).
2.  **Repository Pattern (`app/Repositories`):**
    *   **Interfaces (`Interfaces/`):** Define contracts for data access methods (e.g., `ProductRepositoryInterface`).
    *   **Implementations (`Implementations/`):** Contain the actual Eloquent queries (e.g., `ProductRepository`).
    *   **Binding:** Interfaces are bound to their implementations in `app/Providers/RepositoryServiceProvider.php`, managed by Laravel's Service Container.
3.  **Service Layer (`app/Services`):** Contains the core business logic.
    *   `OrderService` handles cart operations (add, remove, update, get total) using Laravel sessions.
    *   `OrderService` manages the complex `placeOrder` process: checking stock, using database transactions, creating orders/order items, and reducing stock.
    *   Other services (`ProductService`, `CustomerService`) manage their respective entities' logic.
4.  **Controllers (`app/Http/Controllers`):**
    *   Receive dependencies (Services) via constructor injection.
    *   Handle HTTP requests, validate using Form Requests, call service methods, and return responses (views, redirects).
5.  **Form Requests (`app/Http/Requests`):** Input validation logic is encapsulated in classes like `StoreProductRequest`.
6.  **Routes (`routes/web.php`):** Map URLs to controller actions. Admin-only routes for products/orders are protected using middleware.
7.  **Views (`resources/views`):** Basic Blade templates for CRUD operations and the cart/order flow.
8.  **Sessions:** Used within `OrderService` to manage the user's temporary shopping cart.
9.  **Database Seeding (`database/seeders`):** Includes seeders for `Product`, `Customer`, and `Order` (with `OrderItem`s) to populate the database with sample data.
10. **Testing (`tests`):**
    *   **Unit Test:** `OrderServiceTest` (in `tests/Unit`) tests the `isStockSufficient` method in isolation using mocks.

## Key Features Implemented

*   **RSC Architecture:** Clear separation of concerns between data access (Repository), business logic (Service), and request handling (Controller).
*   **Dependency Injection:** Controllers receive Services, Services receive Repositories, promoting loose coupling.
*   **Session Cart:** The `OrderService` uses Laravel sessions to store and manage the temporary cart state.
*   **Eloquent Relationships:** Models correctly link to each other (Product, Customer, Order, OrderItem).
*   **Transactions:** The `placeOrder` process in `OrderService` is wrapped in a database transaction to ensure data integrity.
*   **Stock Management:** Stock is checked before placing an order and reduced upon successful order placement. Prevents orders with insufficient stock.
*   **Form Request Validation:** Input validation is handled cleanly outside of controllers.
*   **Sample Data:** Seeded with products, customers, and orders.
*   **Testing:** Includes a unit test for business logic and a feature test for the order placement flow.
