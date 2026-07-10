<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Kunjungan;
use App\Models\Bidang;
use App\Models\Subbagian;

class TamuController extends Controller
{
    // =========================
    // DASHBOARD TAMU
    // =========================

    public function dashboard()
    {
        $tamu = Auth::guard('tamu')->user();

        // =========================
        // KUNJUNGAN TERAKHIR
        // =========================

        $kunjunganTerakhir =
            Kunjungan::where(
                'id_tamu',
                $tamu->id_tamu
            )
                ->latest('tanggal_kunjungan')
                ->first();

        // =========================
        // STATISTIK
        // =========================

        $totalKunjungan =
            Kunjungan::where(
                'id_tamu',
                $tamu->id_tamu
            )
                ->count();

        $pending =
            Kunjungan::where(
                'id_tamu',
                $tamu->id_tamu
            )
                ->where(
                    'status_kunjungan',
                    'pending'
                )
                ->count();

        $diterima =
            Kunjungan::where(
                'id_tamu',
                $tamu->id_tamu
            )
                ->where(
                    'status_kunjungan',
                    'diterima'
                )
                ->count();

        // =========================
        // SUDAH DILAYANI
        // =========================

        $sudahDilayani =
            Kunjungan::where(
                'is_served',
                true
            )
                ->latest('id_kunjungan')
                ->take(10)
                ->get();

        return view(
            'tamu.dashboard',
            compact(
                'tamu',
                'kunjunganTerakhir',
                'sudahDilayani',
                'totalKunjungan',
                'pending',
                'diterima'
            )
        );
    }

    // =========================
    // FORM KUNJUNGAN
    // =========================

    public function formKunjungan()
    {
        $bidangs =
            Bidang::with(
                'subbagians'
            )->get();

        return view(
            'tamu.form-kunjungan',
            compact('bidangs')
        );
    }

    // =========================
    // SIMPAN KUNJUNGAN
    // =========================

    public function simpanKunjungan(Request $request)
    {
        $request->validate([

            'id_bidang' =>
                'required|exists:bidang,id_bidang',

            'id_subbagian' =>
                'required|exists:subbagian,id_subbagian',

            'tanggal_kunjungan' =>
                'required|date|after_or_equal:today',

            'jam_masuk' =>
                'required',

            'keperluan' =>
                'required|string',

            'keterangan' =>
                'nullable|string',
        ]);

        $tamu =
            Auth::guard('tamu')->user();

        // =========================
        // SATU KUNJUNGAN PER HARI
        // =========================
        $existingKunjungan = Kunjungan::where('id_tamu', $tamu->id_tamu)
            ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->first();

        if ($existingKunjungan) {
            return back()
                ->withInput()
                ->with('error', 'Satu akun pengunjung dalam satu hari hanya bisa membuat satu kunjungan.');
        }

        // GENERATE NOMOR
        $nomorAntrian =
            Kunjungan::generateNomorAntrian(
                $request->id_bidang,
                $request->id_subbagian,
                $request->tanggal_kunjungan
            );

        // SIMPAN
        $kunjungan =
            Kunjungan::create([

                'id_tamu' =>
                    $tamu->id_tamu,

                'id_bidang' =>
                    $request->id_bidang,

                'id_subbagian' =>
                    $request->id_subbagian,

                'tanggal_kunjungan' =>
                    $request->tanggal_kunjungan,

                'jam_masuk' =>
                    $request->jam_masuk,

                'nomor_antrian' =>
                    $nomorAntrian,

                'status_kunjungan' =>
                    'pending',

                'keperluan' =>
                    $request->keperluan,

                'keterangan' =>
                    $request->keterangan,

                'is_served' =>
                    false,
            ]);

        return redirect()
            ->route(
                'tamu.antrian',
                $kunjungan->id_kunjungan
            )
            ->with(
                'success',
                'Kunjungan berhasil didaftarkan!'
            );
    }

