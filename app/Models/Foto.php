<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $fillable = ['judulfoto', 'deskripsifoto', 'tanggalunggah', 'lokasifile', 'album_id', 'user_id'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(KomentarFoto::class, 'fotoid');
    }

    public function likes()
    {
        return $this->hasMany(LikeFoto::class, 'fotoid');
    }

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'save_photos', 'photo_id', 'user_id')->withTimestamps();
    }
}
