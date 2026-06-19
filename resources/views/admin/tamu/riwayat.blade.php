@extends ('admin.layouts.app')

@section ('title', 'Riwayat Kunjungan Tamu')
@section ('page-title', 'Riwayat Kunjungan Tamu')

@section ('content')
    <!-- TOMBOL KEMBALI -->
    <div class="mb-4">
        <a
            href="{{ route('admin.tamu.index') }}"
            class="btn btn-light border shadow-sm"
        >
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Tamu
        </a>
    </div>
    <!-- KARTU INFORMASI TAMU -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
                <div
                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-center me-3"
                    style="width: 50px; height: 50px"
                >
                    <i class="bi bi-person-fill fs-4 m-auto"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Informasi Profil Tamu</h5>
                    <p
                        class="text-muted mb-0"
                        style="font-size: 0.9rem"
                    >Detail informasi tamu yang terdaftar di sistem</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <p
                        class="text-muted mb-1"
                        style="font-size: 0.85rem"
                    >Nama Lengkap</p>
                    <p class="fw-semibold mb-0">{{ $tamu->nama }}</p>
                </div>
                <div class="col-md-3">
                    <p
                        class="text-muted mb-1"
                        style="font-size: 0.85rem"
                    >Instansi/Perusahaan</p>
                    <p class="fw-semibold mb-0">{{ $tamu->instansi ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <p
                        class="text-muted mb-1"
                        style="font-size: 0.85rem"
                    >No. Handphone</p>
                    <p class="fw-semibold mb-0">{{ $tamu->no_hp }}</p>
                </div>
                <div class="col-md-3">
                    <p
                        class="text-muted mb-1"
                        style="font-size: 0.85rem"
                    >Alamat Email</p>
                    <p class="fw-semibold mb-0">{{ $tamu->email }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- KARTU TABEL RIWAYAT KUNJUNGAN -->
    <div class="card border-0 shadow-sm">
        <div
            class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center"
        >
            <div>
                <h5 class="fw-bold mb-1">Riwayat Kunjungan</h5>
                <p
                    class="text-muted mb-0"
                    style="font-size: 0.9rem"
                >Daftar seluruh agenda kunjungan yang pernah diajukan oleh tamu ini.</p>
            </div>
            <div>
                <span class="badge bg-light text-secondary border px-3 py-2">
                    Total: {{ $riwayatKunjungan->count() }} Kunjungan
                </span>
            </div>
        </div>

        <div class="card-body p-0 mt-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>No. Antrian</th>
                            <th>Tanggal & Waktu</th>
                            <th>Tujuan Bidang</th>
                            <th>Keperluan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center px-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($riwayatKunjungan as $i => $k)
                            <tr>
                                <td class="px-4 text-muted">{{ $i + 1 }}</td>

                                <td>
                                    <span
                                        class="badge bg-light text-primary border px-2 py-1"
                                    >
                                        {{ $k->nomor_antrian }}
                                    </span>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ substr($k->jam_masuk, 0, 5) }} WIB
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $k->bidang->nama_bidang ?? '-' }}
                                    </div>
                                    <small
                                        class="text-muted"
                                        >{{ $k->subbagian->nama_subbagian ?? '-' }}</small
                                    >
                                </td>

                                <td>
                                    <span
                                        class="text-truncate d-inline-block"
                                        style="max-width: 200px"
                                        title="{{ $k->keperluan }}"
                                    >
                                        {{ $k->keperluan }}
                                    </span>
                                </td>

                                 <td class="text-center">
                                     @if ($k->status_kunjungan === 'diterima')
                                         @if ($k->is_served)
                                             <span
                                                 class="badge bg-success text-white border border-success px-3 py-2 rounded-pill"
                                             >
                                                 <i
                                                     class="bi bi-check-circle-fill me-1"
                                                 ></i>
                                                 Selesai Dilayani
                                             </span>
                                         @else
                                             <span
                                                 class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill"
                                             >
                                                 <i
                                                     class="bi bi-check-circle-fill me-1"
                                                 ></i>
                                                 Diterima
                                             </span>
                                         @endif
                                     @elseif ($k->status_kunjungan === 'ditolak')
                                         <span
                                             class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill"
                                         >
                                             <i
                                                 class="bi bi-x-circle-fill me-1"
                                             ></i>
                                             Ditolak
                                         </span>
                                     @else
                                         <span
                                             class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill"
                                         >
                                             <i
                                                 class="bi bi-hourglass-split me-1"
                                             ></i>
                                             Pending
                                         </span>
                                     @endif
                                 </td>

                                 <td class="text-center px-4">
                                     <div class="d-flex gap-2 justify-content-center align-items-center">
                                         @if ($k->status_kunjungan === 'diterima' && !$k->is_served)
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
                                         <a
                                             href="{{ route('admin.kunjungan.detail', $k->id_kunjungan) }}"
                                             class="btn btn-sm btn-outline-primary"
                                         >
                                             <i class="bi bi-eye me-1"></i> Detail
                                         </a>
                                     </div>
                                 </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div
                                        class="d-flex flex-column align-items-center"
                                    >
                                        <i
                                            class="bi bi-calendar-x fs-1 text-secondary mb-3"
                                        ></i>
                                        <h5 class="fw-bold text-secondary">
                                            Belum Ada Riwayat
                                        </h5>
                                        <p class="text-muted mb-0">Tamu ini belum pernah melakukan pendaftaran kunjungan.</p>
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
