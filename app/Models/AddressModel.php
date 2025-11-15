<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table      = 'addresses';
    protected $primaryKey = 'address_id';

    protected $allowedFields = [
        'user_id',
        'address',
        'city',
        'province',
        'postal_code',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}