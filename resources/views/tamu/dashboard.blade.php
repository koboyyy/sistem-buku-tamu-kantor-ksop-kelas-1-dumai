<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Dashboard Tamu - KSOP Dumai</title>

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />

    @vite ('resources/css/app.css')

    <!-- ANIMATION -->
    <style>
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

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-500 {
            animation-delay: 0.5s;
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
                <div class="flex items-center gap-4">
                    <img
                        src="{{ asset('logo-ksop-kelas-1-dumai.png') }}"
                        alt="Logo KSOP"
                        class="w-14"
                    />

                    <div>
                        <h1
                            class="text-lg lg:text-xl font-extrabold text-primary leading-tight"
                        >
                            Kantor Kesyahbandaran dan Otoritas Pelabuhan (KSOP)
                            Kelas I Dumai
                        </h1>

                        <p class="text-sm text-slate-500">Buku Tamu Digital</p>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-4">
                    {{-- <!-- MONITOR -->
                    <a
                        href="{{ route('tamu.monitor.antrian') }}"
                        class="inline-flex items-center justify-center gap-3 bg-white border-2 border-primary text-primary px-6 py-4 rounded-2xl font-bold hover:bg-primary hover:text-white transition"
                    >
                        <i class="bi bi-display"></i>

                        Monitor Antrian
                    </a> --}}

                    <!-- PROFILE DROPDOWN -->
                    <div class="relative">
                        <!-- BUTTON -->
                        <button
                            id="profileButton"
                            onclick="toggleDropdown()"
                            class="flex items-center gap-3 bg-white border border-slate-200 hover:shadow-lg px-3 py-2 rounded-2xl transition duration-300"
                        >
                            <!-- AVATAR -->
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-primary to-softnavy text-white flex items-center justify-center font-bold text-lg shadow-lg"
                            >
                                {{ strtoupper(substr($tamu->nama,0,1)) }}
                            </div>

                            <!-- INFO -->
                            <div class="hidden md:block text-left">
                                <p class="text-xs text-slate-500">Selamat Datang</p>

                                <h2 class="font-bold text-primary leading-none">
                                    {{ explode(' ', $tamu->nama)[0] }}
                                </h2>
                            </div>

                            <i class="bi bi-chevron-down text-slate-400"></i>
                        </button>

                        <!-- DROPDOWN -->
                        <div
                            id="profileDropdown"
                            class="hidden absolute right-0 mt-4 w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-50"
                        >
                            <!-- HEADER -->
                            <div
                                class="bg-gradient-to-r from-primary to-softnavy p-6 text-white"
                            >
                                <div class="flex items-center gap-4">
                                    <!-- AVATAR -->
                                    <div
                                        class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold"
                                    >
                                        {{ strtoupper(substr($tamu->nama,0,1)) }}
                                    </div>

                                    <!-- INFO -->
                                    <div>
                                        <h3 class="font-bold text-lg">
                                            {{ $tamu->nama }}
                                        </h3>

                                        <p
                                            class="text-white/70 text-sm truncate max-w-[180px]"
                                        >
                                            {{ $tamu->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- MENU -->
                            <div class="p-3 space-y-2">
                                <!-- PROFIL -->
                                <a
                                    href="{{ route('tamu.profil') }}"
                                    class="flex items-center gap-4 px-4 py-4 rounded-2xl hover:bg-slate-100 transition duration-300"
                                >
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-xl"
                                    >
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-800">
                                            Profil Saya
                                        </h4>

                                        <p
                                            class="text-sm text-slate-500"
                                        >Kelola akun & password</p>
                                    </div>
                                </a>

                                <!-- RIWAYAT -->
                                <a
                                    href="{{ route('tamu.riwayat') }}"
                                    class="flex items-center gap-4 px-4 py-4 rounded-2xl hover:bg-slate-100 transition duration-300"
                                >
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-xl"
                                    >
                                        <i class="bi bi-clock-history"></i>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-800">
                                            Riwayat Kunjungan
                                        </h4>

                                        <p
                                            class="text-sm text-slate-500"
                                        >Lihat status kunjungan</p>
                                    </div>
                                </a>

                                <!-- LOGOUT -->
                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                >
                                    @csrf

                                    <button
                                        class="w-full flex items-center gap-4 px-4 py-4 rounded-2xl hover:bg-red-50 transition duration-300 text-left"
                                    >
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-xl"
                                        >
                                            <i
                                                class="bi bi-box-arrow-right"
                                            ></i>
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-red-600">
                                                Logout
                                            </h4>

                                            <p
                                                class="text-sm text-slate-500"
                                            >Keluar dari sistem</p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- =========================
     CONTENT
========================= -->

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- ALERT -->
        @if (session('success'))
            <div
                class="mb-6 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl animate-fade-up"
            >
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>

                    <span> {{ session('success') }} </span>
                </div>
            </div>

        @endif

        <!-- =========================
         HERO SECTION
    ========================= -->

        <div class="grid lg:grid-cols-3 gap-6 mb-8">
            <!-- WELCOME -->
            <div class="lg:col-span-2">
                <div
                    class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary to-softnavy p-8 text-white shadow-xl animate-fade-up h-full"
                >
                    <!-- Decoration -->
                    <div
                        class="absolute -top-16 -right-10 w-52 h-52 bg-white/5 rounded-full"
                    ></div>

                    <div
                        class="absolute bottom-0 right-0 opacity-10 text-[160px]"
                    >
                        <i class="bi bi-building"></i>
                    </div>

                    <div class="relative z-10">
                        <p class="text-secondary font-semibold mb-3">Dashboard Tamu</p>

                        <h2 class="text-3xl font-extrabold mb-4 leading-snug">
                            Selamat Datang, {{ explode(' ', $tamu->nama)[0] }} 👋
                        </h2>

                        <p
                            class="text-white/80 leading-8 max-w-2xl"
                        >Gunakan layanan digital KSOP Kelas I Dumai untuk melakukan pendaftaran kunjungan, melihat status persetujuan, dan memantau riwayat kunjungan Anda.</p>
                    </div>
                </div>
            </div>

            <!-- JAM OPERASIONAL -->
            <div>
                <div
                    class="bg-white rounded-3xl shadow-lg p-6 h-full border border-slate-100 animate-fade-up delay-100"
                >
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-secondary/20 text-secondary flex items-center justify-center text-xl"
                        >
                            <i class="bi bi-clock-fill"></i>
                        </div>

                        <div>
                            <h3 class="font-extrabold text-primary">
                                Jam Operasional
                            </h3>

                            <p class="text-sm text-slate-500">Pelayanan Kantor</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500"> Senin - Kamis </span>

                            <span class="font-bold text-primary">
                                08:00 - 16:30
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500"> Jumat </span>

                            <span class="font-bold text-primary">
                                08:00 - 17:00
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500"> Sabtu - Minggu </span>

                            <span
                                class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold"
                            >
                                Tutup
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-5 bg-slate-100 rounded-2xl p-4 text-sm text-slate-600 leading-6"
                    >
                        <i class="bi bi-info-circle-fill text-primary mr-1"></i>

                        Mohon hadir 15 menit sebelum jadwal kunjungan.
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================
         QUICK ACTION
    ========================= -->

        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- BUAT KUNJUNGAN -->
            <div
                class="bg-white rounded-3xl shadow-lg p-7 border border-slate-100 hover:shadow-[0_15px_40px_rgba(11,31,58,0.18)] hover:-translate-y-2 transition duration-300 animate-fade-up delay-200"
            >
                <div
                    class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-3xl mb-5"
                >
                    <i class="bi bi-plus-lg"></i>
                </div>

                <h3 class="text-2xl font-extrabold text-primary mb-3">
                    Buat Kunjungan
                </h3>

                <p
                    class="text-slate-500 leading-7 mb-6"
                >Daftarkan agenda kunjungan Anda untuk mendapatkan nomor antrian digital.</p>

                <a
                    href="{{ route('tamu.kunjungan.form') }}"
                    class="inline-flex items-center justify-center w-full bg-gradient-to-r from-primary to-softnavy text-white py-4 rounded-2xl font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                >
                    Daftar Sekarang
                </a>
            </div>

            <!-- RIWAYAT -->
            <div
                class="bg-white rounded-3xl shadow-lg p-7 border border-slate-100 hover:shadow-[0_15px_40px_rgba(11,31,58,0.18)] hover:-translate-y-2 transition duration-300 animate-fade-up delay-300"
            >
                <div
                    class="w-16 h-16 rounded-2xl bg-secondary/20 text-secondary flex items-center justify-center text-3xl mb-5"
                >
                    <i class="bi bi-clock-history"></i>
                </div>

                <h3 class="text-2xl font-extrabold text-primary mb-3">
                    Riwayat & Status
                </h3>

                <p
                    class="text-slate-500 leading-7 mb-6"
                >Pantau status persetujuan dan lihat riwayat kunjungan sebelumnya.</p>

                <a
                    href="{{ route('tamu.riwayat') }}"
                    class="inline-flex items-center justify-center w-full border-2 border-primary text-primary py-4 rounded-2xl font-bold hover:bg-primary hover:text-white hover:-translate-y-1 transition duration-300"
                >
                    Lihat Riwayat
                </a>
            </div>
        </div>

        <!-- =========================
         KUNJUNGAN TERAKHIR
    ========================= -->

        @if ($kunjunganTerakhir)
            @php
            $s = $kunjunganTerakhir->status_kunjungan;
        @endphp
            <div
                class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden animate-fade-up delay-500"
            >
                <!-- HEADER -->
                <div
                    class="bg-gradient-to-r from-primary to-softnavy px-8 py-5 text-white"
                >
                    <h3 class="text-xl font-extrabold">
                        <i class="bi bi-info-circle-fill mr-2"></i>

                        Kunjungan Terakhir Anda
                    </h3>
                </div>

                <!-- CONTENT -->
                <div class="p-8">
                    <div class="grid md:grid-cols-4 gap-6 items-center">
                        <!-- ANTRIAN -->
                        <div>
                            <p
                                class="text-sm text-slate-500 mb-1"
                            >Nomor Antrian</p>

                            <h2 class="text-4xl font-extrabold text-primary">
                                #{{ $kunjunganTerakhir->nomor_antrian }}
                            </h2>
                        </div>

                        <!-- KEPERLUAN -->
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Keperluan</p>

                            <h3 class="font-bold text-slate-800">
                                {{ $kunjunganTerakhir->keperluan }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{
                                \Carbon\Carbon::parse(
                                    $kunjunganTerakhir->tanggal_kunjungan
                                )->format('d M Y')
                            }}
                            </p>
                        </div>

                        <!-- STATUS -->
                        <div>
                            <p class="text-sm text-slate-500 mb-2">Status</p>

                            <span
                                class="
                                px-4 py-2
                                rounded-full
                                text-sm font-bold

                                {{
                                    $s == 'diterima'
                                    ? ($kunjunganTerakhir->is_served ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700')
                                    : (
                                        $s == 'ditolak'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-yellow-100 text-yellow-700'
                                    )
                                }}
                            "
                            >
                                {{ $s == 'diterima' && $kunjunganTerakhir->is_served ? 'Selesai Dilayani' : ucfirst($s) }}
                            </span>
                        </div>

                        <!-- BUTTON -->
                        <div class="md:text-right flex items-center justify-end gap-3">
                            @if ($kunjunganTerakhir->status_kunjungan === 'diterima' && !$kunjunganTerakhir->is_served)
                                <button
                                    type="button"
                                    onclick="openConfirmModal('{{ route('tamu.kunjungan.selesai', $kunjunganTerakhir->id_kunjungan) }}')"
                                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-2xl font-semibold transition duration-300 shadow-sm"
                                >
                                    <i class="bi bi-check-lg"></i>
                                    Selesai
                                </button>
                            @endif

                            <a
                                href="{{ route('tamu.antrian', $kunjunganTerakhir->id_kunjungan) }}"
                                class="inline-flex items-center justify-center bg-slate-100 hover:bg-primary hover:text-white px-6 py-3 rounded-2xl font-semibold transition duration-300 hover:-translate-y-1"
                            >
                                Detail
                            </a>
                        </div>
                    </div>
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

    <!-- =========================
     DROPDOWN & MODAL SCRIPT
========================= -->

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');

            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function (e) {
            const button = document.getElementById('profileButton');

            const dropdown = document.getElementById('profileDropdown');

            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Modal Functions
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
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            // Hide modal
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            dialog.classList.remove('scale-100');
            dialog.classList.add('scale-90');
            document.body.style.overflow = '';
        }

        // Close modal when clicking backdrop
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.classList.contains('absolute')) {
                closeModal();
            }
        });
    </script>
</body>
</html>
