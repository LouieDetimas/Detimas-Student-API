<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'nickname',
    ];

    protected $visible = [
        'id',
        'firstname',
        'lastname',
        'age',
        'nickname',
    ];
}
