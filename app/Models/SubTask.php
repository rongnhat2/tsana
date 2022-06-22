<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = 'sub_task';
    protected $fillable = ['task_id', 'description', 'status', 'created_at', 'updated_at'];
}
