<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTask extends Model
{
    use HasFactory;
    protected $table = 'section_task';
    protected $fillable = ['section_id', 'task_id', 'status', 'created_at', 'updated_at'];
}
