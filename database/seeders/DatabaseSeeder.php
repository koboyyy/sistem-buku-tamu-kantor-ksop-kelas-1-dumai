<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Tamu;
use App\Models\Bidang;
use App\Models\Subbagian;
use App\Models\Kunjungan;
use App\Models\LogStatus;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. ADMIN
        // =============================================
        $admins = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'nama_admin' => 'Administrator',
                'role' => 'superadmin',
            ],
            [
                'username' => 'petugas',
                'password' => Hash::make('petugas123'),
                'nama_admin' => 'Petugas Loket',
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $a) {
            Admin::create($a);
        }

        // =============================================
        // 2. BIDANG & SUBBAGIAN
        // =============================================
        $bidangData = [
            [
                'nama_bidang' => 'Bidang Bagian Lalu Lintas Angkutan Laut (LALA)',
                'deskripsi' => 'Menangani urusan keselamatan pelayaran dan navigasi.',
                'subbagian' => [
                    'Seksi Bimbingan Usaha (BIMUS)',
                    'Seksi LALA',
                    'Seksi Perancangan dan Pembangunan (REMBANG)'
                ],
            ],
            [
                'nama_bidang' => 'Bidang Bagian Status Hukum dan Sertifikasi Kapal',
                'deskripsi' => 'Menangani penjagaan, patroli, dan pengawasan pelabuhan.',
                'subbagian' => [
                    'Seksi Penjagaan',
                    'Seksi Patroli Laut',
                ],
            ],
            [
                'nama_bidang' => 'Bidang Bagian Tata Usaha (TATU)',
                'deskripsi' => 'Menangani administrasi umum, keuangan, dan kepegawaian.',
                'subbagian' => [
                    'Subbag Kepegawaian dan Keuangan ',
                    'Subbag Umum dan Hubungan Masyarakat',
                ],
            ],
            [
                'nama_bidang' => 'Bidang Bagian Keselamatan Berlayar, Penjagaan dan Patroli (KBPP)',
                'deskripsi' => 'Menangani penilikan kapal dan penertiban di pelabuhan.',
                'subbagian' => [
                    'Seksi Keselamatan Berlayar (Pengawakan, Pemanduan)',
                    'Seksi Penjagaan, Patroli dan Penyidik',
                ],
            ],
        ];

        $bidangModels = [];
        foreach ($bidangData as $bd) {
            $bidang = Bidang::create([
                'nama_bidang' => $bd['nama_bidang'],
                'deskripsi' => $bd['deskripsi'],
            ]);

            $subs = [];
            foreach ($bd['subbagian'] as $sub) {
                $subs[] = Subbagian::create([
                    'id_bidang' => $bidang->id_bidang,
                    'nama_subbagian' => $sub,
                ]);
            }

            $bidangModels[] = ['bidang' => $bidang, 'subbagians' => $subs];
        }

        // =============================================
        // 3. TAMU
        // =============================================
        $tamuData = [
            ['nama' => 'Budi Santoso', 'instansi' => 'PT Pelindo Dumai', 'no_hp' => '081234567890', 'alamat' => 'Jl. Sudirman No. 10, Dumai', 'email' => 'budi@gmail.com'],
            ['nama' => 'Siti Rahayu', 'instansi' => 'Dinas Perhubungan Riau', 'no_hp' => '082345678901', 'alamat' => 'Jl. Merdeka No. 5, Pekanbaru', 'email' => 'siti@gmail.com'],
            ['nama' => 'Ahmad Fauzi', 'instansi' => 'PT Pertamina', 'no_hp' => '083456789012', 'alamat' => 'Jl. Imam Bonjol No. 22, Dumai', 'email' => 'ahmad@gmail.com'],
            ['nama' => 'Dewi Lestari', 'instansi' => 'Kementerian Perhubungan', 'no_hp' => '084567890123', 'alamat' => 'Jl. Gatot Subroto No. 7, Jakarta', 'email' => 'dewi@gmail.com'],
            ['nama' => 'Rizky Pratama', 'instansi' => 'CV Maju Jaya Shipping', 'no_hp' => '085678901234', 'alamat' => 'Jl. Hang Tuah No. 3, Dumai', 'email' => 'rizky@gmail.com'],
            ['nama' => 'Nurul Hidayah', 'instansi' => 'Universitas Riau', 'no_hp' => '086789012345', 'alamat' => 'Jl. Pattimura No. 9, Pekanbaru', 'email' => 'nurul@gmail.com'],
            ['nama' => 'Hendra Wijaya', 'instansi' => 'PT Chevron Pacific', 'no_hp' => '087890123456', 'alamat' => 'Jl. Diponegoro No. 15, Dumai', 'email' => 'hendra@gmail.com'],
            ['nama' => 'Rina Marlina', 'instansi' => 'Bea Cukai Dumai', 'no_hp' => '088901234567', 'alamat' => 'Jl. Raja Ali Haji No. 2, Dumai', 'email' => 'rina@gmail.com'],
        ];

        $tamus = [];
        foreach ($tamuData as $td) {
            $tamus[] = Tamu::create([
                'nama' => $td['nama'],
                'instansi' => $td['instansi'],
                'no_hp' => $td['no_hp'],
                'alamat' => $td['alamat'],
                'email' => $td['email'],
                'password' => Hash::make('tamu123'),
            ]);
        }

        // =============================================
        // 4. KUNJUNGAN & LOG STATUS
        // =============================================
        $keperluanList = [
            'Pengurusan sertifikat keselamatan kapal',
            'Konsultasi perizinan berlayar',
            'Pengambilan dokumen pelabuhan',
            'Pelaporan insiden di laut',
            'Koordinasi kegiatan bongkar muat',
            'Pengurusan pas masuk pelabuhan',
            'Konsultasi regulasi pelayaran',
            'Verifikasi manifest kapal',
            'Permohonan izin berlabuh',
            'Pengaduan terkait keselamatan',
        ];

        $statusList = ['pending', 'diterima', 'ditolak'];
        $admin1 = Admin::first();

        // Buat kunjungan untuk 30 hari terakhir
        for ($i = 29; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            // Set waktu ke $tanggal agar method generateNomorAntrian membaca tanggal historis dengan benar
            Carbon::setTestNow($tanggal);

            $jumlahHari = rand(1, 4); // 1-4 kunjungan per hari

            for ($j = 0; $j < $jumlahHari; $j++) {
                $tamu = $tamus[array_rand($tamus)];
                $bidangItem = $bidangModels[array_rand($bidangModels)];
                $subbagian = $bidangItem['subbagians'][array_rand($bidangItem['subbagians'])];
                $keperluan = $keperluanList[array_rand($keperluanList)];

                // Status: kunjungan lama sudah diproses, yang baru masih pending
                if ($i > 2) {
                    $status = $statusList[array_rand([0 => 'diterima', 1 => 'diterima', 2 => 'ditolak'])];
                } else {
                    $status = 'pending';
                }

                // Memanggil generator asli dari Model Kunjungan
                $nomorAntrian = Kunjungan::generateNomorAntrian($bidangItem['bidang']->id_bidang, $subbagian->id_subbagian, $tanggal);

                $jamMasuk = sprintf('%02d:%02d', rand(8, 15), rand(0, 59));
                $jamKeluar = $status === 'diterima' ? sprintf('%02d:%02d', rand(9, 16), rand(0, 59)) : null;

                $kunjungan = Kunjungan::create([
                    'id_tamu' => $tamu->id_tamu,
                    'id_bidang' => $bidangItem['bidang']->id_bidang,
                    'id_subbagian' => $subbagian->id_subbagian,
                    'tanggal_kunjungan' => $tanggal->toDateString(),
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'nomor_antrian' => $nomorAntrian,
                    'status_kunjungan' => $status,
                    'keperluan' => $keperluan,
                    'keterangan' => $status === 'ditolak' ? 'Dokumen persyaratan belum lengkap.' : null,
                    'is_served' => $status === 'diterima' ? true : false,
                ]);

                // Buat log status jika sudah diproses
                if ($status !== 'pending') {
                    LogStatus::create([
                        'id_kunjungan' => $kunjungan->id_kunjungan,
                        'id_admin' => $admin1->id_admin,
                        'status' => $status,
                        'waktu_update' => $tanggal->copy()->addHours(rand(1, 3)),
                    ]);
                }
            }
        }

        // Tambah beberapa kunjungan hari ini (pending semua)
        $today = Carbon::today();
        Carbon::setTestNow($today); // Pastikan waktu diset kembali ke hari ini

        for ($k = 0; $k < 3; $k++) {
            $tamu = $tamus[$k];
            $bidangItem = $bidangModels[$k % count($bidangModels)];
            $subbagian = $bidangItem['subbagians'][0];

            // Memanggil generator asli dari Model Kunjungan untuk hari ini
            $nomorAntrian = Kunjungan::generateNomorAntrian($bidangItem['bidang']->id_bidang, $subbagian->id_subbagian, $today);

            Kunjungan::create([
                'id_tamu' => $tamu->id_tamu,
                'id_bidang' => $bidangItem['bidang']->id_bidang,
                'id_subbagian' => $subbagian->id_subbagian,
                'tanggal_kunjungan' => $today->toDateString(),
                'jam_masuk' => sprintf('%02d:00', rand(8, 10)),
                'jam_keluar' => null,
                'nomor_antrian' => $nomorAntrian,
                'status_kunjungan' => 'pending',
                'keperluan' => $keperluanList[$k],
                'keterangan' => null,
                'is_served' => false,
            ]);
        }

        // Mengembalikan waktu sistem ke normal setelah seeder selesai
        Carbon::setTestNow();

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('');
        $this->command->info('Akun Admin:');
        $this->command->info('  username: admin    | password: admin123');
        $this->command->info('  username: petugas  | password: petugas123');
        $this->command->info('');
        $this->command->info('Akun Tamu (semua password: tamu123):');
        foreach ($tamuData as $td) {
            $this->command->info('  email: ' . $td['email']);
        }
    }
}