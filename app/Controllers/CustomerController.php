<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class CustomerController extends BaseController
{
    // FIXED: Added proper product details method
    public function productDetails()
    {
        // Get selected product ID from query string
        $productId = $this->request->getGet('id');

        if (!$productId) {
            return redirect()->to('kathys_crochet_flowers/products')->with('error', 'Invalid product.');
        }

        $productModel = new ProductModel();
        $product = $productModel
            ->select('products.*, categories.category_name')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->where('products.product_id', $productId)
            ->first();

        if (!$product) {
            return redirect()->to('kathys_crochet_flowers/products')->with('error', 'Product not found.');
        }

        // Get related products (same category, exclude current)
        $relatedProducts = [];
        if ($product && !empty($product['category_id'])) {
            $relatedProducts = $productModel
                ->select('products.*, categories.category_name')
                ->join('categories', 'categories.category_id = products.category_id', 'left')
                ->where('products.category_id', $product['category_id'])
                ->where('products.product_id !=', $productId)
                ->limit(4)
                ->findAll();
        }

        $data = [
            'title' => "Kathy's Crochet Flower - " . $product['product_name'],
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];
        return view('customer/page/product-details', $data);
    }

    // FIXED: Updated filterProducts to generate correct product detail URLs
    public function filterProducts()
    {
        $category_id = $this->request->getPost('category_id');
        $price_range = $this->request->getPost('price_range');

        $productModel = new ProductModel();
        $builder = $productModel
            ->select('products.*, categories.category_name')
            ->join('categories', 'categories.category_id = products.category_id', 'left');

        if ($category_id) {
            $builder->where('products.category_id', $category_id);
        }

        if ($price_range) {
            if ($price_range === 'under500') {
                $builder->where('products.price <', 500);
            } elseif ($price_range === '500-1500') {
                $builder->where('products.price >=', 500)->where('products.price <=', 1500);
            } elseif ($price_range === 'above1500') {
                $builder->where('products.price >', 1500);
            }
        }

        $products = $builder->findAll();

        // Render only the product grid HTML
        $html = '';
        if (!empty($products)) {
            foreach ($products as $product) {
                if (!empty($product['image'])) {
                    if (strpos($product['image'], 'http') === 0) {
                        $imgSrc = $product['image'];
                    } elseif (strpos($product['image'], 'uploads/products/') === 0) {
                        $imgSrc = base_url($product['image']);
                    } else {
                        $imgSrc = base_url('uploads/products/' . $product['image']);
                    }
                } else {
                    $imgSrc = base_url('uploads/products/default.png');
                }

                // FIXED: Generate correct product details URL
                $detailsUrl = base_url('kathys_crochet_flowers/product-details?id=' . $product['product_id']);

                $html .= '<div class="col">'
                    . '<a href="' . $detailsUrl . '" class="card h-100 shadow-sm border-0 rounded-4 text-decoration-none text-dark product-card-clickable" data-product="' . htmlspecialchars(json_encode($product)) . '">'
                    . '<img src="' . esc($imgSrc) . '" class="card-img-top" alt="' . esc($product['product_name']) . '">'
                    . '<div class="card-body d-flex flex-column">'
                    . '<h5 class="card-title">' . esc($product['product_name']) . '</h5>'
                    . '<small class="card-text text-muted mb-2">' . esc($product['category_name']) . '</small>'
                    . '<div class="mt-auto d-flex justify-content-between align-items-center">'
                    . '<small class="product-price"><i class="fa-solid fa-money-bill-wave"></i> Php ' . esc($product['price']) . '</small>'
                    . '</div>'
                    . '</div>'
                    . '</a>'
                    . '</div>';
            }
        } else {
            $html .= '<div class="col-12"><div class="alert alert-warning">No products found.</div></div>';
        }

        return $this->response->setBody($html);
    }

    public function productList()
    {
        $productModel = new ProductModel();
        // Join products with categories to get category_name for each product
        $products = $productModel
            ->select('products.*, categories.category_name')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->findAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $data = [
            'title' => "Kathy's Crochet Flower - Products",
            'products' => $products,
            'categories' => $categories,
        ];
        return view('customer/page/product', $data);
    }

    // Confirm order and save to database
    public function placeOrder()
    {
        $session = session();
        $user_id = $session->get('user_id');
        if (!$session->get('isLoggedIn') || !$user_id) {
            return redirect()->to('/login')->with('error', 'Please log in before placing an order.');
        }

        $request = $this->request;
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('kathys_crochet_flowers/checkout')->with('error', 'Your cart is empty.');
        }

        // Validate payment method
        $paymentMethod = $request->getPost('payment_method');
        if (!in_array($paymentMethod, ['gcash', 'cod'])) {
            return redirect()->to('kathys_crochet_flowers/checkout')
                ->with('error', 'Invalid payment method selected.')
                ->withInput();
        }

        $data = [
            'user_id' => $user_id,
            'name' => $request->getPost('name'),
            'mobile' => $request->getPost('mobile'),
            'email' => $request->getPost('email'),
            'city' => $request->getPost('city'),
            'province' => $request->getPost('province'),
            'zip' => $request->getPost('zip'),
            'date' => $request->getPost('date'),
            'address' => $request->getPost('address'),
            'notes' => $request->getPost('notes'),
            'payment_method' => $paymentMethod,
            'gcash_reference' => null,
            'gcash_image' => null,
            'status' => 'pending',
        ];

        // GCASH PAYMENT VALIDATION AND PROCESSING
        if ($paymentMethod === 'gcash') {
            $gcashReference = $request->getPost('gcash_reference');
            $gcashFile = $request->getFile('gcash_image');

            if (empty($gcashReference)) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'GCash reference number is required for gcash payment.')
                    ->withInput();
            }

            if (strlen($gcashReference) < 10) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'GCash reference number seems too short. Please check and try again.')
                    ->withInput();
            }

            if (!$gcashFile || !$gcashFile->isValid()) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'Payment screenshot is required for GCash payment.')
                    ->withInput();
            }

            if ($gcashFile->hasMoved()) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'File upload error. Please try again.')
                    ->withInput();
            }

            $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $fileMimeType = $gcashFile->getMimeType();

            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'Invalid file type. Only JPG, PNG, and GIF images are allowed.')
                    ->withInput();
            }

            $maxFileSize = 5 * 1024 * 1024;
            if ($gcashFile->getSize() > $maxFileSize) {
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'File size too large. Maximum 5MB allowed.')
                    ->withInput();
            }

            try {
                $newName = $gcashFile->getRandomName();
                $uploadPath = FCPATH . 'uploads/orders';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $gcashFile->move($uploadPath, $newName);

                $data['gcash_reference'] = $gcashReference;
                $data['gcash_image'] = 'uploads/orders/' . $newName;
                $data['status'] = 'pending_verification';
            } catch (\Exception $e) {
                log_message('error', 'GCash file upload failed: ' . $e->getMessage());
                return redirect()->to('kathys_crochet_flowers/checkout')
                    ->with('error', 'Failed to upload payment screenshot. Please try again.')
                    ->withInput();
            }
        } else {
            $data['status'] = 'pending';
        }

        // Calculate totals
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
        $shippingFee = $cartTotal > 0 ? 100 : 0;
        $total = $cartTotal + $shippingFee;
        $data['subtotal'] = $cartTotal;
        $data['shipping_fee'] = $shippingFee;
        $data['total'] = $total;

        // Stock validation
        $productModel = new ProductModel();
        $stockErrors = [];
        $productsToUpdate = [];

        foreach ($cart as $item) {
            $product = $productModel->find($item['product_id']);

            if (!$product) {
                $stockErrors[] = "Product '{$item['product_name']}' no longer exists.";
                continue;
            }

            if (isset($product['stock']) && $product['stock'] < $item['quantity']) {
                if ($product['stock'] <= 0) {
                    $stockErrors[] = "'{$item['product_name']}' is out of stock.";
                } else {
                    $stockErrors[] = "'{$item['product_name']}' only has {$product['stock']} units available.";
                }
                continue;
            }

            $productsToUpdate[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'current_stock' => $product['stock'] ?? 0
            ];
        }

        if (!empty($stockErrors)) {
            return redirect()->to('kathys_crochet_flowers/checkout')
                ->with('error', implode("\n", $stockErrors))
                ->withInput();
        }

        // Database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderModel = new OrderModel();
            $orderId = $orderModel->insert($data, true);

            if (!$orderId) {
                throw new \Exception('Failed to create order.');
            }

            $orderItemModel = new OrderItemModel();
            foreach ($cart as $item) {
                $orderItemModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            foreach ($productsToUpdate as $productInfo) {
                $newStock = $productInfo['current_stock'] - $productInfo['quantity'];
                $productModel->update($productInfo['product_id'], ['stock' => $newStock]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed.');
            }

            session()->remove('cart');

            if ($paymentMethod === 'gcash') {
                $successMessage = 'Order placed successfully! Your GCash payment is being verified. You will receive a confirmation once approved.';
            } else {
                $successMessage = 'Order placed successfully! Please prepare exact amount for Cash on Delivery.';
            }

            return redirect()->to('kathys_crochet_flowers')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Order placement failed: ' . $e->getMessage());

            if (!empty($data['gcash_image']) && file_exists(FCPATH . $data['gcash_image'])) {
                @unlink(FCPATH . $data['gcash_image']);
            }

            return redirect()->to('kathys_crochet_flowers/checkout')
                ->with('error', 'Failed to place order. Please try again.')
                ->withInput();
        }
    }

    public function cartRemove($product_id = null)
    {
        if (!$product_id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->set('cart', $cart);
            return redirect()->to('kathys_crochet_flowers/cart')->with('success', 'Product removed from cart.');
        }

        return redirect()->to('kathys_crochet_flowers/cart')->with('error', 'Product not found in cart.');
    }

    public function updateCartQuantity()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if (!$productId || $quantity < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid product or quantity.'
            ]);
        }

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if (isset($product['stock']) && $quantity > $product['stock']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Only {$product['stock']} units available in stock.",
                'max_quantity' => $product['stock']
            ]);
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $cart[$productId]['stock'] = isset($product['stock']) ? $product['stock'] : null;
            session()->set('cart', $cart);

            $cartItems = array_values($cart);
            $cartTotal = 0;
            foreach ($cartItems as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
            $shippingFee = $cartTotal > 0 ? 100 : 0;

            return $this->response->setJSON([
                'success' => true,
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'cart_total' => $cartTotal,
                'shipping_fee' => $shippingFee,
                'item_total' => $cart[$productId]['price'] * $cart[$productId]['quantity']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found in cart.'
            ]);
        }
    }

    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if (!$productId || $quantity < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid product or quantity.'
            ]);
        }

        $productModel = new ProductModel();
        $product = $productModel
            ->select('products.*, categories.category_name')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->where('products.product_id', $productId)
            ->first();

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if (isset($product['stock'])) {
            $cart = session()->get('cart') ?? [];
            $currentCartQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
            $totalRequestedQty = $currentCartQty + $quantity;

            if ($totalRequestedQty > $product['stock']) {
                $availableToAdd = $product['stock'] - $currentCartQty;

                if ($availableToAdd <= 0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'This product is out of stock or already at maximum quantity in your cart.'
                    ]);
                }

                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Only {$availableToAdd} more units available in stock."
                ]);
            }
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $cart[$productId]['stock'] = isset($product['stock']) ? $product['stock'] : null;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'category_name' => $product['category_name'],
                'quantity' => $quantity,
                'stock' => isset($product['stock']) ? $product['stock'] : null
            ];
        }

        session()->set('cart', $cart);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function removeFromCart()
    {
        $productId = $this->request->getPost('product_id');

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid product.'
            ]);
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->set('cart', $cart);

            $cartItems = array_values($cart);
            $cartTotal = 0;
            foreach ($cartItems as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
            $shippingFee = $cartTotal > 0 ? 100 : 0;
            $grandTotal = $cartTotal + $shippingFee;

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product removed from cart.',
                'removed_product_id' => $productId,
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'cart_total' => $cartTotal,
                'shipping_fee' => $shippingFee,
                'grand_total' => $grandTotal,
                'is_empty' => empty($cart)
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Product not found in cart.'
        ]);
    }

    public function index()
    {
        $data = [
            'title' => 'Kathy\'s Crochet Flower - Home'
        ];
        return view('customer/page/index', $data);
    }

    public function viewCart()
    {
        $cart = session()->get('cart') ?? [];
        $cartItems = array_values($cart);

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = 0;
        if ($cartTotal > 0) {
            $shippingFee = 100;
        }

        $data = [
            'title' => "Kathy's Crochet Flower - Shopping Cart",
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartCount' => array_sum(array_column($cartItems, 'quantity')),
            'shippingFee' => $shippingFee,
            'categories' => $categories,
        ];
        return view('customer/page/cart', $data);
    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        $cartItems = array_values($cart);

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = 0;
        if ($cartTotal > 0) {
            $shippingFee = 100;
        }

        $data = [
            'title' => "Kathy's Crochet Flower - Checkout",
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'shippingFee' => $shippingFee,
        ];
        return view('customer/page/checkout', $data);
    }

    public function buyNow()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');

        if (!$productId || $quantity < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid product or quantity.'
            ]);
        }

        $productModel = new ProductModel();
        $product = $productModel
            ->select('products.*, categories.category_name')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->where('products.product_id', $productId)
            ->first();

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        if (isset($product['stock'])) {
            if ($quantity > $product['stock']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Only {$product['stock']} units available in stock."
                ]);
            }

            if ($product['stock'] <= 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'This product is out of stock.'
                ]);
            }
        }

        $cart = [
            $productId => [
                'product_id' => $productId,
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'category_name' => $product['category_name'],
                'quantity' => $quantity,
                'stock' => isset($product['stock']) ? $product['stock'] : null
            ]
        ];
        session()->set('cart', $cart);

        return $this->response->setJSON([
            'success' => true,
            'redirect' => site_url('kathys_crochet_flowers/checkout')
        ]);
    }

    public function orders()
    {
        if (session()->get('role') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $orderModel = new \App\Models\OrderModel();
        $userId = session()->get('user_id');

        $orders = $orderModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'My Orders',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'orders' => $orders,
        ];

        return view('customer/page/orders', $data);
    }

    public function orderDetails($orderId)
    {
        if (session()->get('role') !== 'customer') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $addressModel = new \App\Models\AddressModel();
        $phoneModel = new \App\Models\PhoneNumberModel();
        $userId = session()->get('user_id');

        $order = $orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/kathys_crochet_flowers/orders')->with('error', 'Order not found');
        }

        $items = $orderItemModel
            ->select('order_items.*, products.product_name, products.image')
            ->join('products', 'products.product_id = order_items.product_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->findAll();

        $address = $addressModel->where('user_id', $userId)->first();
        $phone = $phoneModel->where('user_id', $userId)->first();

        $data = [
            'title' => 'Order Details #' . $orderId,
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'order' => $order,
            'items' => $items,
            'address' => $address,
            'phone' => $phone,
        ];

        return view('customer/page/order-details', $data);
    }

    public function cancelOrder()
    {
        // Ensure user is logged in
        if (session()->get('role') !== 'customer') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        $orderId = $this->request->getPost('order_id');
        $userId = session()->get('user_id');

        if (!$orderId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid order ID'
            ]);
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        // Verify order exists and belongs to current user
        if (!$order || $order['user_id'] != $userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Order not found or access denied'
            ]);
        }

        // Check if order can be cancelled (not already cancelled or delivered)
        if (in_array($order['status'], ['cancelled', 'delivered'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This order cannot be cancelled (already ' . $order['status'] . ')'
            ]);
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Restore product stock
            $orderItemModel = new OrderItemModel();
            $productModel = new ProductModel();

            $orderItems = $orderItemModel->where('order_id', $orderId)->findAll();

            foreach ($orderItems as $item) {
                $product = $productModel->find($item['product_id']);
                if ($product) {
                    $newStock = $product['stock'] + $item['quantity'];
                    $productModel->update($item['product_id'], ['stock' => $newStock]);
                }
            }

            // Update order status to cancelled
            $orderModel->update($orderId, [
                'status' => 'cancelled',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Order cancelled successfully. Stock has been restored.'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Order cancellation failed: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to cancel order. Please try again.'
            ]);
        }
    }

   
}
