<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username',
        'password',
        'nama_admin',
        'role',
    ];

    protected $hidden = ['password'];

    // Relasi: satu admin memiliki banyak log status
    public function logStatuses()
    {
        return $this->hasMany(LogStatus::class, 'id_admin');
    }
}
