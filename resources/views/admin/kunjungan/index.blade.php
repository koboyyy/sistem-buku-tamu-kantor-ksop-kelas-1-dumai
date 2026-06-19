@extends ('admin.layouts.app')

@section ('title', 'Data Kunjungan')
@section ('page-title', 'Data Kunjungan')

@section ('content')
    <!-- =========================
    FILTER & SEARCH
========================= -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body py-3">
            <form
                method="GET"
                action="{{ route('admin.kunjungan.index') }}"
                class="row g-3 align-items-end"
            >
                <!-- SEARCH -->
                <div class="col-md-4">
                    <label
                        class="form-label small fw-semibold mb-1"
                        style="color: var(--navy-primary)"
                    >
                        Cari Data
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control border-start-0"
                            placeholder="Nama, instansi, bidang, atau no. antrian..."
                            value="{{ request('search') }}"
                        />
                    </div>
                </div>

                <!-- STATUS -->
                <div class="col-md-3">
                    <label
                        class="form-label small fw-semibold mb-1"
                        style="color: var(--navy-primary)"
                    >
                        Filter Status
                    </label>

                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>

                        <option
                            value="pending"
                            {{ request('status') === 'pending' ? 'selected' : '' }}
                        >
                            🕒 Pending
                        </option>

                        <option
                            value="diterima"
                            {{ request('status') === 'diterima' ? 'selected' : '' }}
                        >
                            ✅ Diterima
                        </option>

                        <option
                            value="ditolak"
                            {{ request('status') === 'ditolak' ? 'selected' : '' }}
                        >
                            ❌ Ditolak
                        </option>
                    </select>
                </div>

                <!-- FILTER BIDANG -->
                <div class="col-md-3">
                    <label
                        class="form-label small fw-semibold mb-1"
                        style="color: var(--navy-primary)"
                    >
                        Filter Bidang
                    </label>

                    <select name="bidang" class="form-select">
                        <option value="">Semua Bidang</option>

                        @foreach ($bidangs as $b)
                            <option
                                value="{{ $b->id_bidang }}"
                                {{ request('bidang') == $b->id_bidang ? 'selected' : '' }}
                            >
                                {{ $b->nama_bidang }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-auto">
                    <button type="submit" class="btn btn-navy px-4">
                        <i class="bi bi-filter me-1"></i>
                        Terapkan
                    </button>
                </div>

                <div class="col-auto">
                    <a
                        href="{{ route('admin.kunjungan.index') }}"
                        class="btn btn-light border text-secondary"
                    >
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- =========================
    TABLE
========================= -->
    <div class="card shadow-sm border-0">
        <!-- HEADER -->
        <div
            class="card-header bg-white py-3 d-flex justify-content-between align-items-center"
        >
            <h5
                class="card-title mb-0 fw-bold"
                style="color: var(--navy-primary)"
            >
                Daftar Kunjungan
            </h5>

            <span class="badge badge-navy px-3 py-2">
                {{ $kunjungans->count() }}

                Data Ditemukan
            </span>
        </div>

        <!-- BODY -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-3">No. Antrian</th>

                            <th class="py-3">Tamu & Instansi</th>

                            <th class="py-3">Waktu Kunjungan</th>

                            <th class="py-3">Bidang / Subbagian</th>

                            <th class="py-3">Status</th>

                            <th class="text-center px-4 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kunjungans as $k)
                            @php
                            $s = $k->status_kunjungan;
                        @endphp
                            <tr>
                                <!-- NOMOR ANTRIAN -->
                                <td class="px-4">
                                    <span
                                        class="badge badge-navy px-3 py-2 fw-bold"
                                        style="letter-spacing: 1px"
                                    >
                                        {{ $k->nomor_antrian }}
                                    </span>
                                </td>

                                <!-- TAMU -->
                                <td>
                                    <div class="fw-bold mb-0 text-dark">
                                        {{ $k->tamu->nama ?? 'Tamu Umum' }}
                                    </div>

                                    <div class="text-muted small">
                                        <i class="bi bi-building me-1"></i>

                                        {{ $k->tamu->instansi ?? '-' }}
                                    </div>
                                </td>

                                <!-- WAKTU -->
                                <td>
                                    <div class="small fw-medium">
                                        {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}
                                    </div>

                                    <div class="text-muted extra-small">
                                        <i class="bi bi-clock me-1"></i>

                                        {{ $k->jam_masuk }} WIB
                                    </div>
                                </td>

                                <!-- BIDANG -->
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <span
                                            class="badge rounded-pill px-3 py-2"
                                            style="
                                                background: rgba(
                                                    37,
                                                    99,
                                                    235,
                                                    0.1
                                                );
                                                color: #2563eb;
                                                width: fit-content;
                                            "
                                        >
                                            {{ $k->bidang->nama_bidang ?? '-' }}
                                        </span>

                                        @if ($k->subbagian)
                                            <small class="text-muted">
                                                {{ $k->subbagian->nama_subbagian }}
                                            </small>

                                        @endif
                                    </div>
                                </td>

                                 <!-- STATUS -->
                                 <td>
                                     @if ($s === 'diterima')
                                         @if ($k->is_served)
                                             <span
                                                 class="badge rounded-pill bg-success text-white border border-success px-3"
                                             >
                                                 ✅ Selesai Dilayani
                                             </span>
                                         @else
                                             <span
                                                 class="badge rounded-pill bg-success-subtle text-success border border-success px-3"
                                             >
                                                 ✅ Diterima
                                             </span>
                                         @endif

                                     @elseif ($s === 'ditolak')
                                         <span
                                             class="badge rounded-pill bg-danger-subtle text-danger border border-danger px-3"
                                         >
                                             ❌ Ditolak
                                         </span>

                                     @else
                                         <span
                                             class="badge rounded-pill bg-warning-subtle text-warning border border-warning px-3"
                                         >
                                             🕒 Pending
                                         </span>

                                     @endif
                                 </td>

                                 <!-- AKSI -->
                                 <td class="text-center px-4">
                                     <div
                                         class="d-flex gap-2 justify-content-center align-items-center"
                                     >
                                         <!-- SELESAI -->
                                         @if ($s === 'diterima' && !$k->is_served)
                                             <form
                                                 action="{{ route('admin.kunjungan.selesai', $k->id_kunjungan) }}"
                                                 method="POST"
                                                 onsubmit="
                                                     return confirm(
                                                         'Apakah Anda yakin ingin menyelesaikan kunjungan ini?',
                                                     );
                                                 "
                                                 class="m-0"
                                             >
                                                 @csrf
                                                 <button
                                                     class="btn btn-sm btn-success"
                                                     title="Selesai Dilayani"
                                                 >
                                                     <i class="bi bi-check-lg"></i> Selesai
                                                 </button>
                                             </form>
                                         @endif

                                         <!-- DETAIL -->
                                         <a
                                             href="{{ route('admin.kunjungan.detail', $k->id_kunjungan) }}"
                                             class="btn btn-sm btn-outline-primary"
                                             title="Detail"
                                         >
                                             <i class="bi bi-eye-fill"></i>
                                         </a>

                                         <!-- HAPUS -->
                                         <form
                                             action="{{ route('admin.kunjungan.hapus', $k->id_kunjungan) }}"
                                             method="POST"
                                             onsubmit="
                                                 return confirm(
                                                     'Apakah Anda yakin ingin menghapus data ini?',
                                                 );
                                             "
                                             class="m-0"
                                         >
                                             @csrf
                                             @method ('DELETE')

                                             <button
                                                 class="btn btn-sm btn-outline-danger"
                                                 title="Hapus"
                                             >
                                                 <i class="bi bi-trash-fill"></i>
                                             </button>
                                         </form>
                                     </div>
                                 </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i
                                            class="bi bi-search fs-1 d-block mb-3 opacity-25"
                                        ></i>

                                        <p class="mb-0">Tidak ada data kunjungan yang sesuai dengan kriteria.</p>

                                        <a
                                            href="{{ route('admin.kunjungan.index') }}"
                                            class="btn btn-sm btn-link text-decoration-none"
                                        >
                                            Lihat Semua Data
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
