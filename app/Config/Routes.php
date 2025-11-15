<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('auth', 'AuthController::auth');

$routes->get('register', 'AuthController::register');
$routes->post('register/store', 'AuthController::store');

$routes->get('logout', 'AuthController::logout');


$routes->group('admin', static function ($routes) {
    // Dashboard
    $routes->get('/', 'AdminController::dashboard', ['as' => 'admin.dashboard']);

    // Profile
    $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
    $routes->post('profile/update', 'AdminController::updateProfile', ['as' => 'admin.profile.update']);

    // Staff Management
    $routes->get('manage-staff', 'AdminController::manageStaff', ['as' => 'admin.manage']);
    $routes->get('staff/list', 'AdminController::staffList', ['as' => 'admin.staff.list']);
    $routes->post('staff/save', 'AdminController::saveStaff', ['as' => 'admin.staff.save']);
    $routes->post('staff/toggle-status', 'AdminController::toggleStaffStatus');

    // Customers
    $routes->get('customers', 'AdminController::customerList', ['as' => 'admin.customer.list']);

    // Product Management
    $routes->get('product', 'AdminController::productManagement', ['as' => 'admin.product']);
    $routes->get('product/list', 'AdminController::productList'); // AJAX endpoint
    $routes->post('product/add', 'AdminController::addProduct', ['as' => 'admin.product.add']);
    $routes->post('category/add', 'AdminController::addCategory', ['as' => 'admin.category.add']);

    // Orders
    $routes->get('manage-orders', 'AdminController::manageOrders', ['as' => 'admin.orders']);
    $routes->get('orders-list', 'AdminController::ordersList');
    $routes->get('getOrderDetails', 'AdminController::getOrderDetails');
    $routes->post('updateOrderStatus', 'AdminController::updateOrderStatus');

    // Reports
    $routes->get('sales-reports', 'AdminController::salesReports', ['as' => 'admin.sales.reports']);
    $routes->get('getDailySalesReport', 'AdminController::getDailySalesReport');
    $routes->get('getWeeklySalesReport', 'AdminController::getWeeklySalesReport');
    $routes->get('getMonthlySalesReport', 'AdminController::getMonthlySalesReport');
});



$routes->group('staff', static function ($routes) {
    $routes->get('/', 'StaffController::dashboard', ['as' => 'staff.dashboard']);
    $routes->get('inventory', 'StaffController::inventory', ['as' => 'staff.inventory']);
    $routes->post('inventory/update-stock', 'StaffController::updateStock', ['as' => 'staff.inventory.updateStock']);
    $routes->get('reports', 'StaffController::reports', ['as' => 'staff.reports']);

    // Staff Report Routes
    $routes->get('getDailyReport', 'StaffController::getDailyReport');
    $routes->get('getWeeklyReport', 'StaffController::getWeeklyReport');
    $routes->get('getMonthlyReport', 'StaffController::getMonthlyReport');

    $routes->get('profile', 'StaffController::profile', ['as' => 'staff.profile']);
    
});


$routes->group('kathys_crochet_flowers', static function ($routes) {
    // Home
    $routes->get('/', 'CustomerController::index', ['as' => 'customer.home']);

    // Profile
    $routes->get('profile', 'CustomerController::profile', ['as' => 'customer.profile']);
    $routes->post('profile/update', 'CustomerController::updateProfile', ['as' => 'customer.profile.update']);

    // Products
    $routes->get('products', 'CustomerController::productList', ['as' => 'customer.products']);
    $routes->get('product-details', 'CustomerController::productDetails', ['as' => 'customer.product.details']); // FIXED: Added missing route
    $routes->post('products/filter', 'CustomerController::filterProducts'); // AJAX filter endpoint

    // Orders
    $routes->get('orders', 'CustomerController::orders', ['as' => 'customer.orders']);
    $routes->get('order-details/(:num)', 'CustomerController::orderDetails/$1', ['as' => 'customer.order.details']);
    $routes->post('cancel-order', 'CustomerController::cancelOrder', ['as' => 'customer.cancel.order']);

    // Cart Management
    $routes->post('add-to-cart', 'CustomerController::addToCart'); // AJAX add to cart endpoint
    $routes->post('remove-from-cart', 'CustomerController::removeFromCart'); // AJAX remove from cart endpoint
    $routes->post('update-cart-quantity', 'CustomerController::updateCartQuantity'); // AJAX update cart quantity endpoint
    $routes->get('cart', 'CustomerController::viewCart', ['as' => 'customer.cart']);
    $routes->post('cart/remove/(:num)', 'CustomerController::cartRemove/$1');

    // Checkout & Orders
    $routes->get('checkout', 'CustomerController::checkout', ['as' => 'customer.checkout']);
    $routes->post('place-order', 'CustomerController::placeOrder', ['as' => 'customer.place.order']);
    $routes->post('buy-now', 'CustomerController::buyNow'); // Buy now route
});
