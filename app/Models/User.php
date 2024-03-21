<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'pseudo',
        'email',
        'role',
        'numero',
        'town',
        'password',
        'birthdate',
        'birthplace',
        'genre',
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
        'photo6',
        'active',
        'paiement',
        'created_at',
        'updated_at',
        'role',
        'age',
        'about',
        'interests',
        'paiement',
        'paiement_date',
        'activated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
        'active' => 'boolean',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class, 'liked_by');
    }

    public function likedProfiles()
    {
        return $this->belongsToMany(User::class, 'likes', 'liked_by', 'like_to')
            ->withPivot('created_at', 'updated_at');
    }

    public function hasLikedProfile($profileId)
    {
        return $this->likedProfiles()->where('like_to', $profileId)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            // Envoyer un e-mail à chaque nouvelle inscription
            self::sendNewUserNotification($user);
        });
    }

    protected static function sendNewUserNotification($user)
    {
        $subject = "Nouvelle inscription sur Karaoke ou Nous";
        $message = "Veuillez activer le compte de : \n";
        $message .= "Pseudo : {$user->pseudo}\n";
        $message .= "Utilisateur de : {$user->role}\n";
        $message .= "Heure d'inscription : {$user->created_at}\n";

        $emails = ['julioayotognon@mail.com', 'ayojerrystognon@gmail.com'];

        foreach ($emails as $email) {
            Mail::raw($message, function ($m) use ($email, $subject) {
                $m->to($email)->subject($subject);
            });
        }
    }
}
