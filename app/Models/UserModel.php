<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel  extends Model
{
    protected $table = 'tbl_staff';
    protected $primaryKey = 'staff_id';
    protected $allowedFields = [
        'username',
        'password',
        'gender',
        'phone',
        'email',
        'address',
        'role',
        'image',
        'reg_date',
        'status',


    ];
    protected $useTimestamps = false; // change to true if you have `created_at` or `updated_at` columns
}
