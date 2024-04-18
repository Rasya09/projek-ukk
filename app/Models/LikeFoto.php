<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeFoto extends Model
{
    use HasFactory;

    protected $table = 'likefoto';

    protected $fillable = ['fotoid', 'userid', 'tanggallike'];

    public function foto()
    {
        return $this->belongsTo(Foto::class, 'fotoid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
