<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $allowedFields = [
        'user_id',
        'name',
        'mobile',
        'email',
        'city',
        'province',
        'zip',
        'date',
        'address',
        'notes',
        'payment_method',   // only 'gcash' or 'cod'
        'gcash_reference',
        'gcash_image',
        'subtotal',
        'shipping_fee',
        'total',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';

    // Auto-manage timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: add validation rules
    protected $validationRules = [
        'payment_method' => 'in_list[gcash,cod]',
        'email'          => 'valid_email',
        'subtotal'       => 'decimal',
        'shipping_fee'   => 'decimal',
        'total'          => 'decimal'
    ];

    protected $validationMessages = [
        'payment_method' => [
            'in_list' => 'Payment method must be either GCash or COD.'
        ]
    ];
}
