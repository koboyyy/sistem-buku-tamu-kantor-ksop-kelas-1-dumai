<?php
// ===== Bidang.php =====
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';
    protected $primaryKey = 'id_bidang';
    protected $fillable = ['nama_bidang', 'deskripsi'];

    public function subbagians()
    {
        return $this->hasMany(Subbagian::class, 'id_bidang');
    }

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'id_bidang');
    }
}
