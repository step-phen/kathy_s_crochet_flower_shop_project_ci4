<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'product_id';

    protected $allowedFields = [
        'product_name',
        'image',
        'description',
        'price',
        'stock',
        'category_id',
        'created_at',
        'status' // New field for product status high stock, low stock, out of stock
    ];

    protected $useTimestamps = false; // Since created_at is handled by MySQL default

    public function addFlower($data)
    {
        $stock = intval($data['stock']);
        if ($stock == 0) {
            $data['status'] = 'out of stock';
        } elseif ($stock > 0 && $stock <= 20) {
            $data['status'] = 'low stock';
        } elseif ($stock >= 21) {
            $data['status'] = 'high stock';
        } else {
            $data['status'] = null;
        }

        return $this->insert($data);
    }
}
