<?php

namespace App\Models;

use CodeIgniter\Model;

class PhoneNumberModel extends Model
{
    protected $table      = 'phone_numbers';
    protected $primaryKey = 'phone_id';

    protected $allowedFields = [
        'user_id',
        'phone_number',
        'type',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}