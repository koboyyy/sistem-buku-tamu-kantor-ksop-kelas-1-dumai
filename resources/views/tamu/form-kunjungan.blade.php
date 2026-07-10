<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Form Kunjungan - KSOP Dumai</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
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

        .delay-300 {
            animation-delay: 0.3s;
        }

        /* Memperbaiki posisi panah dropdown (chevron) agar tidak mepet kanan */
        select {
            background-position: right 1.25rem center !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <nav
        class="bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-200 sticky top-0 z-50"
    >
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between py-4">
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
                            Pendaftaran Kunjungan
                        </h1>

                        <p class="text-sm text-slate-500">KSOP Kelas I Dumai</p>
                    </div>
                </a>

                <img
                    src="{{ asset('logo-ksop-kelas-1-dumai.png') }}"
                    alt="Logo KSOP"
                    class="w-14"
                />
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 py-8">
        <div class="mb-8 animate-fade-up">
            <p class="text-secondary font-semibold mb-2">Formulir Digital</p>

            <h2 class="text-4xl font-extrabold text-primary mb-3">
                Pendaftaran Kunjungan
            </h2>

            <p class="text-slate-500 leading-7 max-w-2xl">Silakan lengkapi data kunjungan dengan benar untuk mendapatkan nomor antrian digital.</p>
        </div>

        @if ($errors->any())
            <div
                class="mb-6 bg-red-100 border border-red-200 text-red-700 px-5 py-4 rounded-2xl animate-fade-up"
            >
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-circle-fill text-lg"></i>

                    <div>
                        <h3 class="font-bold mb-1">Terjadi Kesalahan</h3>

                        <ul class="list-disc ml-5 text-sm space-y-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        @endif

        <div
            class="bg-white rounded-[32px] shadow-xl border border-slate-100 overflow-hidden animate-fade-up delay-100"
        >
            <div
                class="bg-gradient-to-r from-primary to-softnavy px-8 py-6 text-white"
            >
                <h3 class="text-2xl font-extrabold flex items-center gap-3">
                    <i class="bi bi-person-lines-fill"></i>

                    Form Data Kunjungan
                </h3>
            </div>

            <div class="p-8 lg:p-10">
                <form
                    action="{{ route('tamu.kunjungan.simpan') }}"
                    method="POST"
                    class="space-y-10"
                >
                    @csrf

                    <div class="animate-fade-up delay-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-xl"
                            >
                                <i class="bi bi-building"></i>
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-primary">
                                    Destinasi Kunjungan
                                </h3>

                                <p class="text-sm text-slate-500">Tentukan tujuan bidang dan subbagian</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Bidang yang Dituju
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-diagram-3 absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <select
                                        name="id_bidang"
                                        id="id_bidang"
                                        class="w-full appearance-none border border-slate-300 rounded-2xl pl-14 pr-12 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition cursor-pointer"
                                        required
                                    >
                                        <option value="">
                                            -- Pilih Bidang --
                                        </option>

                                        @foreach ($bidangs as $b)
                                            <option
                                                value="{{ $b->id_bidang }}"
                                                {{ old('id_bidang') == $b->id_bidang ? 'selected' : '' }}
                                            >
                                                {{ $b->nama_bidang }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Subbagian
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-grid absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <select
                                        name="id_subbagian"
                                        id="id_subbagian"
                                        class="w-full appearance-none border border-slate-300 rounded-2xl pl-14 pr-12 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition cursor-pointer"
                                        required
                                    >
                                        <option value="">
                                            -- Pilih Subbagian --
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="animate-fade-up delay-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 rounded-2xl bg-secondary/20 text-secondary flex items-center justify-center text-xl"
                            >
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-primary">
                                    Waktu Kedatangan
                                </h3>

                                <p class="text-sm text-slate-500">Pilih tanggal dan estimasi jam kunjungan</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            @php
                                $validDates = [];
                                $date = \Carbon\Carbon::now('Asia/Jakarta');
                                
                                while(count($validDates) < 2) {
                                    // isWeekday() otomatis memfilter Sabtu dan Minggu
                                    if ($date->isWeekday()) {
                                        $validDates[] = [
                                            'value' => $date->format('Y-m-d'),
                                            'label' => $date->translatedFormat('l, d F Y'),
                                            'dayOfWeek' => $date->dayOfWeekIso // 1 untuk Senin s/d 5 untuk Jumat
                                        ];
                                    }
                                    $date->addDay();
                                }
                            @endphp

                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Tanggal Kunjungan
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-calendar-event absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <select
                                        name="tanggal_kunjungan"
                                        id="tanggal_kunjungan"
                                        class="w-full appearance-none border border-slate-300 rounded-2xl pl-14 pr-12 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition cursor-pointer"
                                        required
                                    >
                                        <option value="">
                                            -- Pilih Tanggal --
                                        </option>

                                        @foreach ($validDates as $vd)
                                            <option
                                                value="{{ $vd['value'] }}"
                                                data-day="{{ $vd['dayOfWeek'] }}"
                                                {{ old('tanggal_kunjungan') == $vd['value'] ? 'selected' : '' }}
                                            >
                                                {{ $vd['label'] }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block mb-2 font-bold text-slate-700"
                                >
                                    Jam Masuk
                                </label>

                                <div class="relative">
                                    <i
                                        class="bi bi-alarm absolute left-5 top-1/2 -translate-y-1/2 text-primary"
                                    ></i>

                                    <input
                                        type="text"
                                        name="jam_masuk"
                                        id="jam_masuk"
                                        value="{{ old('jam_masuk') }}"
                                        placeholder="--:--"
                                        class="w-full border border-slate-300 rounded-2xl pl-14 pr-4 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed bg-white"
                                        disabled
                                        required
                                    />
                                </div>
                                <p id="info_jam" class="text-xs text-slate-500 mt-2 hidden">
                                    Jam Operasional:
                                    <span
                                        id="text_jam_operasional"
                                        class="font-bold text-primary"
                                    ></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="animate-fade-up delay-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-xl"
                            >
                                <i class="bi bi-chat-left-dots"></i>
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-primary">
                                    Detail Keperluan
                                </h3>

                                <p class="text-sm text-slate-500">Jelaskan tujuan utama kunjungan Anda</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 font-bold text-slate-700">
                                Keperluan Utama
                            </label>

                            <textarea
                                name="keperluan"
                                rows="4"
                                placeholder="Contoh: Koordinasi terkait izin pelabuhan..."
                                class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition"
                                required
                                >{{ old('keperluan') }}</textarea
                            >
                        </div>

                        <div>
                            <label class="block mb-2 font-bold text-slate-700">
                                Keterangan Tambahan
                            </label>

                            <textarea
                                name="keterangan"
                                rows="3"
                                placeholder="Informasi tambahan lainnya..."
                                class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition"
                                >{{ old('keterangan') }}</textarea
                            >
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row gap-4 justify-end pt-6"
                    >
                        <a
                            href="{{ route('tamu.dashboard') }}"
                            class="px-8 py-4 rounded-2xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-100 transition duration-300 text-center"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-10 py-4 rounded-2xl bg-gradient-to-r from-primary to-softnavy text-white font-bold shadow-lg hover:shadow-[0_0_25px_rgba(11,31,58,0.35)] hover:-translate-y-1 transition duration-300"
                        >
                            <i class="bi bi-send mr-2"></i>

                            Daftar Kunjungan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Tidak Diizinkan',
                text: '{{ session("error") }}',
                confirmButtonColor: '#0f172a',
            });
        </script>
    @endif

    <script>
        // 1. Logic Subbagian
        const subbagianData = @json (
                                                                                                            $bidangs->mapWithKeys(fn($b) => [
                                                                                                                $b->id_bidang => $b->subbagians->map(fn($s) => [
                                                                                                                    'id' => $s->id_subbagian,
                                                                                                                    'nama' => $s->nama_subbagian
                                                                                                                ])
                                                                                                            ])
                                                                                                        );

        document.getElementById('id_bidang').addEventListener('change', function () {
            const bidangId = this.value;
            const subSelect = document.getElementById('id_subbagian');

            subSelect.innerHTML = '<option value="">-- Pilih Subbagian --</option>';

            if (bidangId && subbagianData[bidangId]) {
                subbagianData[bidangId].forEach((s) => {
                    subSelect.innerHTML += `<option value="${s.id}">${s.nama}</option>`;
                });
            }
        });

        // 2. Logic Jam Operasional & Flatpickr
        document.addEventListener('DOMContentLoaded', function () {
            const selectTanggal = document.getElementById('tanggal_kunjungan');
            const inputJam = document.getElementById('jam_masuk');
            const infoJam = document.getElementById('info_jam');
            const textJamOperasional = document.getElementById('text_jam_operasional');

            // Inisialisasi Flatpickr dengan format 24 Jam
            let timePicker = flatpickr('#jam_masuk', {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'H:i',
                time_24hr: true,
                minuteIncrement: 5, // Lompatan menit (opsional, misal per 5 menit)
                clickOpens: false, // Kunci sementara sampai tanggal dipilih
            });

            function updateJamOperasional() {
                const selectedOption =
                    selectTanggal.options[selectTanggal.selectedIndex];

                if (!selectedOption.value) {
                    inputJam.disabled = true;
                    inputJam.value = '';
                    inputJam.placeholder = '--:--';
                    infoJam.classList.add('hidden');
                    timePicker.set('clickOpens', false);
                    return;
                }

                inputJam.disabled = false;
                inputJam.placeholder = 'Pilih Jam';
                infoJam.classList.remove('hidden');
                timePicker.set('clickOpens', true);

                // Dapatkan index hari (1 = Senin, 5 = Jumat)
                const day = parseInt(selectedOption.getAttribute('data-day'));
                const minTime = '08:00';

                // Jika Jumat, tutup jam 17:00, selain itu 16:30
                let maxTime = day === 5 ? '17:00' : '16:30';

                textJamOperasional.innerText = `${minTime} - ${maxTime} WIB`;

                // Set batas minimal dan maksimal di Flatpickr
                timePicker.set('minTime', minTime);
                timePicker.set('maxTime', maxTime);

                // Validasi ulang nilai jam jika tamu mengganti tanggal setelah mengisi jam
                if (inputJam.value) {
                    if (inputJam.value < minTime || inputJam.value > maxTime) {
                        timePicker.clear();
                        alert(
                            `Jam operasional untuk hari yang dipilih adalah ${minTime} - ${maxTime} WIB.`,
                        );
                    }
                }
            }

            selectTanggal.addEventListener('change', updateJamOperasional);

            // Jalankan saat halaman dimuat (untuk old value / error feedback)
            if (selectTanggal.value) {
                updateJamOperasional();
            }
        });
    </script>
</body>
</html>