    // =========================
    // HALAMAN ANTRIAN
    // =========================

    public function antrian($id)
    {
        $tamu =
            Auth::guard('tamu')->user();

        // DATA KUNJUNGAN TAMU
        $kunjungan =
            Kunjungan::with([
                'bidang',
                'subbagian'
            ])
                ->where(
                    'id_tamu',
                    $tamu->id_tamu
                )
                ->findOrFail($id);

        // ============================
        // LOGIKA ANTRIAN GLOBAL / UMUM
        // ============================

        // ANTRIAN YANG SUDAH DILAYANI (GLOBAL)
        $sudahDilayani =
            Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('is_served', true)
                ->latest('id_kunjungan')
                ->take(10)
                ->get();

        // ANTRIAN SAAT INI (GLOBAL)
        $current =
            Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('is_served', true)
                ->latest('id_kunjungan')
                ->first();

        // ANTRIAN MENUNGGU (GLOBAL)
        $belumDilayani =
            Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('is_served', false)
                ->whereIn('status_kunjungan', ['diterima', 'pending'])
                ->orderBy('id_kunjungan', 'asc')
                ->get();

        if ($kunjungan->status_kunjungan === 'ditolak') {
            $estimasiSisa = 0;
        } else {
            $estimasiSisa = Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('is_served', false)
                ->whereIn('status_kunjungan', ['diterima', 'pending'])
                ->where('id_kunjungan', '<', $kunjungan->id_kunjungan)
                ->count();
        }

        return view(
            'tamu.antrian',
            compact(
                'kunjungan',
                'current',
                'sudahDilayani',
                'belumDilayani',
                'estimasiSisa'
            )
        );
    }

    // =========================
    // RIWAYAT
    // =========================

    public function riwayat()
    {
        $tamu =
            Auth::guard('tamu')->user();

        $kunjungans =
            Kunjungan::with([
                'bidang',
                'subbagian'
            ])
                ->where(
                    'id_tamu',
                    $tamu->id_tamu
                )
                ->orderBy('tanggal_kunjungan', 'desc')
                ->orderBy('jam_masuk', 'desc')
                ->get();

        return view(
            'tamu.riwayat',
            compact('kunjungans')
        );
    }

    // =========================
    // MONITOR ANTRIAN
    // =========================

    public function monitorAntrian()
    {
        $tamu =
            Auth::guard('tamu')->user();

        // AMBIL KUNJUNGAN TERAKHIR TAMU
        $kunjungan =
            Kunjungan::with([
                'bidang',
                'subbagian'
            ])
                ->where(
                    'id_tamu',
                    $tamu->id_tamu
                )
                ->latest('id_kunjungan')
                ->first();

        // JIKA BELUM ADA KUNJUNGAN
        if (!$kunjungan) {
            return redirect()
                ->route('tamu.dashboard')
                ->with(
                    'error',
                    'Anda belum memiliki data kunjungan.'
                );
        }

        // FILTER BERDASARKAN SUBBAGIAN
        $idSubbagian =
            $kunjungan->id_subbagian;
 
        // SUDAH DILAYANI
        $sudahDilayani =
            Kunjungan::where(
                'id_subbagian',
                $idSubbagian
            )
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('status_kunjungan', 'diterima')
                ->where(
                    'is_served',
                    true
                )
                ->latest('id_kunjungan')
                ->get();
 
        // BELUM DILAYANI
        $belumDilayani =
            Kunjungan::where(
                'id_subbagian',
                $idSubbagian
            )
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('status_kunjungan', 'diterima')
                ->where(
                    'is_served',
                    false
                )
                ->orderBy('nomor_antrian', 'asc')
                ->get();
 
        // ANTRIAN SAAT INI
        $current =
            Kunjungan::where(
                'id_subbagian',
                $idSubbagian
            )
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('status_kunjungan', 'diterima')
                ->where(
                    'is_served',
                    true
                )
                ->latest('id_kunjungan')
                ->first();

        return view(
            'tamu.monitor-antrian',
            compact(
                'kunjungan',
                'current',
                'sudahDilayani',
                'belumDilayani'
            )
        );
    }

