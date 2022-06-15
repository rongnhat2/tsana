<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $fillable = ['secret_key', 'email', 'password', 'verify_code', 'provider', 'status', 'created_at', 'updated_at'];
}
