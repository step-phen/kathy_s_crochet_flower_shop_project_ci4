<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class StaffController extends Controller
{
    public function dashboard()
    {
        // Make sure only staff can access
        if (session()->get('role') !== 'staff') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }
        $staff = [
            'name'        => session()->get('name'),
            'email'       => session()->get('email'),
            'phone'       => session()->get('phone'),
            'role'        => session()->get('role'),
            'created_at'  => session()->get('created_at'),
            'profile_image' => session()->get('image'),
        ];

        // Fetch flower stats
        $productModel = model('ProductModel');
        $flowers = $productModel->findAll();

        $totalFlowerStock = 0;
        $lowStock = 0;
        $outOfStock = 0;
        $inventoryItems = count($flowers);

        foreach ($flowers as $flower) {
            $stock = (int)($flower['stock'] ?? 0);
            $totalFlowerStock += $stock;
            if ($stock == 0) {
                $outOfStock++;
            } elseif ($stock < 20) {
                $lowStock++;
            }
        }

        $stats = [
            'total_flower_stock' => $totalFlowerStock,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock,
            'inventory_items' => $inventoryItems,
        ];

        $data = [
            'title' => 'Kathy\'s Crochet Flower - Staff Dashboard',
            'staff' => $staff,
            'stats' => $stats,
        ];

        return view('staff/page/dashboard', $data);
    }

    public function inventory()
    {
        // Make sure only staff can access
        if (session()->get('role') !== 'staff') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $staff = [
            'name'        => session()->get('name'),
            'email'       => session()->get('email'),
            'phone'       => session()->get('phone'),
            'role'        => session()->get('role'),
            'created_at'  => session()->get('created_at'),
            'profile_image' => session()->get('image'),
        ];

        // Fetch flower items from ProductModel
        $productModel = model('ProductModel');
        $flowers = $productModel
            ->select('products.product_id, product_name, category_name as category, products.stock, products.price, products.image')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->findAll();

        $data = [
            'title' => 'Kathy\'s Crochet Flower - Inventory Management',
            'staff' => $staff,
            'flowers' => $flowers,
        ];

        return view('staff/page/inventory', $data);
    }

    public function reports()
    {
        // Make sure only staff can access
        if (session()->get('role') !== 'staff') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $staff = [
            'name'        => session()->get('name'),
            'email'       => session()->get('email'),
            'phone'       => session()->get('phone'),
            'role'        => session()->get('role'),
            'created_at'  => session()->get('created_at'),
            'profile_image' => session()->get('image'),
        ];

        $data = [
            'title' => 'Kathy\'s Crochet Flower - Inventory Reports',
            'staff'  => $staff,
        ];

        return view('staff/page/reports', $data);
    }

    public function getDailyReport()
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $db = \Config\Database::connect();
        $builder = $db->table('order_items oi');

        // Get stock sold per product for the specified date (excluding cancelled orders)
        $builder->select('p.product_name as flower, 
                          SUM(oi.quantity) as stock_sold,
                          p.stock as current_stock,
                          p.product_id')
            ->join('orders o', 'o.order_id = oi.order_id')
            ->join('products p', 'p.product_id = oi.product_id')
            ->where('o.date', $date)
            ->whereNotIn('o.status', ['cancelled'])
            ->groupBy('oi.product_id, p.product_name, p.stock, p.product_id');

        $soldData = $builder->get()->getResultArray();

        // Get all products for complete report
        $productModel = model('ProductModel');
        $allProducts = $productModel->findAll();

        $reportData = [];
        foreach ($allProducts as $product) {
            $sold = 0;
            foreach ($soldData as $soldItem) {
                if ($soldItem['product_id'] == $product['product_id']) {
                    $sold = $soldItem['stock_sold'];
                    break;
                }
            }

            $reportData[] = [
                'date' => $date,
                'flower' => $product['product_name'],
                'stock_sold' => $sold,
                'current_stock' => $product['stock']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $reportData,
            'chart' => $this->prepareChartData($reportData, 'flower')
        ]);
    }

    /**
     * Get weekly report data via AJAX
     */
    public function getWeeklyReport()
    {
        $week = $this->request->getGet('week') ?? date('Y') . '-W' . date('W');

        // Parse week format (e.g., "2025-W45")
        list($year, $weekNum) = explode('-W', $week);
        $dto = new \DateTime();
        $dto->setISODate($year, $weekNum);
        $startDate = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $endDate = $dto->format('Y-m-d');

        $db = \Config\Database::connect();
        $builder = $db->table('order_items oi');

        $builder->select('p.product_name as flower,
                          SUM(oi.quantity) as stock_sold,
                          p.stock as current_stock,
                          p.product_id')
            ->join('orders o', 'o.order_id = oi.order_id')
            ->join('products p', 'p.product_id = oi.product_id')
            ->where('o.date >=', $startDate)
            ->where('o.date <=', $endDate)
            ->whereNotIn('o.status', ['cancelled'])
            ->groupBy('oi.product_id, p.product_name, p.stock, p.product_id');

        $soldData = $builder->get()->getResultArray();

        $productModel = model('ProductModel');
        $allProducts = $productModel->findAll();

        $reportData = [];
        foreach ($allProducts as $product) {
            $sold = 0;
            foreach ($soldData as $soldItem) {
                if ($soldItem['product_id'] == $product['product_id']) {
                    $sold = $soldItem['stock_sold'];
                    break;
                }
            }

            $reportData[] = [
                'week' => $week,
                'flower' => $product['product_name'],
                'stock_sold' => $sold,
                'current_stock' => $product['stock']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $reportData,
            'chart' => $this->prepareChartData($reportData, 'flower')
        ]);
    }

    /**
     * Get monthly report data via AJAX
     */
    public function getMonthlyReport()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');
        
        $db = \Config\Database::connect();
        $builder = $db->table('order_items oi');
        
        $builder->select('p.product_name as flower,
                          SUM(oi.quantity) as stock_sold,
                          p.stock as current_stock,
                          p.product_id')
                ->join('orders o', 'o.order_id = oi.order_id')
                ->join('products p', 'p.product_id = oi.product_id')
                ->where('DATE_FORMAT(o.date, "%Y-%m")', $month)
                ->whereNotIn('o.status', ['cancelled'])
                ->groupBy('oi.product_id, p.product_name, p.stock, p.product_id');
        
        $soldData = $builder->get()->getResultArray();

        $productModel = model('ProductModel');
        $allProducts = $productModel->findAll();

        $reportData = [];
        foreach ($allProducts as $product) {
            $sold = 0;
            foreach ($soldData as $soldItem) {
                if ($soldItem['product_id'] == $product['product_id']) {
                    $sold = $soldItem['stock_sold'];
                    break;
                }
            }

            $reportData[] = [
                'month' => $month,
                'flower' => $product['product_name'],
                'stock_sold' => $sold,
                'current_stock' => $product['stock']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $reportData,
            'chart' => $this->prepareChartData($reportData, 'flower')
        ]);
    }

    /**
     * Helper method to prepare chart data
     */
    private function prepareChartData($reportData, $labelField)
    {
        $labels = [];
        $stockSold = [];
        $currentStock = [];

        foreach ($reportData as $row) {
            if ($row['stock_sold'] > 0 || $row['current_stock'] > 0) {
                $labels[] = $row[$labelField];
                $stockSold[] = $row['stock_sold'];
                $currentStock[] = $row['current_stock'];
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Stock Sold',
                    'data' => $stockSold,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'tension' => 0.1
                ],
                [
                    'label' => 'Current Stock',
                    'data' => $currentStock,
                    'borderColor' => 'rgb(54, 162, 235)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'tension' => 0.1
                ]
            ]
        ];
    }
    
    public function updateStock()
    {
        if ($this->request->isAJAX()) {
            $productId = $this->request->getPost('product_id');
            $addStock = (int)$this->request->getPost('add_stock');
            $productModel = model('ProductModel');
            $product = $productModel->find($productId);

            if ($product && $addStock > 0) {
                $newStock = $product['stock'] + $addStock;
                $productModel->update($productId, ['stock' => $newStock]);
                return $this->response->setJSON([
                    'success' => true,
                    'new_stock' => $newStock
                ]);
            }
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid product or stock value.'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request.'
        ]);
    }

    public function profile()
    {
        // Make sure only staff can access
        if (session()->get('role') !== 'staff') {
            return redirect()->to('/login')->with('error', 'Access denied');
        }

        $staff = [
            'name'        => session()->get('name'),
            'email'       => session()->get('email'),
            'phone'       => session()->get('phone'),
            'role'        => session()->get('role'),
            'created_at'  => session()->get('created_at'),
            'profile_image' => session()->get('image'),
            'user_id'     => session()->get('user_id'),
        ];

        // Fetch address from AddressModel
        $addressModel = model('AddressModel');
        $address = $addressModel->where('user_id', $staff['user_id'])->orderBy('address_id', 'desc')->first();
        if ($address) {
            $staff['address'] = $address['address'] ?? '';
            $staff['city'] = $address['city'] ?? '';
            $staff['province'] = $address['province'] ?? '';
            $staff['postal_code'] = $address['postal_code'] ?? '';
        } else {
            $staff['address'] = '';
            $staff['city'] = '';
            $staff['province'] = '';
            $staff['postal_code'] = '';
        }

        // Fetch phone number from PhoneNumberModel
        $phoneModel = model('PhoneNumberModel');
        $phone = $phoneModel->where('user_id', $staff['user_id'])->orderBy('phone_id', 'desc')->first();
        if ($phone) {
            $staff['phone'] = $phone['phone_number'] ?? '';
        } else {
            $staff['phone'] = '';
        }

        $data = [
            'title' => "Kathy's Crochet Flower - Staff Profile",
            'staff' => $staff
        ];
        return view('staff/page/profile', $data);
    }
}
