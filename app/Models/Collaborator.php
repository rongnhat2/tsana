<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;
    protected $table = 'collaborator';
    protected $fillable = ['customer_id', 'team_id', 'status', 'created_at', 'updated_at'];
}
