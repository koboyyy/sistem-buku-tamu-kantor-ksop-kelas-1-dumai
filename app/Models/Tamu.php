<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Tamu extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tamu';
    protected $primaryKey = 'id_tamu';

    protected $fillable = [
        'nama',
        'instansi',
        'no_hp',
        'alamat',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    // Relasi: satu tamu memiliki banyak kunjungan
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'id_tamu');
    }
}
