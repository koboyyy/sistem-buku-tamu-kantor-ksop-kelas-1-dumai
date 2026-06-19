@extends ('admin.layouts.app')

@section ('title', 'Data Tamu')
@section ('page-title', 'Data Tamu')

@section ('content')
    <div class="card border-0 shadow-sm">
        <div
            class="card-header bg-white border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
        >
            <div>
                <h5 class="fw-bold mb-1">Daftar Tamu Terdaftar</h5>
                <p class="text-muted mb-0">Kelola seluruh data tamu yang terdaftar pada sistem.</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span
                    class="badge rounded-pill px-3 py-2"
                    style="
                        background: rgba(37, 99, 235, 0.1);
                        color: #2563eb;
                        font-size: 0.8rem;
                    "
                >
                    {{ $tamus->count() }} Tamu
                </span>
            </div>
        </div>

        <div class="px-4 pt-3">
            <form method="GET" action="{{ route('admin.tamu.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control border-start-0"
                        placeholder="Cari nama, instansi, email, atau nomor HP..."
                        value="{{ request('search') }}"
                    />

                    @if (request('search'))
                        <a
                            href="{{ route('admin.tamu.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            Reset
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th class="text-center">Jml Kunjungan</th>
                            <th class="text-center px-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tamus as $i => $t)
                            <tr>
                                <td class="px-4 text-muted">{{ $i + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $t->nama }}
                                    </div>
                                </td>

                                <td>{{ $t->instansi }}</td>

                                <td>{{ $t->email }}</td>

                                <td>{{ $t->no_hp }}</td>

                                <td class="text-center">
                                    <span
                                        class="badge rounded-pill px-3 py-2"
                                        style="
                                            background: rgba(37, 99, 235, 0.1);
                                            color: #2563eb;
                                        "
                                    >
                                        {{ $t->kunjungans_count }}
                                    </span>
                                </td>

                                <td class="px-4">
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-2"
                                    >
                                        <a
                                            href="{{ route('admin.tamu.riwayat', $t->id_tamu) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            <i
                                                class="bi bi-clock-history me-1"
                                            ></i>
                                            Riwayat
                                        </a>

                                        <form
                                            action="{{ route('admin.tamu.hapus', $t->id_tamu) }}"
                                            method="POST"
                                            onsubmit="
                                                return confirm(
                                                    'Hapus tamu ini?',
                                                );
                                            "
                                        >
                                            @csrf
                                            @method ('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bi bi-trash me-1"></i>
                                                Hapus
                                            </button>
                                        </form>
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
                                            class="bi bi-search fs-1 text-secondary mb-3"
                                        ></i>

                                        @if (request('search'))
                                            <h5 class="fw-bold text-secondary">
                                                Data Tidak Ditemukan
                                            </h5>
                                            <p class="text-muted mb-0">
                                                Tidak ada data tamu yang sesuai
                                                dengan pencarian:
                                                <strong
                                                    >"{{ request('search') }}"</strong
                                                >
                                            </p>
                                        @else
                                            <h5 class="fw-bold text-secondary">
                                                Belum Ada Data Tamu
                                            </h5>
                                            <p class="text-muted mb-0">Data tamu akan muncul di sini.</p>
                                        @endif
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
