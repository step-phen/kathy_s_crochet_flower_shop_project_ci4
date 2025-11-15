<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\AddressModel;
use App\Models\PhoneNumberModel;

class AdminController extends Controller
{
    /**
     * Handle Add Category AJAX request
     */
    public function addCategory()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        $validation = \Config\Services::validation();
        $rules = [
            'category_name' => 'required|min_length[2]'
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please enter a valid category name.',
                'errors' => $validation->getErrors()
            ]);
        }

        $categoryModel = new \App\Models\CategoryModel();
        $categoryName = $this->request->getPost('category_name');
        $now = date('Y-m-d H:i:s');
        $data = [
            'category_name' => $categoryName,
            'created_at'    => $now,
        ];

        $insert = $categoryModel->insert($data);
        if ($insert === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add category.',
                'errors' => $categoryModel->errors()
            ]);
        }

        $insertId = $categoryModel->getInsertID();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Category added successfully!',
            'category' => [
                'category_id' => $insertId,
                'category_name' => $categoryName,
                'created_at' => $now,
            ]
        ]);
    }

    /**
     * AJAX: Return product table rows HTML for dynamic refresh
     */
    public function productList()
    {
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->orderBy('product_id', 'desc')->findAll();

        $rows = '';
        foreach ($products as $prod) {
            $rows .= '<tr>';
            $rows .= '<td><div class="d-flex align-items-center gap-2">';
            if (!empty($prod['image'])) {
                $rows .= '<img src="' . base_url($prod['image']) . '" alt="Product Image" style="width:40px;height:40px;object-fit:cover;">';
            }
            $rows .= '<div>';
            $rows .= '<div class="fw-bold mb-1">' . esc($prod['product_name']) . '</div>';
            $rows .= '<div class="text-muted small">ID: ' . esc($prod['product_id']) . '</div>';
            $rows .= '</div>';
            $rows .= '</div></td>';
            $rows .= '<td>' . esc($prod['category_id']) . '</td>';
            $rows .= '<td>' . esc($prod['price']) . '</td>';
            $rows .= '<td>' . esc($prod['stock']) . '</td>';
            $stock = intval($prod['stock']);
            if ($stock > 10) {
                $rows .= '<td><span class="badge bg-success">High Stock</span></td>';
            } elseif ($stock > 0) {
                $rows .= '<td><span class="badge bg-warning text-dark">Low Stock</span></td>';
            } else {
                $rows .= '<td><span class="badge bg-danger">Out of Stock</span></td>';
            }
            $rows .= '<td><button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></button></td>';
            $rows .= '</tr>';
        }

        if ($this->request->getGet('withCount')) {
            return $this->response->setJSON([
                'html' => $rows,
                'count' => count($products)
            ]);
        }
        return $this->response->setBody($rows);
    }

    /**
     * Handle Add Product form submission
     */
    public function addProduct()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        $validation = \Config\Services::validation();
        $rules = [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please fill all required fields.',
                'errors' => $validation->getErrors()
            ]);
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imagePath = null;
        if ($image && $image->isValid()) {
            $originalName = $image->getName();
            $image->move('uploads/products', $originalName);
            $imagePath = 'uploads/products/' . $originalName;
        }

        $productModel = new \App\Models\ProductModel();
        $data = [
            'product_name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image' => $imagePath,
        ];

        $insert = $productModel->insert($data);
        if ($insert === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add product.',
                'errors' => $productModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Product added successfully!'
        ]);
    }

    public function updateProfile()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $userModel = new UserModel();
        $addressModel = new AddressModel();
        $phoneModel = new PhoneNumberModel();

        $admin = $userModel->where('email', session()->get('email'))->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found');
        }
        $userId = $admin['user_id'];

        // Validate input
        $validation = \Config\Services::validation();
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Please fill all required fields.');
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imagePath = $admin['image'] ?? null;
        if ($image && $image->isValid()) {
            $originalName = $image->getName();
            $image->move('uploads/staff', $originalName, true);
            $imagePath = $originalName;
        }

        // Update user table
        $userModel->update($userId, [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'image' => $imagePath,
        ]);

        // Update address table
        $addressData = [
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
        ];
        $address = $addressModel->where('user_id', $userId)->first();
        if ($address) {
            $addressModel->update($address['address_id'], $addressData);
        } else {
            $addressData['user_id'] = $userId;
            $addressModel->insert($addressData);
        }

        // Update phone table
        $phone = $phoneModel->where('user_id', $userId)->first();
        $phoneData = [
            'phone_number' => $this->request->getPost('phone'),
        ];
        if ($phone) {
            $phoneModel->update($phone['phone_id'], $phoneData);
        } else {
            $phoneData['user_id'] = $userId;
            $phoneModel->insert($phoneData);
        }

        return redirect()->to(base_url('admin/profile'))->with('success', 'Profile updated successfully!');
    }

    public function dashboard()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $userModel = new UserModel();
        $productModel = new \App\Models\ProductModel();

        $totalCustomers = $userModel->whereIn('role', ['customer', 'Customer'])->countAllResults();
        $totalProducts = $productModel->countAllResults();

        $data = [
            'title' => 'Admin Dashboard',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'stats' => [
                'total_users' => $totalCustomers,
                'total_products' => $totalProducts,
            ]
        ];

        return view('admin/page/dashboard', $data);
    }

    public function profile()
    {
        $userModel = new UserModel();
        $addressModel = new AddressModel();
        $phoneModel = new PhoneNumberModel();

        $admin = $userModel->where('email', session()->get('email'))->first();

        if ($admin && isset($admin['user_id'])) {
            $address = $addressModel->where('user_id', $admin['user_id'])->first();
            if ($address) {
                $admin['address'] = $address['address'] ?? '';
                $admin['city'] = $address['city'] ?? '';
                $admin['province'] = $address['province'] ?? '';
                $admin['postal_code'] = $address['postal_code'] ?? '';
            }
            $phone = $phoneModel->where('user_id', $admin['user_id'])->first();
            if ($phone) {
                $admin['phone'] = $phone['phone_number'] ?? '';
            }
            $admin['role'] = $admin['role'] ?? '';
        }

        $data = [
            'title' => 'Admin Profile',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'role' => $admin['role'] ?? '',
            'admin' => $admin,
        ];

        return view('admin/page/profile', $data);
    }

    public function manageStaff()
    {
        $userModel = new \App\Models\UserModel();
        $phoneModel = new \App\Models\PhoneNumberModel();
        $addressModel = new \App\Models\AddressModel();

        $users = $userModel->whereIn('role', ['staff'])->findAll();

        foreach ($users as &$u) {
            $phone = $phoneModel->where('user_id', $u['user_id'])->first();
            $u['phone_number'] = $phone['phone_number'] ?? '';
            $u['status_text'] = (isset($u['status']) && intval($u['status']) === 1) ? 'Active' : 'Inactive';
            $address = $addressModel->where('user_id', $u['user_id'])->first();
            $u['address'] = $address['address'] ?? '';
            $u['city'] = $address['city'] ?? '';
            $u['province'] = $address['province'] ?? '';
            $u['postal_code'] = $address['postal_code'] ?? '';
        }
        unset($u);

        $total = count($users);
        $active = count(array_filter($users, function ($u) {
            return isset($u['status']) && intval($u['status']) === 1;
        }));
        $inactive = $total - $active;

        $data = [
            'title' => 'Manage Staff',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'staff' => $users,
            'totalStaff' => $total,
            'activeStaff' => $active,
            'inactiveStaff' => $inactive,
        ];

        return view('admin/page/manage-staff', $data);
    }

    public function saveStaff()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'          => 'required',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'phone_number'  => 'required',
            'address'       => 'required',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required',
            'role'          => 'required',
            'status'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $image = $this->request->getFile('image');
        $imagePath = null;

        if ($image && $image->isValid()) {
            $originalName = $image->getName();
            $image->move('uploads/staff', $originalName, true);
            $imagePath = 'uploads/staff/' . $originalName;
        }

        $status = $this->request->getPost('status') === 'Active' ? 1 : 0;
        $userData = [
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash('staff123', PASSWORD_DEFAULT),
            'role'          => 'staff',
            'image'         => $imagePath,
            'status'        => $status,
        ];

        $userModel = new \App\Models\UserModel();
        $userInsert = $userModel->insert($userData);

        if ($userInsert === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $userModel->errors()
            ]);
        }

        $userId = $userModel->getInsertID();

        $addressData = [
            'user_id'       => $userId,
            'address'       => $this->request->getPost('address'),
            'city'          => $this->request->getPost('city'),
            'province'      => $this->request->getPost('province'),
            'postal_code'   => $this->request->getPost('postal_code'),
        ];
        $AddressModel = new \App\Models\AddressModel();
        $addressInsert = $AddressModel->insert($addressData);
        if ($addressInsert === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $AddressModel->errors()
            ]);
        }

        $phoneData = [
            'user_id'      => $userId,
            'phone_number' => $this->request->getPost('phone_number'),
        ];
        $PhoneNumberModel = new \App\Models\PhoneNumberModel();
        $phoneInsert = $PhoneNumberModel->insert($phoneData);
        if ($phoneInsert === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $PhoneNumberModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Staff created successfully!'
        ]);
    }

    public function staffList()
    {
        $userModel = new \App\Models\UserModel();
        $phoneModel = new \App\Models\PhoneNumberModel();
        $addressModel = new \App\Models\AddressModel();

        $users = $userModel->whereIn('role', ['staff', 'Staff'])->orderBy('user_id', 'DESC')->findAll();

        $rows = '';
        $total = 0;
        $active = 0;

        foreach ($users as $s) {
            $total++;
            $isActive = (isset($s['status']) && intval($s['status']) === 1);
            if ($isActive) $active++;

            $phone = $phoneModel->where('user_id', $s['user_id'])->first();
            $phoneNumber = $phone['phone_number'] ?? '';

            $address = $addressModel->where('user_id', $s['user_id'])->first();
            $addressStr = $address['address'] ?? '';
            $city = $address['city'] ?? '';
            $province = $address['province'] ?? '';
            $postal = $address['postal_code'] ?? '';

            $imgSrc = base_url('uploads/staff/default-avatar.png');
            if (!empty($s['image'])) {
                if (strpos($s['image'], 'uploads/') === 0) {
                    $imgSrc = base_url($s['image']);
                } else {
                    $imgSrc = base_url('uploads/staff/' . $s['image']);
                }
            }

            $rows .= '<tr';
            $rows .= ' data-user-id="' . esc($s['user_id']) . '"';
            $rows .= ' data-email="' . esc($s['email']) . '"';
            $rows .= ' data-address="' . esc($addressStr) . '"';
            $rows .= ' data-city="' . esc($city) . '"';
            $rows .= ' data-province="' . esc($province) . '"';
            $rows .= ' data-postal="' . esc($postal) . '"';
            $rows .= ' data-image="' . esc($imgSrc) . '"';
            $rows .= '>';

            $rows .= '<td class="text-start">' . esc($s['user_id']) . '</td>';

            $rows .= '<td>';
            $rows .= '<div class="d-flex align-items-center">';
            $rows .= '<img src="' . esc($imgSrc) . '" alt="Profile" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;">';
            $rows .= '<div>';
            $rows .= '<div class="fw-semibold">' . esc($s['name']) . '</div>';
            $rows .= '<div class="text-muted small">' . esc($s['role'] ?? 'Staff') . '</div>';
            $rows .= '</div>';
            $rows .= '</div>';
            $rows .= '</td>';

            $rows .= '<td>' . esc($s['email']) . '</td>';
            $rows .= '<td class="text-start">' . esc($phoneNumber) . '</td>';

            $rows .= '<td>';
            $rows .= '<button type="button" class="btn btn-sm toggle-status-btn ' . ($isActive ? 'btn-success' : 'btn-secondary') . '"';
            $rows .= ' data-user-id="' . esc($s['user_id']) . '"';
            $rows .= ' data-status="' . ($isActive ? '1' : '0') . '">';
            $rows .= ($isActive ? 'Active' : 'Inactive');
            $rows .= '</button>';
            $rows .= '</td>';

            $rows .= '<td><a href="#" class="btn btn-sm btn-outline-primary view-staff-btn">View</a></td>';
            $rows .= '</tr>';
        }

        $inactive = $total - $active;

        return $this->response->setJSON([
            'status' => 'success',
            'html'   => $rows,
            'total'  => $total,
            'active' => $active,
            'inactive' => $inactive,
        ]);
    }

    public function customerList()
    {
        $userModel = new \App\Models\UserModel();
        $phoneModel = new \App\Models\PhoneNumberModel();
        $addressModel = new \App\Models\AddressModel();

        $customers = $userModel->whereIn('role', ['customer', 'Customer'])->findAll();

        foreach ($customers as &$c) {
            $phone = $phoneModel->where('user_id', $c['user_id'])->first();
            $c['phone'] = $phone['phone_number'] ?? '';
            $address = $addressModel->where('user_id', $c['user_id'])->first();
            $c['address'] = $address['address'] ?? '';
        }
        unset($c);

        $data = [
            'title' => 'Customer List',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'customers' => $customers,
        ];

        return view('admin/page/customer-list', $data);
    }

    public function productManagement()
    {
        $categoryModel = new \App\Models\CategoryModel();
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->findAll();
        $categories = $categoryModel->findAll();
        $data = [
            'title' => 'Product Management',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'categories' => $categories,
            'products' => $products,
        ];

        return view('admin/page/product', $data);
    }

    public function manageOrders()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $orderModel = new \App\Models\OrderModel();
        $userModel = new \App\Models\UserModel();

        $orders = $orderModel
            ->select('orders.*, users.name, users.email')
            ->join('users', 'users.user_id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manage Orders',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
            'orders' => $orders,
        ];

        return view('admin/page/manage-order', $data);
    }

    // FIXED: Update order status with proper payment status logic
    public function updateOrderStatus()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }

        $validation = \Config\Services::validation();
        $rules = [
            'order_id' => 'required|integer',
            'status' => 'required|in_list[pending,pending_verification,preparing,shipped,delivered,cancelled]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid data',
                'errors' => $validation->getErrors()
            ]);
        }

        $orderModel = new \App\Models\OrderModel();
        $orderId = $this->request->getPost('order_id');
        $newStatus = $this->request->getPost('status');

        $order = $orderModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Order not found'
            ]);
        }


            // Prepare update data (remove payment status logic)
            $updateData = [
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];

        // Update order status
        $updated = $orderModel->update($orderId, $updateData);

        if (!$updated) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update order status',
                'errors' => $orderModel->errors()
            ]);
        }

        // Get updated order with customer info
        $updatedOrder = $orderModel
            ->select('orders.*, users.name, users.email')
            ->join('users', 'users.user_id = orders.user_id', 'left')
            ->where('orders.order_id', $orderId)
            ->first();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Order status updated successfully',
            'order' => $updatedOrder
        ]);
    }

    public function getOrderDetails()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        $orderId = $this->request->getGet('order_id');
        if (!$orderId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Order ID required'
            ]);
        }

        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $addressModel = new \App\Models\AddressModel();

        $order = $orderModel
            ->select('orders.*, users.name, users.email')
            ->join('users', 'users.user_id = orders.user_id', 'left')
            ->where('orders.order_id', $orderId)
            ->first();

        if (!$order) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Order not found'
            ]);
        }

        $items = $orderItemModel
            ->select('order_items.*, products.product_name, products.image')
            ->join('products', 'products.product_id = order_items.product_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->findAll();

        $address = $addressModel->where('user_id', $order['user_id'])->first();

        return $this->response->setJSON([
            'status' => 'success',
            'order' => $order,
            'items' => $items,
            'address' => $address
        ]);
    }

    public function ordersList()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        $orderModel = new \App\Models\OrderModel();

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $builder = $orderModel
            ->select('orders.*, users.name, users.email')
            ->join('users', 'users.user_id = orders.user_id', 'left');

        if ($status && $status !== 'all') {
            $builder->where('orders.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('orders.order_id', $search)
                ->orLike('users.name', $search)
                ->orLike('users.email', $search)
                ->groupEnd();
        }

        $orders = $builder->orderBy('orders.created_at', 'DESC')->findAll();

        $rows = '';
        foreach ($orders as $order) {
            $statusBadge = '';
            switch ($order['status']) {
                case 'pending_verification':
                    $statusBadge = '<span class="badge bg-warning text-dark">Pending Verification</span>';
                    break;
                case 'pending':
                    $statusBadge = '<span class="badge bg-secondary">Pending</span>';
                    break;
                case 'processing':
                    $statusBadge = '<span class="badge bg-info text-dark">Processing</span>';
                    break;
                case 'completed':
                    $statusBadge = '<span class="badge bg-success">Completed</span>';
                    break;
                case 'cancelled':
                    $statusBadge = '<span class="badge bg-danger">Cancelled</span>';
                    break;
                default:
                    $statusBadge = '<span class="badge bg-light text-dark">Unknown</span>';
            }

            $rows .= '<tr data-order-id="' . esc($order['order_id']) . '">';
            $rows .= '<td>' . esc($order['order_id']) . '</td>';
            $rows .= '<td>' . esc($order['name']) . '</td>';
            $rows .= '<td>' . date('Y-m-d H:i', strtotime($order['created_at'])) . '</td>';
            $rows .= '<td>₱' . number_format($order['total'], 2) . '</td>';
            $rows .= '<td>' . strtoupper($order['payment_method']) . '</td>';
            $rows .= '<td class="status-cell">' . $statusBadge . '</td>';
            $rows .= '<td>';
            $rows .= '<button class="btn btn-sm btn-outline-primary view-order-btn me-1" data-order-id="' . esc($order['order_id']) . '">';
            $rows .= '<i class="bi bi-eye"></i> View</button>';
            $rows .= '<button class="btn btn-sm btn-outline-success update-status-btn" data-order-id="' . esc($order['order_id']) . '" data-current-status="' . esc($order['status']) . '">';
            $rows .= '<i class="bi bi-pencil"></i> Update</button>';
            $rows .= '</td>';
            $rows .= '</tr>';
        }

        return $this->response->setJSON([
            'status' => 'success',
            'html' => $rows,
            'count' => count($orders)
        ]);
    }

    public function salesReports()
    {
        $data = [
            'title' => 'Sales Reports',
            'user' => session()->get('name'),
            'email' => session()->get('email'),
        ];

        return view('admin/page/sales-report', $data);
    }

    public function toggleStaffStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request.'
            ]);
        }

        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        if (!$userId || !in_array($status, ['0', '1'], true)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid data.'
            ]);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }

        $userModel->update($userId, ['status' => $status]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Status updated.'
        ]);
    }

    /**
     * Get daily sales report
     */
    public function getDailySalesReport()
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $db = \Config\Database::connect();
        
        // Get orders for the date
        $orders = $db->table('orders o')
            ->select('o.order_id, o.name as customer_name, o.date as order_date, o.total, o.status, COUNT(oi.order_item_id) as total_items')
            ->join('order_items oi', 'oi.order_id = o.order_id', 'left')
            ->where('o.date', $date)
            ->whereNotIn('o.status', ['cancelled'])
            ->groupBy('o.order_id, o.name, o.date, o.total, o.status')
            ->get()
            ->getResultArray();

        // Calculate summary
        $totalRevenue = 0;
        $totalItems = 0;
        foreach ($orders as $order) {
            $totalRevenue += $order['total'];
            $totalItems += $order['total_items'];
        }
        
        $summary = [
            'total_revenue' => $totalRevenue,
            'total_orders' => count($orders),
            'total_items' => $totalItems,
            'avg_order' => count($orders) > 0 ? $totalRevenue / count($orders) : 0
        ];

        // Chart data (hourly breakdown for single day)
        $chart = [
            'labels' => [$date],
            'data' => [$totalRevenue]
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $orders,
            'summary' => $summary,
            'chart' => $chart
        ]);
    }

    /**
     * Get weekly sales report
     */
    public function getWeeklySalesReport()
    {
        $week = $this->request->getGet('week') ?? date('Y') . '-W' . date('W');

        // Parse week format
        list($year, $weekNum) = explode('-W', $week);
        $dto = new \DateTime();
        $dto->setISODate($year, $weekNum);
        $startDate = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $endDate = $dto->format('Y-m-d');

        $db = \Config\Database::connect();
        
        // Get orders for the week
        $orders = $db->table('orders o')
            ->select('o.order_id, o.name as customer_name, o.date as order_date, o.total, o.status, COUNT(oi.order_item_id) as total_items')
            ->join('order_items oi', 'oi.order_id = o.order_id', 'left')
            ->where('o.date >=', $startDate)
            ->where('o.date <=', $endDate)
            ->whereNotIn('o.status', ['cancelled'])
            ->groupBy('o.order_id, o.name, o.date, o.total, o.status')
            ->orderBy('o.date', 'ASC')
            ->get()
            ->getResultArray();

        // Calculate summary
        $totalRevenue = 0;
        $totalItems = 0;
        $dailySales = [];
        
        foreach ($orders as $order) {
            $totalRevenue += $order['total'];
            $totalItems += $order['total_items'];
            
            $orderDate = $order['order_date'];
            if (!isset($dailySales[$orderDate])) {
                $dailySales[$orderDate] = 0;
            }
            $dailySales[$orderDate] += $order['total'];
        }
        
        $summary = [
            'total_revenue' => $totalRevenue,
            'total_orders' => count($orders),
            'total_items' => $totalItems,
            'avg_order' => count($orders) > 0 ? $totalRevenue / count($orders) : 0
        ];

        // Chart data (daily breakdown)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = (clone $dto)->modify('-' . (6 - $i) . ' days')->format('Y-m-d');
            $chartLabels[] = (clone $dto)->modify('-' . (6 - $i) . ' days')->format('M d');
            $chartData[] = $dailySales[$date] ?? 0;
        }

        $chart = [
            'labels' => $chartLabels,
            'data' => $chartData
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $orders,
            'summary' => $summary,
            'chart' => $chart
        ]);
    }

    /**
     * Get monthly sales report
     */
    public function getMonthlySalesReport()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');

        $db = \Config\Database::connect();
        
        // Get orders for the month
        $orders = $db->table('orders o')
            ->select('o.order_id, o.name as customer_name, o.date as order_date, o.total, o.status, COUNT(oi.order_item_id) as total_items')
            ->join('order_items oi', 'oi.order_id = o.order_id', 'left')
            ->where('DATE_FORMAT(o.date, "%Y-%m")', $month)
            ->whereNotIn('o.status', ['cancelled'])
            ->groupBy('o.order_id, o.name, o.date, o.total, o.status')
            ->orderBy('o.date', 'ASC')
            ->get()
            ->getResultArray();

        // Calculate summary
        $totalRevenue = 0;
        $totalItems = 0;
        $dailySales = [];
        
        foreach ($orders as $order) {
            $totalRevenue += $order['total'];
            $totalItems += $order['total_items'];
            
            $orderDate = $order['order_date'];
            if (!isset($dailySales[$orderDate])) {
                $dailySales[$orderDate] = 0;
            }
            $dailySales[$orderDate] += $order['total'];
        }
        
        $summary = [
            'total_revenue' => $totalRevenue,
            'total_orders' => count($orders),
            'total_items' => $totalItems,
            'avg_order' => count($orders) > 0 ? $totalRevenue / count($orders) : 0
        ];

        // Chart data (daily breakdown for the month)
        $chartLabels = [];
        $chartData = [];
        
        // Get number of days in month
        $date = new \DateTime($month . '-01');
        $daysInMonth = $date->format('t');
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateStr = $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $chartLabels[] = $day;
            $chartData[] = $dailySales[$dateStr] ?? 0;
        }

        $chart = [
            'labels' => $chartLabels,
            'data' => $chartData
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $orders,
            'summary' => $summary,
            'chart' => $chart
        ]);
    }
}
