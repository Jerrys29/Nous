<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'logo', 
        'offre', 
        'detail', 
        'statut', 
    ];
}
