<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarFoto extends Model
{
    protected $fillable = ['fotoid', 'userid', 'isikomentar', 'tanggalkomentar'];

    public function foto()
    {
        return $this->belongsTo(Foto::class, 'fotoid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
