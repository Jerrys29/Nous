<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'pseudo',
        'numero',
        'town',
        'password',
        'birthdate',
        'birthplace',
        'looking_for',
        'mariatal_status',
        'hair_color',
        'eyes_color',
        'origin_country',
        'espace',
        'photo1',
        'photo2',
        'photo3',
        'photo4',
        'photo5',
        'active',
        'paiement',
        'created_at',
        'updated_at',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
