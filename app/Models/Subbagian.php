<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subbagian extends Model
{
    use HasFactory;

    protected $table = 'subbagian';
    protected $primaryKey = 'id_subbagian';
    protected $fillable = ['id_bidang', 'nama_subbagian'];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang');
    }

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'id_subbagian');
    }
}
