<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'isi',
        'status',
        'foto',
        'catatan_admin',
        'foto_proses',
        'lokasi_text',   // <--- penting
        'lokasi_maps',   // <--- penting
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}
