<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMaster extends Model
{
    use HasFactory;

    protected $table = 'role_master'; // Ensure the table name is correct

    protected $fillable = [
        'role_name',
    ];
}
