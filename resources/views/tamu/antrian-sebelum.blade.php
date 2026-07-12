<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nomor Antrian Yang Sedang Berjalan - KSOP Dumai</title>
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
        <div class="w-full max-w-7xl">
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
                        <i class="bi bi-display text-5xl text-primary"></i>
                    </div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-extrabold mb-3">Nomor Antrian Yang Sedang Berjalan</h1>
                        <p class="text-white/75 leading-7 max-w-md mx-auto">Daftar pengunjung yang sedang dilayani dan menunggu giliran sebelum nomor antrian Anda di bagian {{ $kunjungan->subbagian->nama_subbagian }}.</p>
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

                        <div id="antrian-sebelum-container" class="overflow-x-auto rounded-[20px] border-4 border-[#0B1B3D] shadow-2xl bg-[#0B1B3D]">
                            @if(isset($antrianSebelum) && $antrianSebelum->count() > 0)
                                <table class="w-full text-left border-collapse min-w-[600px]">
                                    <thead>
                                        <tr class="bg-[#1a2d5c] text-blue-200 text-xs uppercase tracking-widest border-b-2 border-blue-800">
                                            <th class="px-6 py-5 font-bold">No. Antrian</th>
                                            <th class="px-6 py-5 font-bold">Waktu</th>
                                            <th class="px-6 py-5 font-bold">Tujuan</th>
                                            <th class="px-6 py-5 font-bold text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="antrian-sebelum-list">
                                        @foreach($antrianSebelum as $index => $as)
                                            <tr class="border-b border-[#1a2d5c] {{ $as->nomor_antrian == $kunjungan->nomor_antrian ? 'bg-purple-900/30' : '' }} hover:bg-white/5 transition duration-200">
                                                <td class="px-6 py-5 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <span class="font-black text-2xl text-white {{ $as->nomor_antrian == $kunjungan->nomor_antrian ? 'text-purple-300' : '' }} tracking-wider">{{ $as->nomor_antrian }}</span>
                                                        @if($as->nomor_antrian == $kunjungan->nomor_antrian)
                                                            <span class="text-[10px] bg-purple-500 text-white px-2 py-1 rounded uppercase font-bold tracking-widest shadow-md border border-purple-400">Nomor Anda</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-sm text-blue-100 font-medium whitespace-nowrap">{{ $as->jam_masuk }}</td>
                                                <td class="px-6 py-5 text-sm text-blue-100 font-medium">{{ $as->subbagian->nama_subbagian ?? '-' }}</td>
                                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                                    @if($index === 0)
                                                        <span class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest animate-pulse shadow-[0_0_15px_rgba(34,197,94,0.5)] border border-green-400">Sedang Dilayani</span>
                                                    @else
                                                        <span class="inline-block bg-[#1a2d5c] text-blue-300 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest border border-[#2a4387]">Menunggu</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="bg-[#1a2d5c] text-blue-200 p-10 text-center font-medium" id="antrian-sebelum-empty">
                                    <i class="bi bi-info-circle text-3xl block mb-3 text-blue-400"></i>
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
        const myNomor = "{{ $kunjungan->nomor_antrian }}";
        const realtimeUrl = "{{ route('tamu.antrian.realtime', $kunjungan->id_kunjungan) }}";

        function checkRealtimeQueue() {
            fetch(realtimeUrl)
                .then(response => response.json())
                .then(data => {
                    const antrianSebelumContainerEl = document.getElementById('antrian-sebelum-container');
                    if (data.antrian_sebelum && antrianSebelumContainerEl) {
                        if (data.antrian_sebelum.length > 0) {
                            let htmlList = `
                                <table class="w-full text-left border-collapse min-w-[600px]">
                                    <thead>
                                        <tr class="bg-[#1a2d5c] text-blue-200 text-xs uppercase tracking-widest border-b-2 border-blue-800">
                                            <th class="px-6 py-5 font-bold">No. Antrian</th>
                                            <th class="px-6 py-5 font-bold">Waktu</th>
                                            <th class="px-6 py-5 font-bold">Tujuan</th>
                                            <th class="px-6 py-5 font-bold text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="antrian-sebelum-list">
                            `;
                            data.antrian_sebelum.forEach((kunjungan, index) => {
                                const isMyNomor = (kunjungan.nomor_antrian === myNomor);
                                const trClass = `border-b border-[#1a2d5c] ${isMyNomor ? 'bg-purple-900/30' : ''} hover:bg-white/5 transition duration-200`;
                                
                                let nomorHtml = `
                                    <div class="flex items-center gap-3">
                                        <span class="font-black text-2xl text-white ${isMyNomor ? 'text-purple-300' : ''} tracking-wider">${kunjungan.nomor_antrian}</span>
                                        ${isMyNomor ? '<span class="text-[10px] bg-purple-500 text-white px-2 py-1 rounded uppercase font-bold tracking-widest shadow-md border border-purple-400">Nomor Anda</span>' : ''}
                                    </div>
                                `;

                                let statusHtml = '';
                                if (index === 0) {
                                    statusHtml = '<span class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest animate-pulse shadow-[0_0_15px_rgba(34,197,94,0.5)] border border-green-400">Sedang Dilayani</span>';
                                } else {
                                    statusHtml = '<span class="inline-block bg-[#1a2d5c] text-blue-300 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest border border-[#2a4387]">Menunggu</span>';
                                }

                                htmlList += `
                                    <tr class="${trClass}">
                                        <td class="px-6 py-5 whitespace-nowrap">${nomorHtml}</td>
                                        <td class="px-6 py-5 text-sm text-blue-100 font-medium whitespace-nowrap">${kunjungan.jam_masuk}</td>
                                        <td class="px-6 py-5 text-sm text-blue-100 font-medium">${kunjungan.tujuan}</td>
                                        <td class="px-6 py-5 text-center whitespace-nowrap">${statusHtml}</td>
                                    </tr>
                                `;
                            });
                            htmlList += '</tbody></table>';
                            antrianSebelumContainerEl.innerHTML = htmlList;
                        } else {
                            antrianSebelumContainerEl.innerHTML = `
                                <div class="bg-[#1a2d5c] text-blue-200 p-10 text-center font-medium" id="antrian-sebelum-empty">
                                    <i class="bi bi-info-circle text-3xl block mb-3 text-blue-400"></i>
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
