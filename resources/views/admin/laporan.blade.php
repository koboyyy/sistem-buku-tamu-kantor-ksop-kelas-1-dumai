@extends ('admin.layouts.app')

@section ('title', 'Laporan Kunjungan')
@section('page-title', 'Laporan Kunjungan')

@section ('content')
    <style>

.kop-laporan {
    position:relative;
    border-bottom:3px solid #003b73;
    padding-bottom:20px;
    margin-bottom:25px;
    text-align:center;
}


.kop-logo {
    position:absolute;
    left:0;
    top:-5px;
}


.kop-logo img {
    width: 60px;
}


.kop-text {
    text-align:center;
}

.kop-text h3 {
    margin:0 0 8px 0;
    color:#003b73;
    font-weight:bold;
}

.kop-text h4 {
    margin:3px;
    color:#003b73;
    font-weight:bold;
}

.kop-text p {
    margin:5px;
    font-size:14px;
}


.stat-box {
    display:flex;
    gap:15px;
    width:100%;
    margin-bottom:20px;
}


.stat-item {
    flex:1;
    height:95px;
    color:white;
    text-align:center;
    padding:10px;
    border-radius:10px;
}


.stat-icon {
    font-size:22px;
    margin-bottom:3px;
}


.stat-item h4 {
    margin:0;
    font-size:24px;
}


.stat-item small {
    font-size:13px;
}


.stat-total {
    background:#00509d;
}


.stat-diterima {
    background:#16a34a;
}


.stat-proses {
    background:#eab308;
}


.stat-ditolak {
    background:#dc2626;
}


