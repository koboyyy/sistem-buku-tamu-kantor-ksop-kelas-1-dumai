<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Tamu;
use App\Models\Kunjungan;
use App\Models\LogStatus;

class AdminController extends Controller
{
    // =========================
    // DASHBOARD
    // =========================

    public function dashboard(Request $request)
    {
        /**
         * AUTO CHECK EXPIRED
         */
        \App\Models\Kunjungan::autoTolakExpired();

        /**
         * TOTAL DATA
         */
        $totalTamu = Tamu::count();

        $totalKunjungan = Kunjungan::count();

        /**
         * STATUS
         */
        $pending = Kunjungan::where(
            'status_kunjungan',
            'pending'
        )->count();

        $diterima = Kunjungan::where(
            'status_kunjungan',
            'diterima'
        )->count();

        $ditolak = Kunjungan::where(
            'status_kunjungan',
            'ditolak'
        )->count();

        /**
         * FILTER
         */
        $tahun =
            $request->tahun ??
            date('Y');

        $bulan =
            $request->bulan;

        $minggu =
            $request->minggu;

        /**
         * QUERY DASAR
         */
        $query = Kunjungan::query();

        // Generate weeks list if month is selected
        $weeks = [];
        if ($bulan) {
            $startOfMonth = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $tempDate = $startOfMonth->copy();
            if ($tempDate->dayOfWeek !== \Carbon\Carbon::MONDAY) {
                $tempDate->previous(\Carbon\Carbon::MONDAY);
            }

            $weekIndex = 1;
            while ($tempDate->lte($endOfMonth)) {
                $monday = $tempDate->copy();
                $friday = $tempDate->copy()->addDays(4);
                $sunday = $tempDate->copy()->addDays(6);

                if ($monday->month == $bulan || $sunday->month == $bulan) {
                    $weeks[$weekIndex] = [
                        'label' => "Minggu $weekIndex (" . $monday->translatedFormat('d M') . " - " . $friday->translatedFormat('d M') . ")",
                        'start' => $monday->toDateString(),
                        'end' => $sunday->toDateString(),
                        'friday_end' => $friday->toDateString()
                    ];
                    $weekIndex++;
                }
                $tempDate->addWeek();
            }
        }

        // Apply date filters
        if ($bulan) {
            if ($minggu && isset($weeks[$minggu])) {
                $query->whereBetween('tanggal_kunjungan', [$weeks[$minggu]['start'], $weeks[$minggu]['end']]);
            } else {
                $query->whereYear('tanggal_kunjungan', $tahun)
                      ->whereMonth('tanggal_kunjungan', $bulan);
            }
        } else {
            $query->whereYear('tanggal_kunjungan', $tahun);
        }

        // =========================
        // GRAFIK DINAMIS (TAMPIL KOSONG + RENTANG TANGGAL)
        // =========================

        $labels = [];
        $dataPending = [];
        $dataDiterima = [];
        $dataDitolak = [];

        if ($bulan) {
            if ($minggu && isset($weeks[$minggu])) {
                /**
                 * JIKA FILTER PER MINGGU DIAKTIFKAN:
                 * Tampilkan hari Senin - Jumat
                 */
                $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                $dataPending = [0, 0, 0, 0, 0];
                $dataDiterima = [0, 0, 0, 0, 0];
                $dataDitolak = [0, 0, 0, 0, 0];

                $visits = $query->get();
                foreach ($visits as $visit) {
                    $dayOfWeek = \Carbon\Carbon::parse($visit->tanggal_kunjungan)->dayOfWeekIso; // 1 = Monday, 7 = Sunday
                    $index = $dayOfWeek - 1; // 0 = Monday, 4 = Friday
                    if ($index >= 0 && $index <= 4) {
                        if ($visit->status_kunjungan === 'pending') {
                            $dataPending[$index]++;
                        } elseif ($visit->status_kunjungan === 'diterima') {
                            $dataDiterima[$index]++;
                        } elseif ($visit->status_kunjungan === 'ditolak') {
                            $dataDitolak[$index]++;
                        }
                    }
                }
            } else {
                /**
                 * JIKA HANYA MEMILIH BULAN (TANPA MINGGU):
                 * Tampilkan data per minggu dalam bulan
                 */
                foreach ($weeks as $idx => $wInfo) {
                    $labels[] = "Minggu $idx (" . \Carbon\Carbon::parse($wInfo['start'])->translatedFormat('d M') . " - " . \Carbon\Carbon::parse($wInfo['friday_end'])->translatedFormat('d M') . ")";
                    $dataPending[] = 0;
                    $dataDiterima[] = 0;
                    $dataDitolak[] = 0;
                }

                $visits = $query->get();
                foreach ($visits as $visit) {
                    $visitDate = \Carbon\Carbon::parse($visit->tanggal_kunjungan);
                    foreach ($weeks as $idx => $wInfo) {
                        $start = \Carbon\Carbon::parse($wInfo['start']);
                        $end = \Carbon\Carbon::parse($wInfo['end']);
                        if ($visitDate->between($start, $end)) {
                            $arrayIdx = $idx - 1;
                            if ($visit->status_kunjungan === 'pending') {
                                $dataPending[$arrayIdx]++;
                            } elseif ($visit->status_kunjungan === 'diterima') {
                                $dataDiterima[$arrayIdx]++;
                            } elseif ($visit->status_kunjungan === 'ditolak') {
                                $dataDitolak[$arrayIdx]++;
                            }
                            break;
                        }
                    }
                }
            }
        } else {
            /**
             * JIKA MEMILIH "SEMUA BULAN":
             * Buat kerangka 12 Bulan (Januari - Desember)
             */
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
                $dataPending[] = 0;
                $dataDiterima[] = 0;
                $dataDitolak[] = 0;
            }

            $visits = $query->get();
            foreach ($visits as $visit) {
                $month = \Carbon\Carbon::parse($visit->tanggal_kunjungan)->month;
                $index = $month - 1;
                if ($visit->status_kunjungan === 'pending') {
                    $dataPending[$index]++;
                } elseif ($visit->status_kunjungan === 'diterima') {
                    $dataDiterima[$index]++;
                } elseif ($visit->status_kunjungan === 'ditolak') {
                    $dataDitolak[$index]++;
                }
            }
        }

