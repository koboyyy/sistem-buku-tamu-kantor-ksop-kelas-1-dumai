<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Riwayat Kunjungan - KSOP Dumai</title>

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />

    @vite ('resources/css/app.css')

    <style>
        /* =========================
           ANIMATION
        ========================= */

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(35px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <!-- =========================
         NAVBAR
    ========================= -->

    <nav
        class="bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-200 sticky top-0 z-50"
    >
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between py-4">
                <!-- LEFT -->
                <a
                    href="{{ route('tamu.dashboard') }}"
                    class="flex items-center gap-4 group"
                >
                    <div
                        class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300"
                    >
                        <i class="bi bi-arrow-left text-xl"></i>
                    </div>

                    <div>
                        <h1
                            class="text-lg font-extrabold text-primary leading-tight"
                        >
                            Riwayat Kunjungan
                        </h1>

                        <p class="text-sm text-slate-500">KSOP Kelas I Dumai</p>
                    </div>
                </a>

                <!-- RIGHT -->
                <a
                    href="{{ route('tamu.kunjungan.form') }}"
                    class="hidden md:inline-flex items-center gap-2 bg-gradient-to-r from-primary to-softnavy text-white px-5 py-3 rounded-2xl font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                >
                    <i class="bi bi-plus-lg"></i>

                    Kunjungan Baru
                </a>
            </div>
        </div>
    </nav>

    <!-- =========================
         CONTENT
    ========================= -->

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- HEADER -->
        <div
            class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8 animate-fade-up"
        >
            <div>
                <p class="text-secondary font-semibold mb-2">Dashboard Riwayat</p>

                <h2 class="text-4xl font-extrabold text-primary mb-3">
                    Riwayat Kunjungan Anda
                </h2>

                <p class="text-slate-500 leading-7 max-w-2xl">Daftar seluruh agenda kunjungan yang pernah Anda buat pada sistem Buku Tamu Digital KSOP Dumai.</p>
            </div>

            <!-- MOBILE BUTTON -->
            <a
                href="{{ route('tamu.kunjungan.form') }}"
                class="md:hidden inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-softnavy text-white px-5 py-4 rounded-2xl font-bold shadow-lg"
            >
                <i class="bi bi-plus-lg"></i>

                Kunjungan Baru
            </a>
        </div>

        <!-- EMPTY -->
        @if ($kunjungans->isEmpty())
            <div
                class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-16 text-center animate-fade-up delay-100"
            >
                <div
                    class="w-28 h-28 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-5xl text-slate-400 mb-6"
                >
                    <i class="bi bi-calendar-x"></i>
                </div>

                <h3 class="text-2xl font-extrabold text-primary mb-3">
                    Belum Ada Riwayat
                </h3>

                <p class="text-slate-500 leading-7 max-w-xl mx-auto mb-8">Anda belum pernah melakukan pendaftaran kunjungan pada sistem.</p>

                <a
                    href="{{ route('tamu.kunjungan.form') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-softnavy text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                >
                    <i class="bi bi-plus-lg"></i>

                    Buat Kunjungan
                </a>
            </div>

        @else
            <!-- =========================
                 TABLE CARD
            ========================= -->
            <div
                class="bg-white rounded-[32px] shadow-xl border border-slate-100 overflow-hidden animate-fade-up delay-100"
            >
                <!-- HEADER -->
                <div
                    class="bg-gradient-to-r from-primary to-softnavy px-8 py-6 text-white"
                >
                    <div
                        class="flex items-center justify-between flex-wrap gap-4"
                    >
                        <div>
                            <h3
                                class="text-2xl font-extrabold flex items-center gap-3"
                            >
                                <i class="bi bi-clock-history"></i>

                                Data Riwayat Kunjungan
                            </h3>

                            <p class="text-white/70 mt-1 text-sm">Menampilkan {{ $kunjungans->count() }} data kunjungan terakhir</p>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <!-- HEAD -->
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Nomor Antrian
                                </th>

                                <th
                                    class="px-6 py-5 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Tanggal
                                </th>

                                <th
                                    class="px-6 py-5 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Tujuan Bidang
                                </th>

                                <th
                                    class="px-6 py-5 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Keperluan
                                </th>

                                <th
                                    class="px-6 py-5 text-center text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-6 py-5 text-center text-xs font-bold tracking-wider text-slate-500 uppercase"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <!-- BODY -->
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($kunjungans as $k)
                                @php
                                    $s = $k->status_kunjungan;
                                @endphp
                                <tr
                                    class="hover:bg-slate-50 transition duration-300"
                                >
                                    <!-- NOMOR -->
                                    <td class="px-6 py-5">
                                        <div
                                            class="inline-flex items-center bg-primary/10 text-primary px-4 py-2 rounded-xl font-extrabold text-sm"
                                        >
                                            #{{ $k->nomor_antrian }}
                                        </div>
                                    </td>

                                    <!-- TANGGAL -->
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}
                                        </div>

                                        <div
                                            class="text-sm text-slate-500 mt-1 flex items-center gap-1"
                                        >
                                            <i class="bi bi-clock"></i>

                                            {{ $k->jam_masuk }} WIB
                                        </div>
                                    </td>

                                    <!-- BIDANG -->
                                    <td class="px-6 py-5">
                                        <div
                                            class="font-semibold text-slate-800"
                                        >
                                            {{ $k->bidang->nama_bidang ?? '-' }}
                                        </div>

                                        <div
                                            class="text-xs text-slate-500 mt-1 uppercase tracking-wide flex items-center gap-1"
                                        >
                                            <i
                                                class="bi bi-arrow-return-right"
                                            ></i>

                                            {{ $k->subbagian->nama_subbagian ?? '-' }}
                                        </div>
                                    </td>

                                    <!-- KEPERLUAN -->
                                    <td class="px-6 py-5">
                                        <p class="text-slate-600 leading-7 text-sm">
                                            {{ Str::limit($k->keperluan, 60) }}
                                        </p>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="px-6 py-5 text-center">
                                        @if ($s === 'diterima')
                                            @if ($k->is_served)
                                                <span
                                                    class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-sm animate-pulse"
                                                >
                                                    <i
                                                        class="bi bi-check-circle-fill"
                                                    ></i>
                                                    Selesai Dilayani
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold"
                                                    title="Kedatangan Diterima"
                                                >
                                                    <i
                                                        class="bi bi-check-circle-fill"
                                                    ></i>
                                                    Diterima
                                                </span>
                                            @endif

                                        @elseif ($s === 'ditolak')
                                            <span
                                                class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold"
                                            >
                                                <i
                                                    class="bi bi-x-circle-fill"
                                                ></i>

                                                Ditolak
                                            </span>

                                        @else
                                            <span
                                                class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold"
                                            >
                                                <i
                                                    class="bi bi-hourglass-split"
                                                ></i>

                                                Pending
                                            </span>

                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($k->status_kunjungan === 'diterima' && !$k->is_served)
                                                <button
                                                    type="button"
                                                    onclick="openConfirmModal('{{ route('tamu.kunjungan.selesai', $k->id_kunjungan) }}')"
                                                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition duration-300 shadow-sm"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    Selesai
                                                </button>
                                            @else
                                                <button
                                                    type="button"
                                                    disabled
                                                    class="inline-flex items-center gap-2 bg-slate-200 text-slate-400 px-4 py-2 rounded-xl text-sm font-bold cursor-not-allowed opacity-60"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    Selesai
                                                </button>
                                            @endif

                                            <a
                                                href="{{ route('tamu.antrian', $k->id_kunjungan) }}"
                                                class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 hover:bg-primary hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition duration-300"
                                            >
                                                <i class="bi bi-eye"></i>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif
    </div>
    <!-- =========================
         CONFIRMATION MODAL
    ========================= -->
    <div
        id="confirmModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-all duration-300"
        style="opacity: 0; pointer-events: none;"
    >
        <!-- BACKDROP -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300"></div>

        <!-- DIALOG CONTENT -->
        <div
            class="bg-white rounded-[28px] shadow-2xl border border-slate-100 max-w-md w-full p-8 relative z-10 transform scale-90 transition-all duration-300"
            id="confirmDialog"
        >
            <div class="text-center">
                <!-- ICON -->
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <!-- TITLE & DESC -->
                <h3 class="text-2xl font-extrabold text-primary mb-3">Konfirmasi Selesai</h3>
                <p class="text-slate-500 leading-relaxed mb-8">Apakah Anda yakin ingin menyelesaikan kunjungan ini? Status kunjungan Anda akan diubah menjadi selesai.</p>

                <!-- ACTIONS -->
                <div class="flex gap-4">
                    <button
                        type="button"
                        onclick="closeModal()"
                        class="flex-1 py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition duration-300"
                    >
                        Batal
                    </button>
                    <form id="modalForm" method="POST" class="flex-1 m-0">
                        @csrf
                        <button
                            type="submit"
                            class="w-full py-4 text-white font-bold rounded-2xl shadow-lg hover:-translate-y-0.5 transition duration-300"
                            style="background: linear-gradient(to right, #16a34a, #10b981);"
                        >
                            Ya, Selesai
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('confirmModal');
        const dialog = document.getElementById('confirmDialog');
        const modalForm = document.getElementById('modalForm');

        function openConfirmModal(actionUrl) {
            modalForm.action = actionUrl;
            
            // Show modal using inline styles to bypass uncompiled Tailwind classes
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'auto';
            dialog.classList.remove('scale-90');
            dialog.classList.add('scale-100');
        }

        function closeModal() {
            // Hide modal
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            dialog.classList.remove('scale-100');
            dialog.classList.add('scale-90');
        }

        // Close on backdrop click
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.classList.contains('bg-slate-900/40')) {
                closeModal();
            }
        });
    </script>
</body>
</html>
