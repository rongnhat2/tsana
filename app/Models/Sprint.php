<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
    protected $table = 'sprint';
    protected $fillable = ['project_id', 'name', 'type', 'start_data', 'end_date', 'status', 'created_at', 'updated_at'];
}
