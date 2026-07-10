<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Antrian Sebelum Anda - KSOP Dumai</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    @vite ('resources/css/app.css')
    <style>
        /* =========================
           ANIMATION
        ========================= */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(35px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-6 py-10">
        <div class="w-full max-w-2xl">
            <!-- BACK BUTTON -->
            <div class="mb-6 animate-fade-up">
                <a href="{{ route('tamu.antrian', $kunjungan->id_kunjungan) }}" class="inline-flex items-center gap-3 text-slate-600 hover:text-primary transition duration-300 font-semibold">
                    <div class="w-11 h-11 rounded-2xl bg-white shadow-md flex items-center justify-center">
                        <i class="bi bi-arrow-left text-lg"></i>
                    </div>
                    Kembali ke Halaman Antrian
                </a>
            </div>

            <div class="bg-white rounded-[36px] shadow-2xl border border-slate-100 overflow-hidden animate-fade-up">
                <div class="relative overflow-hidden bg-gradient-to-r from-primary to-softnavy px-8 py-10 text-white text-center">
                    <div class="absolute -top-16 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
                    <div class="absolute -bottom-20 -left-10 w-52 h-52 bg-secondary/10 rounded-full"></div>
                    
                    <div class="relative z-10 w-24 h-24 mx-auto rounded-full bg-white flex items-center justify-center shadow-2xl mb-5">
                        <i class="bi bi-people-fill text-5xl text-primary"></i>
                    </div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-extrabold mb-3">Antrian Sebelum Anda</h1>
                        <p class="text-white/75 leading-7 max-w-md mx-auto">Daftar pengunjung yang sedang menunggu giliran sebelum nomor antrian Anda di bagian {{ $kunjungan->subbagian->nama_subbagian }}.</p>
                    </div>
                </div>

                <div class="p-8 lg:p-10">
                    <div class="bg-slate-50 rounded-[28px] p-6 border border-slate-200 mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                                <i class="bi bi-list-ol"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-primary">Daftar Antrian</h3>
                                <p class="text-sm text-slate-500" id="refresh-indicator">Update otomatis secara realtime</p>
                            </div>
                        </div>

                        <div id="antrian-sebelum-container">
                            @if(isset($antrianSebelum) && $antrianSebelum->count() > 0)
                                <div class="flex flex-wrap gap-3" id="antrian-sebelum-list">
                                    @foreach($antrianSebelum as $as)
                                        <div class="bg-blue-100 text-blue-700 px-5 py-3 rounded-2xl font-bold shadow-sm">
                                            {{ $as->nomor_antrian }}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-yellow-100 text-yellow-700 px-5 py-4 rounded-2xl text-center font-medium" id="antrian-sebelum-empty">
                                    Tidak ada antrian yang menunggu sebelum Anda.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="border-t border-slate-100 px-8 py-5 bg-slate-50 text-center">
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
                    const antrianSebelumContainerEl = document.getElementById('antrian-sebelum-container');
                    if (data.antrian_sebelum && antrianSebelumContainerEl) {
                        if (data.antrian_sebelum.length > 0) {
                            let htmlList = '<div class="flex flex-wrap gap-3" id="antrian-sebelum-list">';
                            data.antrian_sebelum.forEach(nomor => {
                                htmlList += `<div class="bg-blue-100 text-blue-700 px-5 py-3 rounded-2xl font-bold shadow-sm">${nomor}</div>`;
                            });
                            htmlList += '</div>';
                            antrianSebelumContainerEl.innerHTML = htmlList;
                        } else {
                            antrianSebelumContainerEl.innerHTML = `
                                <div class="bg-yellow-100 text-yellow-700 px-5 py-4 rounded-2xl text-center font-medium" id="antrian-sebelum-empty">
                                    Tidak ada antrian yang menunggu sebelum Anda.
                                </div>
                            `;
                        }
                    }
                })
                .catch(err => console.error("Error checking queue update:", err));
        }

        // Polling setiap 3 detik
        setInterval(checkRealtimeQueue, 3000);
    </script>
</body>
</html>