.info-cetak{

    font-size:16px;
    font-weight:600;
    line-height:2;
    margin-top:15px;
    margin-bottom:20px;

}
        @media print {
            /* 1. Atur halaman landscape & margin kertas lebih kecil */
            @page {
                size: A4 landscape;
                margin: 1cm;
            }

            /* 2. Sembunyikan elemen yang tidak perlu */
            .no-print,
            aside,
            .sidebar,
            .navbar,
            header {
                display: none !important;
            }

            /* 3. RESET MARGIN TEMPLATE ADMIN (SANGAT PENTING) */
            /* Memaksa area konten memenuhi 100% kertas tanpa jarak dari bekas sidebar */
            body,
            .main-content,
            .content-wrapper,
            .app-content,
            .container,
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                position: static !important;
            }

            /* 4. Matikan efek scroll pada table-responsive agar tidak memotong tabel */
            .table-responsive {
                overflow: visible !important;
            }

            /* 5. Perkecil ukuran huruf dan jarak (padding) dalam tabel */
            table.table {
                width: 100% !important;
                font-size: 8pt !important; /* Diperkecil agar 10 kolom muat */
            }

            table.table th,
            table.table td {
                padding: 4px 6px !important; /* Jarak dalam sel dipersempit */
                white-space: normal !important; /* Izinkan teks panjang turun ke bawah */
                word-wrap: break-word !important;
            }

            /* 6. Atur batas kolom agar lebih rapi (Opsional, menyesuaikan isi) */
            table.table th:nth-child(7), /* Kolom Bidang */
        table.table td:nth-child(7),
        table.table th:nth-child(8), /* Kolom Sub Bagian */
        table.table td:nth-child(8) {
                max-width: 120px !important;
            }

            /* 7. Hilangkan styling box dari card */
            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
            }
            .card-body {
                padding: 0 !important;
            }

            /* 8. Paksa warna background (Kop surat & Badge) tetap tercetak */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* 9. Hindari baris terpotong di tengah halaman */
            table tbody tr {
                page-break-inside: avoid !important;
                page-break-after: auto !important;
            }

            /* Memastikan blok tanda tangan tidak terbelah ke halaman berikutnya */
            .signature-block {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
    <div class="card shadow-sm mb-4 no-print">
        <div class="card-body py-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label
                        class="form-label small fw-semibold mb-1"
                        style="color: var(--navy-primary)"
                        >Dari Tanggal</label
                    >
                    <input
                        type="date"
                        name="dari"
                        class="form-control"
                        value="{{ request('dari') }}"
                    />
                </div>
                <div class="col-md-3">
                    <label
                        class="form-label small fw-semibold mb-1"
                        style="color: var(--navy-primary)"
                        >Sampai Tanggal</label
                    >
                    <input
                        type="date"
                        name="sampai"
                        class="form-control"
                        value="{{ request('sampai') }}"
                    />
                </div>
                <div class="col-md-3">
                    <button class="btn btn-navy w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan Data
                    </button>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <a
                            href="{{ route('admin.laporan') }}"
                            class="btn btn-light border flex-grow-1"
                            >Reset</a
                        >
                        <button
                            type="button"
                            onclick="window.print()"
                            class="btn btn-navy-outline flex-grow-1"
                        >
                            <i class="bi bi-printer me-1"></i> Cetak
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-5">
            <div class="kop-laporan">

    <div class="kop-logo">

        <img src="{{ asset('logo-ksop-kelas-1-dumai.png') }}">

    </div>


    <div class="kop-text">


        <h3>
            LAPORAN KUNJUNGAN TAMU
        </h3>


        <h4>
            KANTOR KESYAHBANDARAN DAN OTORITAS PELABUHAN
        </h4>


        <h4>
            KELAS I DUMAI
        </h4>


        <p>
            Jl. Yos Sudarso No. 1, Kel. Buluh Kasap, Kec. Dumai Timur
        </p>


        <p>
            Kota Dumai, Provinsi Riau - 28826
        </p>


    </div>
</div>
                
                @if (request('dari') && request('sampai'))
    <p class="text-muted mb-0" style="font-size: 0.85rem">
        Periode: {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }} 
        s/d 
        {{ \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') }}
    </p>
@endif


<!-- Statistik Kunjungan -->
<!-- STATISTIK -->
<div class="stat-box">

    <div class="stat-item stat-total">
        <div class="stat-icon">👥</div>
        <h4>{{ $kunjungans->count() }}</h4>
        <small>Total Kunjungan</small>
    </div>


    <div class="stat-item stat-diterima">
        <div class="stat-icon">✔</div>
        <h4>
            {{ $kunjungans->filter(function($item){
                return trim(strtolower($item->status_kunjungan)) == 'diterima';
            })->count() }}
        </h4>
        <small>Diterima</small>
    </div>


    <div class="stat-item stat-proses">
        <div class="stat-icon">⏳</div>
        <h4>
            {{ $kunjungans->filter(function($item){
                return trim(strtolower($item->status_kunjungan)) == 'proses';
            })->count() }}
        </h4>
        <small>Proses</small>
    </div>


    <div class="stat-item stat-ditolak">
        <div class="stat-icon">✖</div>
        <h4>
            {{ $kunjungans->filter(function($item){
                return trim(strtolower($item->status_kunjungan)) == 'ditolak';
            })->count() }}
        </h4>
        <small>Ditolak</small>
    </div>

</div>


<!-- INFO CETAK DI BAWAH -->
<div class="info-cetak">

    <div>
        📅 Tanggal Cetak :
        {{ now()->translatedFormat('d F Y') }}
    </div>

    <div>
        🕒 Jam Cetak :
        {{ now()->format('H:i') }} WIB
    </div>

    <div>
        👤 Dicetak Oleh :
        Administrator
    </div>

</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr class="text-center text-nowrap">
                            <th style="width: 40px">No</th>
                            <th>Antrian</th>
                            <th>Nama Tamu</th>
                            <th>Instansi</th>
                            <th>Tanggal</th>
                            <th>Jam Kedatangan</th>
                            <th>Bidang</th>
                            <th>Sub Bagian</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kunjungans as $i => $k)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center fw-bold">
                                    <span class="badge badge-navy"
                                        >#{{ $k->nomor_antrian }}</span
                                    >
                                </td>
                                <td>{{ $k->tamu->nama ?? '-' }}</td>
                                <td>{{ $k->tamu->instansi ?? '-' }}</td>
                                <td class="text-nowrap text-center">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d/m/Y') }}
                                </td>

                                <td class="text-center text-nowrap">
                                    {{ $k->jam_masuk ? substr($k->jam_masuk, 0, 5) . ' WIB' : '-' }}
                                </td>

                                <td>
                                    <small
                                        >{{ $k->bidang->nama_bidang ?? '-' }}</small
                                    >
                                </td>

                                <td>
                                    <small
                                        >{{ $k->subbagian->nama_subbagian ?? '-' }}</small
                                    >
                                </td>

                                <td>{{ Str::limit($k->keperluan, 30) }}</td>
                                <td class="text-center">
                                    <span
                                        class="text-uppercase small fw-bold"
                                        >{{ $k->status_kunjungan }}</span
                                    >
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="10"
                                    class="text-center py-4 text-muted"
                                >
                                    Data tidak ditemukan untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr style="background: var(--navy-lighter)">
                            <td
                                colspan="9"
                                class="text-end fw-bold py-3"
                                style="color: var(--navy-primary)"
                            >
                                TOTAL KUNJUNGAN:
                            </td>
                            <td
                                class="text-center fw-bold py-3"
                                style="color: var(--navy-primary)"
                            >
                                {{ $kunjungans->count() }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Signature (print only) -->
            <div class="row mt-5 d-none d-print-flex signature-block">
                <div class="col-8"></div>
                <div class="col-4 text-center">
                    <p class="mb-5">Dumai, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="mb-0 fw-bold"><u>Admin KSOP</u></p>
                    <p>NIP. ...........................</p>
                </div>
            </div>
        </div>
    </div>
@endsection
