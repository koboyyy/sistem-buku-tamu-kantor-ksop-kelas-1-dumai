<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Monitor Antrian - KSOP Dumai</title>

    <!-- ICON -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />

    @vite ('resources/css/app.css')

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease forwards;
        }

        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <!-- =========================
     HEADER
========================= -->

    <div
        class="relative overflow-hidden bg-gradient-to-r from-primary to-softnavy text-white shadow-2xl"
    >
        <!-- BG DECORATION -->
        <div
            class="absolute top-0 right-0 opacity-10 text-[250px] -translate-y-10 translate-x-10"
        >
            <i class="bi bi-broadcast"></i>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-10 relative z-10">
            <div
                class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8"
            >
                <!-- LEFT -->
                <div class="flex items-center gap-5">
                    <!-- LOGO -->
                    <img
                        src="{{ asset('logo-ksop-kelas-1-dumai.png') }}"
                        alt="Logo KSOP"
                        class="w-20"
                    />

                    <!-- TITLE -->
                    <div>
                        <p
                            class="text-secondary font-semibold mb-2 uppercase tracking-widest"
                        >Sistem Buku Tamu Digital</p>

                        <h1
                            class="text-4xl lg:text-5xl font-black leading-tight"
                        >
                            Monitor Antrian
                        </h1>

                        <p class="text-white/70 mt-3 text-lg">Monitoring realtime antrian tamu berdasarkan bidang tujuan</p>
                    </div>
                </div>

                <!-- RIGHT -->
                <div
                    class="glass rounded-[32px] px-8 py-6 border border-white/20 shadow-xl"
                >
                    <p class="text-white/70 text-sm mb-2">Bidang Tujuan</p>

                    <h2 class="text-3xl font-black leading-tight">
                        {{ $kunjungan->bidang->nama_bidang }}
                    </h2>

                    @if ($kunjungan->subbagian)
                        <p class="text-white/70 mt-2">
                            {{ $kunjungan->subbagian->nama_subbagian }}
                        </p>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- =========================
     CONTENT
========================= -->

    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- INFO -->
        <div
            class="bg-blue-50 border border-blue-200 text-blue-700 rounded-3xl px-6 py-5 mb-8 animate-fade-up"
        >
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl"
                >
                    <i class="bi bi-info-circle-fill"></i>
                </div>

                <div>
                    <h3 class="font-extrabold text-lg mb-1">
                        Informasi Monitoring
                    </h3>

                    <p class="leading-7">Anda hanya melihat antrian untuk bidang:

                    <span class="font-black"> {{ $kunjungan->bidang->nama_bidang }} </span>

                    sehingga antrian tidak tercampur dengan bidang lainnya.</p>
                </div>
            </div>
        </div>

        <!-- CURRENT NUMBER -->
        <div
            class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-[40px] shadow-2xl overflow-hidden mb-10 animate-fade-up"
        >
            <div class="p-10 text-white text-center">
                <p
                    class="uppercase tracking-[5px] text-white/70 font-bold mb-4"
                >Sedang Dilayani</p>

                <h1 class="text-7xl md:text-8xl font-black leading-none">
                    {{ $current->nomor_antrian ?? '-' }}
                </h1>

                <p class="mt-5 text-xl text-white/80">Nomor antrian aktif saat ini</p>
            </div>
        </div>

        <!-- GRID -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- =========================
             SUDAH DILAYANI
        ========================= -->

            <div
                class="bg-white rounded-[36px] shadow-2xl border border-slate-100 overflow-hidden animate-fade-up"
            >
                <!-- HEADER -->
                <div class="bg-green-600 text-white px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-3xl bg-white/20 flex items-center justify-center text-3xl"
                        >
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>
                            <p class="text-green-100 font-semibold">Queue Finished</p>

                            <h2 class="text-3xl font-black">Sudah Dilayani</h2>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="p-8">
                    @if ($sudahDilayani->count())
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach ($sudahDilayani as $item)
                                <div
                                    class="bg-green-100 text-green-700 rounded-3xl px-5 py-6 text-center shadow-sm border border-green-200 hover:scale-105 transition duration-300"
                                >
                                    <p class="text-sm mb-2">Antrian</p>

                                    <h3 class="text-3xl font-black">
                                        {{ $item->nomor_antrian }}
                                    </h3>
                                </div>

                            @endforeach
                        </div>

                    @else
                        <div
                            class="bg-yellow-100 text-yellow-700 px-6 py-5 rounded-3xl"
                        >
                            Belum ada antrian yang selesai dilayani.
                        </div>

                    @endif
                </div>
            </div>

            <!-- =========================
             BELUM DILAYANI
        ========================= -->

            <div
                class="bg-white rounded-[36px] shadow-2xl border border-slate-100 overflow-hidden animate-fade-up"
            >
                <!-- HEADER -->
                <div class="bg-primary text-white px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-3xl bg-white/20 flex items-center justify-center text-3xl"
                        >
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                        <div>
                            <p class="text-blue-100 font-semibold">Waiting Queue</p>

                            <h2 class="text-3xl font-black">Menunggu</h2>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="p-8">
                    @if ($belumDilayani->count())
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach ($belumDilayani as $item)
                                <div
                                    class="bg-primary/10 text-primary rounded-3xl px-5 py-6 text-center shadow-sm border border-primary/20 hover:scale-105 transition duration-300"
                                >
                                    <p class="text-sm mb-2">Antrian</p>

                                    <h3 class="text-3xl font-black">
                                        {{ $item->nomor_antrian }}
                                    </h3>
                                </div>

                            @endforeach
                        </div>

                    @else
                        <div
                            class="bg-green-100 text-green-700 px-6 py-5 rounded-3xl"
                        >
                            Semua antrian sudah selesai dilayani.
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- =========================
     AUTO REFRESH
========================= -->

    <script>
        setTimeout(() => {
            location.reload();
        }, 10000);
    </script>
</body>
</html>