        /**
         * DAFTAR TAHUN
         */
        $daftarTahun =
            Kunjungan::selectRaw(
                'YEAR(tanggal_kunjungan) as tahun'
            )
                ->distinct()
                ->orderBy(
                    'tahun',
                    'DESC'
                )
                ->pluck('tahun');

        /**
         * VIEW
         */
        return view(
            'admin.dashboard',
            compact(

                /**
                 * CARD
                 */
                'totalTamu',
                'totalKunjungan',

                'pending',
                'diterima',
                'ditolak',

                /**
                 * CHART
                 */
                'labels',

                'dataPending',
                'dataDiterima',
                'dataDitolak',

                /**
                 * FILTER
                 */
                'tahun',
                'bulan',
                'minggu',
                'weeks',

                /**
                 * OPTION TAHUN
                 */
                'daftarTahun'

            )
        );
    }

    // =========================
    // DAFTAR TAMU
    // =========================

    public function daftarTamu(Request $request)
    {
        $query =
            Tamu::withCount(
                'kunjungans'
            );

        /**
         * SEARCH
         */
        if (
            $request->filled('search')
        ) {

            $search =
                $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'instansi',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'no_hp',
                        'like',
                        "%{$search}%"
                    );

            });
        }

        $tamus =
            $query->latest()->get();

        return view(
            'admin.tamu.index',
            compact('tamus')
        );
    }

    // =========================
    // RIWAYAT TAMU
    // =========================

    public function riwayatTamu($id)
    {
        /**
         * AUTO CHECK EXPIRED 
         * (Opsional, agar status kunjungan tamu selalu update)
         */
        \App\Models\Kunjungan::autoTolakExpired();

        // Cari data tamu berdasarkan ID
        $tamu = Tamu::findOrFail($id);

        // Ambil riwayat kunjungan tamu tersebut, urutkan dari yang terbaru
        $riwayatKunjungan = Kunjungan::with(['bidang', 'subbagian'])
            ->where('id_tamu', $id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->get();

        return view('admin.tamu.riwayat', compact('tamu', 'riwayatKunjungan'));
    }

    // =========================
    // HAPUS TAMU
    // =========================

    public function hapusTamu($id)
    {
        Tamu::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Data tamu berhasil dihapus.'
        );
    }

    // =========================
    // DAFTAR KUNJUNGAN
    // =========================

    public function daftarKunjungan(Request $request)
    {
        /**
         * AUTO CHECK
         */
        \App\Models\Kunjungan::autoTolakExpired();

        $query =
            Kunjungan::with([
                'tamu',
                'bidang',
                'subbagian'
            ]);

        /**
         * SEARCH
         */
        $query->when(
            $request->filled('search'),
            function ($q) use ($request) {

                $search =
                    $request->search;

                $q->where(function ($sub) use ($search) {

                    $sub->where(
                        'nomor_antrian',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhereHas(
                            'tamu',
                            function ($t) use ($search) {

                                $t->where(
                                    'nama',
                                    'like',
                                    "%{$search}%"
                                )

                                    ->orWhere(
                                        'instansi',
                                        'like',
                                        "%{$search}%"
                                    );

                            }
                        )

                        ->orWhereHas(
                            'bidang',
                            function ($b) use ($search) {

                                $b->where(
                                    'nama_bidang',
                                    'like',
                                    "%{$search}%"
                                );

                            }
                        );

                });

            }
        );

        /**
         * FILTER STATUS
         */
        $query->when(
            $request->filled('status'),
            function ($q) use ($request) {

                $q->where(
                    'status_kunjungan',
                    $request->status
                );

            }
        );

        /**
         * FILTER BIDANG
         */
        $query->when(
            $request->filled('bidang'),
            function ($q) use ($request) {

                $q->where(
                    'id_bidang',
                    $request->bidang
                );

            }
        );

        $kunjungans =
            $query->orderBy('tanggal_kunjungan', 'desc')
                ->orderBy('jam_masuk', 'desc')
                ->get();

        $bidangs =
            \App\Models\Bidang::all();

        return view(
            'admin.kunjungan.index',
            compact(
                'kunjungans',
                'bidangs'
            )
        );
    }

    // =========================
    // DETAIL KUNJUNGAN
    // =========================

    public function detailKunjungan($id)
    {
        /**
         * AUTO CHECK
         */
        \App\Models\Kunjungan::autoTolakExpired();

        $kunjungan =
            Kunjungan::with([
                'tamu',
                'bidang',
                'subbagian',
                'logStatuses.admin'
            ])->findOrFail($id);

        return view(
            'admin.kunjungan.detail',
            compact('kunjungan')
        );
    }

    // =========================
    // UBAH STATUS
    // =========================

    public function ubahStatus(
        Request $request,
        $id
    ) {

        $request->validate([

            'status_kunjungan' =>
                'required|in:pending,diterima,ditolak',

            'keterangan' =>
                'nullable|string',

        ]);

        $kunjungan =
            Kunjungan::findOrFail($id);

        /**
         * UPDATE STATUS
         */
        $kunjungan->update([

            'status_kunjungan' =>
                $request->status_kunjungan,

            'keterangan' =>
                $request->keterangan,

        ]);

        /**
         * LOG STATUS
         */
        LogStatus::create([

            'id_kunjungan' =>
                $kunjungan->id_kunjungan,

            'id_admin' =>
                Auth::guard('admin')->id(),

            'status' =>
                $request->status_kunjungan,

            'waktu_update' =>
                now(),

        ]);

        return back()->with(
            'success',
            'Status kunjungan berhasil diperbarui.'
        );
    }

    // =========================
    // SELESAI KUNJUNGAN
    // =========================

    public function selesai($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'is_served' => true,
            'jam_keluar' => now()->toTimeString(),
        ]);

        LogStatus::create([
            'id_kunjungan' => $kunjungan->id_kunjungan,
            'id_admin' => Auth::guard('admin')->id(),
            'status' => 'selesai dilayani',
            'waktu_update' => now(),
        ]);

        return back()->with(
            'success',
            'Kunjungan telah selesai dilayani.'
        );
    }

    // =========================
    // HAPUS KUNJUNGAN
    // =========================

    public function hapusKunjungan($id)
    {
        Kunjungan::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Data kunjungan berhasil dihapus.'
        );
    }

    // =========================
    // LAPORAN
    // =========================

    public function laporan(Request $request)
    {
        $query =
            Kunjungan::with([
                'tamu',
                'bidang',
                'subbagian'
            ]);

        /**
         * FILTER TANGGAL
         */
        if (
            $request->filled('dari')
            &&
            $request->filled('sampai')
        ) {

            $query->whereBetween(
                'tanggal_kunjungan',
                [
                    $request->dari,
                    $request->sampai
                ]
            );
        }

        $kunjungans =
            $query->orderBy(
                'tanggal_kunjungan',
                'asc'
            )->get();

        return view(
            'admin.laporan',
            compact('kunjungans')
        );
    }

    // =========================
    // PROFIL ADMIN
    // =========================

    public function profil()
    {
        $admin =
            Auth::guard('admin')->user();

        return view(
            'admin.profil',
            compact('admin')
        );
    }

    public function updateProfil(
        Request $request
    ) {

        $admin =
            Auth::guard('admin')->user();

        $request->validate([

            'username' =>
                'required|string|max:255',

            'password' =>
                'nullable|min:6|confirmed',

        ]);

        /**
         * UPDATE USERNAME
         */
        $admin->username =
            $request->username;

        /**
         * UPDATE PASSWORD
         */
        if (
            $request->filled('password')
        ) {

            $admin->password =
                Hash::make(
                    $request->password
                );
        }

        $admin->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }
}