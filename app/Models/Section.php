<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'section';
    protected $fillable = ['sprint_id', 'name', 'privacy', 'status', 'created_at', 'updated_at'];
}
