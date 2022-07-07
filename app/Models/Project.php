<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $fillable = ['customer_id', 'name', 'description', 'privacy', 'type', 'status', 'created_at', 'updated_at'];
}
