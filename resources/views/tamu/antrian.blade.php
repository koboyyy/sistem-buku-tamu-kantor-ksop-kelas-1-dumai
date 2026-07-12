<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Nomor Antrian - KSOP Dumai</title>

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

<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <!-- =========================
         CONTAINER
    ========================= -->

    <div class="min-h-screen flex items-center justify-center px-6 py-10">
        <div class="w-full max-w-2xl">
            <!-- BACK BUTTON -->
            <div class="mb-6 animate-fade-up">
                <a
                    href="{{ route('tamu.dashboard') }}"
                    class="inline-flex items-center gap-3 text-slate-600 hover:text-primary transition duration-300 font-semibold"
                >
                    <div
                        class="w-11 h-11 rounded-2xl bg-white shadow-md flex items-center justify-center"
                    >
                        <i class="bi bi-arrow-left text-lg"></i>
                    </div>

                    Kembali ke Dashboard
                </a>
            </div>

            <!-- =========================
                 CARD
            ========================= -->

            <div
                class="bg-white rounded-[36px] shadow-2xl border border-slate-100 overflow-hidden animate-fade-up"
            >
                <!-- HEADER -->
                <div
                    class="relative overflow-hidden bg-gradient-to-r from-primary to-softnavy px-8 py-10 text-white text-center"
                >
                    <!-- Decoration -->
                    <div
                        class="absolute -top-16 -right-10 w-48 h-48 bg-white/5 rounded-full"
                    ></div>

                    <div
                        class="absolute -bottom-20 -left-10 w-52 h-52 bg-secondary/10 rounded-full"
                    ></div>

                    <!-- ICON -->
                    <div
                        class="relative z-10 w-24 h-24 mx-auto rounded-full bg-white flex items-center justify-center shadow-2xl mb-5 animate-pulse-soft"
                    >
                        <i class="bi bi-check-lg text-5xl text-green-600"></i>
                    </div>

                    <div class="relative z-10">
                        <p class="text-secondary font-semibold mb-2">Pendaftaran Berhasil</p>

                        <h1 class="text-3xl font-extrabold mb-3">
                            Nomor Antrian Anda
                        </h1>

                        <p class="text-white/75 leading-7 max-w-md mx-auto">Silakan simpan atau cetak tiket digital ini untuk ditunjukkan kepada petugas.</p>
                    </div>
                </div>

                <!-- BODY -->
                <div class="p-8 lg:p-10">
                    <!-- NOMOR -->
                    <div class="text-center mb-8">
                        <p class="text-slate-500 text-sm uppercase tracking-[3px] mb-4">Nomor Antrian</p>

                        <div
                            class="inline-flex items-center justify-center bg-primary/5 border-4 border-dashed border-primary rounded-[28px] px-10 py-6 animate-pulse-soft"
                        >
                            <span
                                class="text-6xl font-black tracking-[6px] text-primary"
                            >
                                {{ $kunjungan->nomor_antrian }}
                            </span>
                        </div>
                    </div>

                    <!-- =========================
                         INFO ANTRIAN
                    ========================= -->

                    <div
                        class="bg-primary/5 rounded-[28px] p-6 border border-primary/10 mb-8"
                    >
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center text-lg"
                            >
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-primary">
                                    Informasi Antrian
                                </h3>

                                <p class="text-sm text-slate-500">Progress antrian realtime</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- NOMOR ANDA -->
                            <div class="flex justify-between">
                                <span class="text-slate-600"> Nomor Anda </span>

                                <strong class="text-primary">
                                    {{ $kunjungan->nomor_antrian }}
                                </strong>
                            </div>

                            <!-- TERAKHIR -->
                            <div class="flex justify-between">
                                <span class="text-slate-600">
                                    Terakhir Dilayani
                                </span>

                                <strong class="text-primary" id="terakhir-dilayani">
                                    {{ $current->nomor_antrian ?? '-' }}
                                </strong>
                            </div>

                            <!-- SISA -->
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">
                                    Sisa nomor antrian yang dilayani
                                </span>

                                <strong class="text-primary" id="estimasi-sisa">
                                    {{ $estimasiSisa }}
                                </strong>
                            </div>

                            <!-- TOMBOL LIHAT ANTRIAN SEBELUM -->
                            <div class="mt-4 pt-4 border-t border-primary/10">
                                <a href="{{ route('tamu.antrian.sebelum', $kunjungan->id_kunjungan) }}" class="block w-full py-2 bg-white text-center text-primary text-sm font-semibold rounded-xl border border-primary/20 hover:bg-primary/10 transition">
                                    Lihat Nomor Antrian Yang Sedang Di Layani
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- =========================
                         NOMOR SUDAH DILAYANI
                    ========================= -->

                    <div
                        class="bg-slate-50 rounded-[28px] p-6 border border-slate-200 mb-8"
                    >
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-lg"
                            >
                                <i class="bi bi-check2-circle"></i>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-primary">
                                    Nomor Sudah Dilayani
                                </h3>

                                <p class="text-sm text-slate-500" id="refresh-indicator">Update otomatis secara realtime</p>
                            </div>
                        </div>

                        <div id="nomor-sudah-dilayani-container">
                            @if ($sudahDilayani->count())
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($sudahDilayani as $item)
                                        <div
                                            class="bg-green-100 text-green-700 px-5 py-3 rounded-2xl font-bold shadow-sm"
                                        >
                                            {{ $item->nomor_antrian }}
                                        </div>

                                    @endforeach
                                </div>

                            @else
                                <div
                                    class="bg-yellow-100 text-yellow-700 px-5 py-4 rounded-2xl"
                                >
                                    Belum ada antrian yang selesai dilayani.
                                </div>

                            @endif
                        </div>
                    </div>

                    <!-- INFO DETAIL -->
                    <div
                        class="bg-slate-50 rounded-[28px] p-6 border border-slate-200 mb-8"
                    >
                        <div class="space-y-6">
                            <!-- TANGGAL -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-lg"
                                    >
                                        <i class="bi bi-calendar3"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Tanggal Kunjungan</p>

                                        <h3 class="font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d M Y') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- JAM -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-secondary/20 text-secondary flex items-center justify-center text-lg"
                                    >
                                        <i class="bi bi-clock"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Estimasi Kedatangan</p>

                                        <h3 class="font-bold text-slate-800">
                                            {{ $kunjungan->jam_masuk }} WIB
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- TUJUAN -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-lg"
                                    >
                                        <i class="bi bi-building"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm text-slate-500">Tujuan Bidang</p>

                                        <h3 class="font-bold text-slate-800">
                                            {{ $kunjungan->bidang->nama_bidang }}
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $kunjungan->subbagian->nama_subbagian }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- STATUS -->
                             <div class="flex items-start justify-between gap-4" id="status-kunjungan-container">
                                 <div class="flex items-center gap-3">
                                      @if ($kunjungan->status_kunjungan === 'diterima')
                                          @if ($kunjungan->is_served)
                                              <div
                                                  class="w-12 h-12 rounded-2xl bg-green-600 text-white flex items-center justify-center text-lg shadow-lg shadow-green-500/20"
                                              >
                                                  <i class="bi bi-check-circle-fill"></i>
                                              </div>

                                              <div>
                                                  <p class="text-sm text-slate-500">Status Kunjungan</p>

                                                  <span
                                                      class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold mt-2 shadow-sm animate-pulse"
                                                  >
                                                      <i
                                                          class="bi bi-check-circle-fill"
                                                      ></i>

                                                      Selesai Dilayani
                                                  </span>
                                              </div>
                                          @else
                                              <div
                                                  class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-lg"
                                              >
                                                  <i class="bi bi-check-circle"></i>
                                              </div>

                                              <div>
                                                  <p class="text-sm text-slate-500">Status Kunjungan</p>

                                                  <span
                                                      class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold mt-2"
                                                  >
                                                      <i
                                                          class="bi bi-check-circle"
                                                      ></i>

                                                      Diterima
                                                  </span>
                                              </div>
                                          @endif
                                     @elseif ($kunjungan->status_kunjungan === 'ditolak')
                                         <div
                                             class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-lg"
                                         >
                                             <i class="bi bi-x-circle"></i>
                                         </div>

                                         <div>
                                             <p class="text-sm text-slate-500">Status Kunjungan</p>

                                             <span
                                                 class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold mt-2"
                                             >
                                                 <i
                                                     class="bi bi-x-circle"
                                                 ></i>

                                                 Ditolak
                                             </span>

                                             @if($kunjungan->keterangan)
                                                 <p class="text-xs text-red-600 mt-2 font-medium">
                                                     Keterangan: {{ $kunjungan->keterangan }}
                                                 </p>
                                             @endif
                                         </div>
                                     @else
                                         <div
                                             class="w-12 h-12 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg"
                                         >
                                             <i class="bi bi-hourglass-split"></i>
                                         </div>

                                         <div>
                                             <p class="text-sm text-slate-500">Status Kunjungan</p>

                                             <span
                                                 class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold mt-2"
                                             >
                                                 <i
                                                     class="bi bi-hourglass-split"
                                                 ></i>

                                                 Pending
                                             </span>
                                         </div>
                                     @endif
                                 </div>
                             </div>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- PRINT -->
                        <button
                            onclick="window.print()"
                            class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-primary to-softnavy text-white px-6 py-4 rounded-2xl font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                        >
                            <i class="bi bi-printer"></i>

                            Cetak Tiket
                        </button>

                        <!-- RIWAYAT -->
                        <a
                            href="{{ route('tamu.riwayat') }}"
                            class="inline-flex items-center justify-center gap-3 border-2 border-primary text-primary px-6 py-4 rounded-2xl font-bold hover:bg-primary hover:text-white hover:-translate-y-1 transition duration-300"
                        >
                            <i class="bi bi-clock-history"></i>

                            Lihat Riwayat
                        </a>
                    </div>
                </div>

                <!-- FOOTER -->
                <div
                    class="border-t border-slate-100 px-8 py-5 bg-slate-50 text-center"
                >
                    <p class="text-sm text-slate-500">
                        <i class="bi bi-shield-lock mr-1 text-primary"></i>

                        Sistem Buku Tamu Digital KSOP Kelas I Dumai
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- REALTIME POLLING -->
    <script>
        const kunjunganId = {{ $kunjungan->id_kunjungan }};
        const realtimeUrl = "{{ route('tamu.antrian.realtime', $kunjungan->id_kunjungan) }}";

        function checkRealtimeQueue() {
            fetch(realtimeUrl)
                .then(response => response.json())
                .then(data => {
                    // 1. Update Terakhir Dilayani
                    const terakhirDilayaniEl = document.getElementById('terakhir-dilayani');
                    if (terakhirDilayaniEl) {
                        terakhirDilayaniEl.textContent = data.current_nomor_antrian;
                    }

                    // 2. Update Estimasi Sisa
                    const estimasiSisaEl = document.getElementById('estimasi-sisa');
                    if (estimasiSisaEl) {
                        estimasiSisaEl.textContent = data.estimasi_sisa;
                    }

                    // 3. Update Nomor Sudah Dilayani List
                    const sudahDilayaniListEl = document.getElementById('nomor-sudah-dilayani-container');
                    if (sudahDilayaniListEl) {
                        if (data.sudah_dilayani.length > 0) {
                            let html = '<div class="flex flex-wrap gap-3">';
                            data.sudah_dilayani.forEach(item => {
                                html += `<div class="bg-green-100 text-green-700 px-5 py-3 rounded-2xl font-bold shadow-sm">${item}</div>`;
                            });
                            html += '</div>';
                            sudahDilayaniListEl.innerHTML = html;
                        } else {
                            sudahDilayaniListEl.innerHTML = `
                                <div class="bg-yellow-100 text-yellow-700 px-5 py-4 rounded-2xl">
                                    Belum ada antrian yang selesai dilayani.
                                </div>
                            `;
                        }
                    }

                    // 4. Update Status Kunjungan Container
                    const statusContainerEl = document.getElementById('status-kunjungan-container');
                    if (statusContainerEl) {
                        let html = '<div class="flex items-center gap-3">';
                        if (data.status_kunjungan === 'diterima') {
                            if (data.is_served) {
                                html += `
                                    <div class="w-12 h-12 rounded-2xl bg-green-600 text-white flex items-center justify-center text-lg shadow-lg shadow-green-500/20">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500">Status Kunjungan</p>
                                        <span class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold mt-2 shadow-sm animate-pulse">
                                            <i class="bi bi-check-circle-fill"></i> Selesai Dilayani
                                        </span>
                                    </div>
                                `;
                            } else {
                                html += `
                                    <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-lg">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500">Status Kunjungan</p>
                                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold mt-2">
                                            <i class="bi bi-check-circle"></i> Diterima
                                        </span>
                                    </div>
                                `;
                            }
                        } else if (data.status_kunjungan === 'ditolak') {
                            html += `
                                <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-lg">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Status Kunjungan</p>
                                    <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold mt-2">
                                        <i class="bi bi-x-circle"></i> Ditolak
                                    </span>
                                    ${data.keterangan ? `<p class="text-xs text-red-600 mt-2 font-medium">Keterangan: ${data.keterangan}</p>` : ''}
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="w-12 h-12 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Status Kunjungan</p>
                                    <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold mt-2">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                </div>
                            `;
                        }
                        html += '</div>';
                        statusContainerEl.innerHTML = html;
                    }
                })
                .catch(err => console.error("Error checking queue update:", err));
        }

        // Polling setiap 3 detik
        setInterval(checkRealtimeQueue, 3000);
    </script>
</body>
</html>
