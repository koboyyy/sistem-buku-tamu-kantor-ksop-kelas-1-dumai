<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStatus extends Model
{
    use HasFactory;

    protected $table = 'log_status';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_kunjungan',
        'id_admin',
        'status',
        'waktu_update',
    ];

    protected $casts = [
        'waktu_update' => 'datetime',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'id_kunjungan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
