<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'comment',
        'updated_at',
    'created_at',
    ];

}