<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Profil Saya - KSOP Dumai</title>

    <!-- ICON -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />

    @vite ('resources/css/app.css')
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
                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('tamu.dashboard') }}"
                        class="px-5 py-3 rounded-2xl border border-slate-200 hover:bg-slate-100 font-semibold transition"
                    >
                        <i class="bi bi-house-door mr-2"></i>

                        Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-2xl transition duration-300"
                        >
                            <i class="bi bi-box-arrow-right mr-1"></i>

                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- =========================
     CONTENT
========================= -->

    <div class="max-w-5xl mx-auto px-6 py-10">
        <!-- ALERT -->
        @if (session('success'))
            <div
                class="mb-6 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl"
            >
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>

                    <span> {{ session('success') }} </span>
                </div>
            </div>

        @endif

        <!-- PROFILE CARD -->
        <div
            class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100"
        >
            <!-- HEADER -->
            <div
                class="relative overflow-hidden bg-gradient-to-r from-primary to-softnavy px-8 py-10 text-white"
            >
                <!-- BACKGROUND ICON -->
                <div class="absolute -right-10 -top-10 opacity-10 text-[180px]">
                    <i class="bi bi-person-circle"></i>
                </div>

                <div
                    class="relative z-10 flex flex-col md:flex-row items-center gap-6"
                >
                    <!-- AVATAR -->
                    <div
                        class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-md border-4 border-white/20 flex items-center justify-center text-5xl font-bold shadow-2xl"
                    >
                        {{ strtoupper(substr($tamu->nama,0,1)) }}
                    </div>

                    <!-- INFO -->
                    <div>
                        <p class="text-white/70 mb-2">Profil Tamu</p>

                        <h1 class="text-3xl md:text-4xl font-extrabold">
                            {{ $tamu->nama }}
                        </h1>

                        <p class="text-white/80 mt-2">Kelola informasi akun dan keamanan Anda.</p>
                    </div>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-8">
                <form action="{{ route('tamu.profil.update') }}" method="POST">
                    @csrf
                    @method ('PUT')

                    <!-- INFORMASI -->
                    <div>
                        <h2 class="text-2xl font-extrabold text-primary mb-6">
                            Informasi Akun
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- NAMA -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Nama Lengkap
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="text"
                                        name="nama"
                                        value="{{ old('nama', $tamu->nama) }}"
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Email
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $tamu->email) }}"
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- NO HP -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Nomor HP
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="text"
                                        name="no_hp"
                                        value="{{ old('no_hp', $tamu->no_hp) }}"
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- INSTANSI -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Instansi
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-building absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="text"
                                        name="instansi"
                                        value="{{ old('instansi', $tamu->instansi) }}"
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-extrabold text-primary mb-6">
                            Keamanan Akun
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- PASSWORD -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Password Baru
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Kosongkan jika tidak diubah"
                                        class="w-full pl-12 pr-14 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                    />

                                    <button
                                        type="button"
                                        onclick="togglePassword()"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    >
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- KONFIRMASI -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-slate-700 mb-2"
                                >
                                    Konfirmasi Password
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    ></i>

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div
                        class="mt-10 flex flex-col md:flex-row gap-4 justify-end"
                    >
                        <a
                            href="{{ route('tamu.dashboard') }}"
                            class="px-6 py-4 rounded-2xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-100 transition text-center"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-primary to-softnavy text-white font-bold shadow-xl hover:scale-105 transition duration-300"
                        >
                            <i class="bi bi-check-circle mr-2"></i>

                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SHOW PASSWORD -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');

            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';

                eyeIcon.classList.remove('bi-eye');

                eyeIcon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';

                eyeIcon.classList.remove('bi-eye-slash');

                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
