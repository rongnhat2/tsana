<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProject extends Model
{
    use HasFactory;
    protected $table = 'customer_project';
    protected $fillable = ['customer_id', 'project_id', 'status', 'created_at', 'updated_at'];
}
