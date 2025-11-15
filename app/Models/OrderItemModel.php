<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    protected $allowedFields = [
        'order_id', 'product_id', 'product_name', 'price', 'quantity', 'subtotal'
    ];
    protected $returnType = 'array';
    public $timestamps = false;
}
