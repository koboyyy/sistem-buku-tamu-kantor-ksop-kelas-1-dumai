<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun - Buku Tamu KSOP Dumai</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />
    @vite ('resources/css/app.css')
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        .card-register {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .register-header {
            background-color: #0d6efd; /* Biru Tamu */
            padding: 25px;
            color: white;
            text-align: center;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-radius: 8px 0 0 8px;
            color: #6c757d;
        }
        .btn-register {
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark text-uppercase">
                        Registrasi Tamu
                    </h4>
                    <p class="text-muted small">Lengkapi data diri Anda untuk akses layanan digital KSOP Dumai</p>
                </div>

                <div class="card card-register shadow-lg">
                    <div class="card-body p-0">
                        <div class="register-header">
                            <i class="bi bi-person-plus-fill fs-1 mb-2"></i>
                            <h5 class="mb-0 fw-bold">Buat Akun Baru</h5>
                        </div>

                        <div class="p-4 p-md-5">
                            @if ($errors->any())
                                <div
                                    class="alert alert-danger border-0 shadow-sm mb-4"
                                >
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form
                                action="{{ route('register.post') }}"
                                method="POST"
                            >
                                @csrf

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            >Nama Lengkap
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="bi bi-person"></i
                                            ></span>
                                            <input
                                                type="text"
                                                name="nama"
                                                class="form-control"
                                                placeholder="Nama Lengkap"
                                                value="{{ old('nama') }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            >Instansi / Asal
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="bi bi-building"></i
                                            ></span>
                                            <input
                                                type="text"
                                                name="instansi"
                                                class="form-control"
                                                placeholder="PT / Instansi"
                                                value="{{ old('instansi') }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            >Nomor HP
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="bi bi-whatsapp"></i
                                            ></span>
                                            <input
                                                type="text"
                                                name="no_hp"
                                                class="form-control"
                                                placeholder="0812..."
                                                value="{{ old('no_hp') }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            >Email
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                ><i class="bi bi-envelope"></i
                                            ></span>
                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control"
                                                placeholder="email@anda.com"
                                                value="{{ old('email') }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        >Alamat Lengkap
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        name="alamat"
                                        class="form-control"
                                        rows="2"
                                        placeholder="Alamat rumah atau kantor..."
                                        required
                                        >{{ old('alamat') }}</textarea
                                    >
                                </div>

                                <div class="relative">
    <label class="block mb-2 font-semibold text-slate-700">
        Password *
    </label>

    <div class="relative">
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Min. 6 karakter"
            class="w-full border border-slate-300 rounded-xl pl-12 pr-12 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
            required
        />

        <!-- ICON LOCK -->
        <i class="bi bi-key-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>

        <!-- TOGGLE EYE -->
        <button type="button"
            onclick="togglePassword('password','eye1')"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-600">
            <i id="eye1" class="bi bi-eye-slash-fill"></i>
        </button>
    </div>
</div>
                                    <div class="relative">
    <label class="block mb-2 font-semibold text-slate-700">
        Konfirmasi Password *
    </label>

    <div class="relative">
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Ulangi Password"
            class="w-full border border-slate-300 rounded-xl pl-12 pr-12 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition"
            required
        />

        <i class="bi bi-shield-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>

        <button type="button"
            onclick="togglePassword('password_confirmation','eye2')"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-600">
            <i id="eye2" class="bi bi-eye-slash-fill"></i>
        </button>
    </div>
</div>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-register w-100 shadow-sm mb-3"
                                >
                                    <i class="bi bi-check-circle me-2"></i
                                    >Daftar Sekarang
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="small text-muted mb-0">
                                    Sudah memiliki akun?
                                    <a
                                        href="{{ route('login') }}"
                                        class="text-primary fw-bold text-decoration-none"
                                        >Login di sini</a
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted"
                        >&copy; {{ date('Y') }} KSOP Kelas I Dumai. All Rights
                        Reserved.</small
                    >
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash-fill");
        icon.classList.add("bi-eye-fill");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-fill");
        icon.classList.add("bi-eye-slash-fill");
    }
}
</script>
</body>
</html>