    // =========================
    // PROFIL
    // =========================

    public function profil()
    {
        $tamu =
            Auth::guard('tamu')->user();

        return view(
            'tamu.profil',
            compact('tamu')
        );
    }

    // =========================
    // UPDATE PROFIL
    // =========================

    public function updateProfil(Request $request)
    {
        $tamu =
            Auth::guard('tamu')->user();

        $request->validate([

            'nama' =>
                'required|string|max:255',

            'email' =>
                'required|email|max:255',

            'no_hp' =>
                'required|string|max:20',

            'instansi' =>
                'nullable|string|max:255',

            'password' =>
                'nullable|min:6|confirmed',
        ]);

        // UPDATE DATA
        $tamu->nama =
            $request->nama;

        $tamu->email =
            $request->email;

        $tamu->no_hp =
            $request->no_hp;

        $tamu->instansi =
            $request->instansi;

        // UPDATE PASSWORD
        if ($request->filled('password')) {
            $tamu->password =
                Hash::make(
                    $request->password
                );
        }

        $tamu->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    // =========================
    // SELESAI KUNJUNGAN (GUEST)
    // =========================
    public function selesai($id)
    {
        $tamu = Auth::guard('tamu')->user();
        $kunjungan = Kunjungan::where('id_tamu', $tamu->id_tamu)->findOrFail($id);

        if ($kunjungan->status_kunjungan !== 'diterima') {
            return back()->with('error', 'Kunjungan hanya dapat diselesaikan jika sudah berstatus diterima.');
        }

        if ($kunjungan->is_served) {
            return back()->with('error', 'Kunjungan ini sudah selesai dilayani.');
        }

        $kunjungan->update([
            'is_served' => true,
            'jam_keluar' => now()->toTimeString(),
        ]);

        \App\Models\LogStatus::create([
            'id_kunjungan' => $kunjungan->id_kunjungan,
            'id_admin' => 1, // System Admin
            'status' => 'selesai dilayani',
            'waktu_update' => now(),
        ]);

        return back()->with('success', 'Kunjungan berhasil diselesaikan.');
    }

    // =========================
    // REALTIME QUEUE DATA (JSON)
    // =========================
    public function realtimeAntrian($id)
    {
        $tamu = Auth::guard('tamu')->user();
        $kunjungan = Kunjungan::where('id_tamu', $tamu->id_tamu)->findOrFail($id);

        $current = Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
            ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
            ->where('is_served', true)
            ->latest('id_kunjungan')
            ->first();

        $sudahDilayani = Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
            ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
            ->where('is_served', true)
            ->latest('id_kunjungan')
            ->take(10)
            ->get();

        if ($kunjungan->status_kunjungan === 'ditolak') {
            $estimasiSisa = 0;
        } else {
            $estimasiSisa = Kunjungan::where('id_subbagian', $kunjungan->id_subbagian)
                ->whereDate('tanggal_kunjungan', $kunjungan->tanggal_kunjungan)
                ->where('is_served', false)
                ->whereIn('status_kunjungan', ['diterima', 'pending'])
                ->where('id_kunjungan', '<', $kunjungan->id_kunjungan)
                ->count();
        }

        // Fresh retrieve to get latest status and is_served
        $freshKunjungan = Kunjungan::findOrFail($id);

        return response()->json([
            'status_kunjungan' => $freshKunjungan->status_kunjungan,
            'is_served' => (bool)$freshKunjungan->is_served,
            'current_nomor_antrian' => $current ? $current->nomor_antrian : '-',
            'estimasi_sisa' => $estimasiSisa,
            'sudah_dilayani' => $sudahDilayani->pluck('nomor_antrian')->toArray(),
            'keterangan' => $freshKunjungan->keterangan,
        ]);
    }
}