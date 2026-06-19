<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Login - KSOP Dumai</title>

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

        @keyframes pulseSoft {
            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
        }

        .animate-pulse-soft {
            animation: pulseSoft 2.5s infinite;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 overflow-x-hidden"
>
    <!-- =========================
         MAIN WRAPPER
    ========================= -->

    <div class="grid lg:grid-cols-2 min-h-screen">
        <!-- =========================
             LEFT SIDE
        ========================= -->

        <div class="relative hidden lg:block animate-fade-up">
            <!-- IMAGE -->
            <img
                src="{{ asset('kantor-kasop-kelas-1-dumai.png') }}"
                alt="Kantor KSOP"
                class="w-full h-full min-h-screen object-cover"
            />

            <!-- OVERLAY -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-primary/20"
            ></div>

            <!-- CONTENT -->
            <div
                class="absolute inset-0 flex flex-col justify-end p-16 text-white"
            >
                <div class="max-w-xl">
                    <p class="text-secondary font-bold tracking-[3px] uppercase mb-4">Buku Tamu Digital</p>

                    <h1 class="text-5xl font-black leading-tight mb-6">
                        KSOP Kelas I Dumai
                    </h1>

                    <p class="text-white/80 leading-8 text-lg">Sistem pelayanan kunjungan digital Kantor Kesyahbandaran dan Otoritas Pelabuhan Kelas I Dumai.</p>
                </div>
            </div>
        </div>

        <!-- =========================
             RIGHT SIDE
        ========================= -->

        <div class="flex items-center justify-center px-6 py-14 lg:px-14">
            <div class="w-full max-w-md animate-fade-up lg:py-0 py-10">
                <!-- =========================
                     LOGO
                ========================= -->

                <div class="text-center mb-8">
                    <div
                        class="w-28 h-28 mx-auto rounded-full bg-white shadow-2xl flex items-center justify-center mb-5 animate-pulse-soft"
                    >
                        <img
                            src="{{ asset('logo-ksop-kelas-1-dumai.png') }}"
                            alt="Logo KSOP"
                            class="w-20"
                        />
                    </div>

                    <h2
                        class="text-4xl font-black text-primary mb-3 leading-tight"
                    >
                        Selamat Datang
                    </h2>

                    <p class="text-slate-500 leading-7 text-base">Silakan login untuk mengakses sistem Buku Tamu Digital KSOP Dumai</p>
                </div>

                <!-- =========================
                     ERROR
                ========================= -->

                @if ($errors->any())
                    <div
                        class="mb-6 bg-red-100 border border-red-200 text-red-700 px-5 py-4 rounded-2xl animate-fade-up"
                    >
                        <div class="flex items-start gap-3">
                            <i
                                class="bi bi-exclamation-circle-fill text-lg"
                            ></i>

                            <span class="leading-7">
                                {{ $errors->first() }}
                            </span>
                        </div>
                    </div>

                @endif

                <!-- =========================
                     LOGIN CARD
                ========================= -->

                <div
                    class="bg-white rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden"
                >
                    <!-- HEADER -->
                    <div
                        class="bg-gradient-to-r from-primary to-softnavy px-8 py-6 text-white"
                    >
                        <h3
                            class="text-2xl font-extrabold flex items-center gap-3"
                        >
                            <i class="bi bi-person-lock"></i>

                            Login Sistem
                        </h3>

                        <p class="text-white/70 text-sm mt-2 leading-6">Admin dan tamu menggunakan satu portal login sistem.</p>
                    </div>

                    <!-- BODY -->
                    <div class="p-6 sm:p-8">
                        <form
                            action="{{ route('login.process') }}"
                            method="POST"
                            class="space-y-6"
                        >
                            @csrf

                            <!-- USERNAME -->
                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Username / Email
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-person-fill absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <input
                                        type="text"
                                        name="login"
                                        value="{{ old('login') }}"
                                        placeholder="Masukkan username atau email"
                                        class="w-full border border-slate-300 rounded-2xl pl-14 pr-4 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- PASSWORD -->
                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Password
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-lock-fill absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="Masukkan password"
                                        class="w-full border border-slate-300 rounded-2xl pl-14 pr-4 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- BUTTON -->
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-3 bg-gradient-to-r from-primary to-softnavy text-white py-4 rounded-2xl font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                            >
                                <i class="bi bi-box-arrow-in-right"></i>

                                Login
                            </button>
                        </form>

                        <!-- REGISTER -->
                        <div class="mt-8 text-center">
                            <p class="text-slate-500">Belum memiliki akun?</p>

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 text-secondary font-bold mt-2 hover:text-primary transition duration-300"
                            >
                                <i class="bi bi-person-plus-fill"></i>

                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- =========================
                     FOOTER
                ========================= -->

                <div class="mt-8 text-center pb-6">
                    <p class="text-sm text-slate-500 leading-6">
                        <i class="bi bi-shield-lock mr-1 text-primary"></i>

                        © {{ date('Y') }} KSOP Kelas I Dumai. All Rights
                        Reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
