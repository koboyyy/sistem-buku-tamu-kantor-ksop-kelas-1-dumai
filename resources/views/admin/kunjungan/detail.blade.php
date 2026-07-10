@extends ('admin.layouts.app')

@section ('title', 'Detail Kunjungan')
@section ('page-title', 'Detail Kunjungan')

@section ('content')
    <div class="row g-4">
        <!-- =========================
         DETAIL KUNJUNGAN
        ========================= -->

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <!-- HEADER -->
                <div
                    class="card-header border-0 bg-gradient-primary text-white p-4"
                    style="
                        background: linear-gradient(135deg, #0f172a, #1e3a8a);
                    "
                >
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <h4 class="fw-bold mb-1">Detail Kunjungan</h4>

                            <p class="mb-0 text-white-50">Informasi lengkap tamu dan status kunjungan</p>
                        </div>

                        <div
                            class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 70px; height: 70px; font-size: 1.8rem"
                        >
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body p-4">
                    <!-- NOMOR ANTRIAN -->
                    <div
                        class="bg-primary bg-opacity-10 rounded-4 p-4 mb-4 border border-primary border-opacity-10"
                    >
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <div>
                                <small class="text-muted">
                                    Nomor Antrian
                                </small>

                                <h1
                                    class="fw-black text-primary mb-0"
                                    style="font-size: 3rem"
                                >
                                    {{ $kunjungan->nomor_antrian }}
                                </h1>
                            </div>

                            <div
                                class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 70px; height: 70px"
                            >
                                <i class="bi bi-ticket-perforated fs-2"></i>
                            </div>
                        </div>
                    </div>

                    <!-- DATA TAMU -->
                    <div class="mb-5">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="bi bi-person me-2"></i>

                            Informasi Tamu
                        </h5>

                        <div class="row g-4">
                            <!-- KEPERLUAN UTAMA -->
                            <div class="col-md-12">
                                <label class="form-label text-muted small fw-semibold">
                                    Keperluan Utama
                                </label>

                            <div class="bg-light rounded-4 px-4 py-3 fw-semibold">
                                {{ $kunjungan->keperluan ?? '-' }}
                            </div>
                        </div>
                            <!-- NAMA -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Nama Lengkap
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->tamu->nama }}
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Email
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->tamu->email }}
                                </div>
                            </div>

                            <!-- NO HP -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Nomor HP
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->tamu->no_hp }}
                                </div>
                            </div>

                            <!-- INSTANSI -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Instansi
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->tamu->instansi ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DATA KUNJUNGAN -->
                    <div class="mb-5">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="bi bi-building me-2"></i>

                            Informasi Kunjungan
                        </h5>

                        <div class="row g-4">
                            <!-- BIDANG -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Bidang
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->bidang->nama_bidang }}
                                </div>
                            </div>

                            <!-- SUB BAGIAN -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Sub Bagian
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ $kunjungan->subbagian->nama_subbagian ?? '-' }}
                                </div>
                            </div>

                            <!-- TANGGAL -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Tanggal Kunjungan
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <!-- JAM -->
                            <div class="col-md-6">
                                <label
                                    class="form-label text-muted small fw-semibold"
                                >
                                    Jam Kunjungan
                                </label>

                                <div
                                    class="bg-light rounded-4 px-4 py-3 fw-semibold"
                                >
                                    {{ \Carbon\Carbon::parse($kunjungan->jam_masuk)->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DEADLINE -->
                    <div
                        class="alert alert-warning border-0 rounded-4 shadow-sm mb-5"
                    >
                        <div class="d-flex gap-3">
                            <!-- ICON -->
                            <div class="fs-2 text-warning">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <!-- CONTENT -->
                            <div>
                                <h6 class="fw-bold mb-2">
                                    Batas Verifikasi Admin
                                </h6>

                                <p class="mb-2">
                                    Admin harus memverifikasi kunjungan ini
                                    sebelum waktu kedatangan tamu:

                                    <strong>
                                        {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                        jam {{ \Carbon\Carbon::parse($kunjungan->jam_masuk)->format('H:i') }} WIB
                                    </strong>
                                </p>

                                @if (
                                $kunjungan->status_kunjungan === 'pending'
                            )
                                    <div
                                        class="bg-danger-subtle text-danger px-3 py-2 rounded small fw-semibold"
                                    >
                                        <i
                                            class="bi bi-exclamation-circle me-1"
                                        ></i>

                                        Jika melewati tanggal tersebut, sistem
                                        akan otomatis menolak kunjungan ini.
                                    </div>

                                @elseif (
                                $kunjungan->status_kunjungan === 'ditolak'
                                &&
                                str_contains(
                                    strtolower(
                                        $kunjungan->keterangan
                                    ),
                                    'otomatis dibatalkan'
                                )
                            )
                                    <div
                                        class="bg-danger-subtle text-danger px-3 py-2 rounded small fw-semibold"
                                    >
                                        <i class="bi bi-x-circle-fill me-1"></i>

                                        Kunjungan ini otomatis ditolak karena
                                        melewati batas verifikasi admin.
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- KEPERLUAN -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-chat-left-text me-2"></i>

                            Keperluan
                        </h5>

                        <div class="bg-light rounded-4 p-4 lh-lg">
                            {{ $kunjungan->keperluan }}
                        </div>
                    </div>

                    <!-- KETERANGAN -->
                    @if ($kunjungan->keterangan)
                        <div>
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-info-circle me-2"></i>

                                Keterangan
                            </h5>

                            <div
                                class="bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-4 p-4 lh-lg"
                            >
                                {{ $kunjungan->keterangan }}
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>

        <!-- =========================
         SIDEBAR STATUS
        ========================= -->

        <div class="col-lg-4">
            <!-- STATUS -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-primary mb-4">Status Kunjungan</h5>

                    <!-- BADGE -->
                    <div class="text-center mb-4">
                        @php
                        $status =
                            $kunjungan->status_kunjungan;
                    @endphp

                        <span
                            class="
                            badge rounded-pill px-4 py-3
                            fs-6

                            {{
                                $status == 'diterima'
                                ? ($kunjungan->is_served ? 'bg-success text-white' : 'bg-success')
                                : (
                                    $status == 'ditolak'
                                    ? 'bg-danger'
                                    : 'bg-warning text-dark'
                                )
                            }}
                        "
                        >
                            {{ $status == 'diterima' && $kunjungan->is_served ? 'SELESAI DILAYANI' : strtoupper($status) }}
                        </span>
                    </div>

                    @if ($status === 'diterima' && !$kunjungan->is_served)
                        <form
                            action="{{ route('admin.kunjungan.selesai', $kunjungan->id_kunjungan) }}"
                            method="POST"
                            class="mb-3"
                            onsubmit="
                                return confirm(
                                    'Apakah Anda yakin ingin menyelesaikan kunjungan ini?',
                                );
                            "
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-success w-100 rounded-4 py-3 fw-bold"
                            >
                                <i class="bi bi-check-lg me-1"></i>
                                Selesai Dilayani
                            </button>
                        </form>
                    @endif

                    <!-- FORM -->
                    <form
                        action="{{ route('admin.kunjungan.status', $kunjungan->id_kunjungan) }}"
                        method="POST"
                    >
                        @csrf

                        <!-- STATUS -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Ubah Status
                            </label>

                            <select
                                name="status_kunjungan"
                                class="form-select rounded-4"
                                required
                            >
                                <option
                                    value="pending"
                                    {{ $status == 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="diterima"
                                    {{ $status == 'diterima' ? 'selected' : '' }}
                                >
                                    Diterima
                                </option>

                                <option
                                    value="ditolak"
                                    {{ $status == 'ditolak' ? 'selected' : '' }}
                                >
                                    Ditolak
                                </option>
                            </select>
                        </div>

                        <!-- KETERANGAN -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Keterangan
                            </label>

                            <textarea
                                name="keterangan"
                                rows="4"
                                class="form-control rounded-4"
                                >{{ $kunjungan->keterangan }}</textarea
                            >
                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="btn btn-primary w-100 rounded-4 py-3 fw-bold"
                        >
                            <i class="bi bi-check-circle me-1"></i>

                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- LOG STATUS -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-primary mb-4">Riwayat Status</h5>

                    @forelse (
                    $kunjungan->logStatuses
                    as $log
                )
                        <div class="d-flex gap-3 mb-4">
                            <!-- ICON -->
                            <div
                                class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 45px; height: 45px"
                            >
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <!-- CONTENT -->
                            <div>
                                <h6 class="fw-bold mb-1">
                                    {{ ucfirst($log->status) }}
                                </h6>

                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($log->waktu_update)->translatedFormat('d F Y, H:i') }} WIB
                                </small>

                                @if ($log->admin)
                                    <div class="small text-primary mt-1">
                                        Oleh: {{ $log->admin->username }}
                                    </div>

                                @endif
                            </div>
                        </div>

                    @empty
                        <div class="text-center text-muted py-4">
                            Belum ada riwayat status.
                        </div>

                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
