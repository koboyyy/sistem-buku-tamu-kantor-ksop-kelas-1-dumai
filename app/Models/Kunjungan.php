<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'id_tamu',
        'id_bidang',
        'id_subbagian',
        'tanggal_kunjungan',
        'jam_masuk',
        'jam_keluar',
        'nomor_antrian',
        'status_kunjungan', // pending | diterima | ditolak
        'is_served',
        'keperluan',
        'keterangan',
    ];

    // Relasi ke Tamu
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'id_tamu');
    }

    // Relasi ke Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang');
    }

    // Relasi ke Subbagian
    public function subbagian()
    {
        return $this->belongsTo(Subbagian::class, 'id_subbagian');
    }

    // Relasi ke Log Status
    public function logStatuses()
    {
        return $this->hasMany(LogStatus::class, 'id_kunjungan');
    }

    // Auto tolak kunjungan yang sudah lewat tanggal dan jam
    public static function autoTolakExpired()
    {
        $now = now();
        $expired = self::where('status_kunjungan', 'pending')
            ->where(function($query) use ($now) {
                $query->whereDate('tanggal_kunjungan', '<', $now->toDateString())
                      ->orWhere(function($sub) use ($now) {
                          $sub->whereDate('tanggal_kunjungan', '=', $now->toDateString())
                              ->whereTime('jam_masuk', '<=', $now->toTimeString());
                      });
            })
            ->get();

        foreach ($expired as $item) {
            $item->update([
                'status_kunjungan' => 'ditolak',
                'keterangan' => 'Otomatis dibatalkan karena belum diverifikasi oleh admin hingga jam kunjungan yang ditentukan.'
            ]);

            \App\Models\LogStatus::create([
                'id_kunjungan' => $item->id_kunjungan,
                'id_admin' => 1, // Admin System
                'status' => 'ditolak',
                'waktu_update' => now(),
            ]);
        }
    }

    // Generate nomor antrian otomatis
    public static function generateNomorAntrian($id_bidang, $id_subbagian, $tanggal_kunjungan = null)
    {
        $bidang = \App\Models\Bidang::find($id_bidang);
        $namaBidang = $bidang ? $bidang->nama_bidang : '';

        // Logika Inisial Bidang
        if (preg_match('/\((.*?)\)/', $namaBidang, $match)) {
            $bidangPrefix = strtoupper($match[1]);
        } else {
            $words = explode(' ', $namaBidang);
            $bidangPrefix = '';
            foreach ($words as $w) {
                if (!in_array(strtolower($w), ['dan', 'ke', 'di', 'si', 'bagian', 'bidang'])) {
                    $bidangPrefix .= strtoupper(substr($w, 0, 1));
                }
            }
        }
        if (empty($bidangPrefix)) {
            $bidangPrefix = 'A';
        }

        // Logika Inisial Subbagian
        $subPrefix = '';
        if ($id_subbagian) {
            $subbagian = \App\Models\Subbagian::find($id_subbagian);
            $namaSub = $subbagian ? $subbagian->nama_subbagian : '';

            if ($namaSub) {
                if (preg_match('/\((.*?)\)/', $namaSub, $match)) {
                    $content = $match[1];
                    if (strpos($content, ',') !== false) {
                        $content = explode(',', $content)[0];
                    }
                    $subPrefix = strtoupper(trim($content));
                } else {
                    $words = explode(' ', $namaSub);
                    $filteredWords = [];
                    foreach ($words as $w) {
                        $cleanW = preg_replace('/[^a-zA-Z]/', '', $w);
                        if ($cleanW && !in_array(strtolower($cleanW), ['dan', 'ke', 'di', 'si', 'bagian', 'subbag', 'seksi'])) {
                            $filteredWords[] = $cleanW;
                        }
                    }

                    if (count($filteredWords) === 1) {
                        $subPrefix = strtoupper(substr($filteredWords[0], 0, 3));
                    } else {
                        foreach ($filteredWords as $fw) {
                            $subPrefix .= strtoupper(substr($fw, 0, 1));
                        }
                    }
                }
            }
        }

        // Gabungkan Bidang dan Subbagian ke dalam satu Prefix
        $prefix = $bidangPrefix . ($subPrefix ? '-' . $subPrefix : '');

        // Cari nomor antrian terakhir untuk bidang ini yang memiliki prefix tersebut secara global
        $lastKunjungan = self::where('id_bidang', $id_bidang)
            ->where('nomor_antrian', 'like', $prefix . '-%')
            ->get()
            ->filter(function($k) {
                return preg_match('/\d+$/', $k->nomor_antrian);
            })
            ->sortByDesc(function($k) {
                preg_match('/(\d+)$/', $k->nomor_antrian, $matches);
                return (int) $matches[1];
            })
            ->first();

        if ($lastKunjungan) {
            preg_match('/(\d+)$/', $lastKunjungan->nomor_antrian, $matches);
            $lastNum = (int) $matches[1];
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }

        // Format hasil: LALA-BIMUS-001 atau TATU-KK-001
        return $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }
}
