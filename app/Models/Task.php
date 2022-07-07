<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    protected $fillable = ['customer_created', 'customer_assign', 'customer_task_id', 'project_id', 'name', 'start_date', 'end_date', 'type', 'priority', 'description', 'status', 'created_at', 'updated_at'];
}
