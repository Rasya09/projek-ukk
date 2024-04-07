<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'address',
        'role', // Jika Anda menambahkan kolom role
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function comments()
    {
        return $this->hasMany(KomentarFoto::class, 'userid');
    }

    public function likes()
    {
        return $this->hasMany(LikeFoto::class, 'userid');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followings', 'user_id', 'following_id');
    }

    public function savedPhotos()
    {
        return $this->belongsToMany(Foto::class, 'save_photos', 'user_id', 'photo_id')->withTimestamps();
    }

}
