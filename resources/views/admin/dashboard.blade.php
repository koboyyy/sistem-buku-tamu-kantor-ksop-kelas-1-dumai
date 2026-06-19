@extends ('admin.layouts.app')

@section ('title', 'Dashboard')

@section ('content')
    <div class="container-fluid">
        <!-- HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold">Dashboard Admin</h3>

            <p class="text-muted">Statistik Buku Tamu</p>
        </div>

        <!-- CARD -->
        <div class="row g-4 mb-4">
            <!-- TOTAL TAMU -->
            <div class="col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6>Total Tamu</h6>

                        <h2 class="fw-bold text-primary">{{ $totalTamu }}</h2>
                    </div>
                </div>
            </div>

            <!-- TOTAL KUNJUNGAN -->
            <div class="col-md-3">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6>Total Kunjungan</h6>

                        <h2 class="fw-bold text-success">
                            {{ $totalKunjungan }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- PENDING -->
            <div class="col-md-2">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6>Pending</h6>

                        <h2 class="fw-bold text-warning">{{ $pending }}</h2>
                    </div>
                </div>
            </div>

            <!-- DITERIMA -->
            <div class="col-md-2">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6>Diterima</h6>

                        <h2 class="fw-bold text-info">{{ $diterima }}</h2>
                    </div>
                </div>
            </div>

            <!-- DITOLAK -->
            <div class="col-md-2">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6>Ditolak</h6>

                        <h2 class="fw-bold text-danger">{{ $ditolak }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART -->
        <div class="card shadow border-0">
            <div class="card-body">
                <!-- FILTER -->
                <div
                    class="d-flex justify-content-between align-items-center mb-4"
                >
                    <h5 class="fw-bold mb-0">Grafik Status Kunjungan</h5>

                    <form
                        method="GET"
                        action="{{ route('admin.dashboard') }}"
                        class="d-flex gap-2 align-items-center"
                        id="filterForm"
                    >
                        <!-- TAHUN -->
                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                            @foreach ($daftarTahun as $thn)
                                <option
                                    value="{{ $thn }}"
                                    {{ $tahun == $thn ? 'selected' : '' }}
                                >
                                    {{ $thn }}
                                </option>

                            @endforeach
                        </select>

                        <!-- BULAN -->
                        <select name="bulan" class="form-select" onchange="resetWeekAndSubmit(this)">
                            <option value="">Semua Bulan</option>

                            @for ($i = 1; $i <= 12; $i++)
                                <option
                                    value="{{ $i }}"
                                    {{ $bulan == $i ? 'selected' : '' }}
                                >
                                    {{ date('F', mktime(0,0,0,$i,1)) }}
                                </option>

                            @endfor
                        </select>

                        <!-- MINGGU (Hanya muncul jika bulan terpilih) -->
                        @if ($bulan)
                            <select name="minggu" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Minggu</option>
                                @foreach ($weeks as $idx => $wInfo)
                                    <option
                                        value="{{ $idx }}"
                                        {{ $minggu == $idx ? 'selected' : '' }}
                                    >
                                        {{ $wInfo['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            Filter
                        </button>
                    </form>

                    <script>
                        function resetWeekAndSubmit(select) {
                            const mingguSelect = document.querySelector('select[name="minggu"]');
                            if (mingguSelect) {
                                mingguSelect.value = "";
                            }
                            select.form.submit();
                        }
                    </script>
                </div>

                <!-- CANVAS -->
                <div style="height: 400px">
                    @if (
                    count($labels) > 0
                )
                        <canvas id="chartKunjungan"></canvas>

                    @else
                        <div
                            class="d-flex flex-column justify-content-center align-items-center h-100 text-center"
                        >
                            <i
                                class="bi bi-bar-chart-line fs-1 text-secondary mb-3"
                            ></i>

                            <h5 class="fw-bold text-secondary">
                                Tidak Ada Data
                            </h5>

                            <p
                                class="text-muted mb-0"
                            >Tidak terdapat data kunjungan pada periode yang dipilih.</p>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        /**
         * LABEL
         */
        const labels = @json ($labels ?? []);

        /**
         * DATA
         */
        const dataPending = @json ($dataPending ?? []);

        const dataDiterima = @json ($dataDiterima ?? []);

        const dataDitolak = @json ($dataDitolak ?? []);

        /**
         * DEBUG
         */
        console.log({
            labels,

            dataPending,

            dataDiterima,

            dataDitolak,
        });

        /**
         * CHART
         */
        const ctx = document.getElementById('chartKunjungan');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: labels,

                    datasets: [
                        /**
                         * PENDING
                         */
                        {
                            label: 'Pending',

                            data: dataPending,

                            backgroundColor: 'rgba(37, 99, 235)',
                        },

                        /**
                         * DITERIMA
                         */
                        {
                            label: 'Diterima',

                            data: dataDiterima,

                            backgroundColor: 'rgba(20, 184, 166)',
                        },

                        /**
                         * DITOLAK
                         */
                        {
                            label: 'Ditolak',

                            data: dataDitolak,

                            backgroundColor: 'rgba(249, 115, 22)',
                        },
                    ],
                },

                options: {
                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {
                        mode: 'index',

                        intersect: false,
                    },

                    plugins: {
                        legend: {
                            position: 'bottom',

                            labels: {
                                color: '#64748b',

                                font: {
                                    weight: 'bold',
                                },
                            },
                        },
                    },

                    scales: {
                        y: {
                            beginAtZero: true,

                            ticks: {
                                precision: 0,

                                color: '#64748b',
                            },

                            grid: {
                                color: 'rgba(0,0,0,0.05)',
                            },
                        },

                        x: {
                            ticks: {
                                color: '#64748b',
                            },

                            grid: {
                                display: false,
                            },
                        },
                    },
                },
            });
        }
    </script>

@endsection
