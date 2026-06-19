@extends ('admin.layouts.app')

@section ('title', 'Profil Admin')
@section ('page-title', 'Profil Saya')

@section ('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm overflow-hidden">
                <!-- HEADER -->
                <div
                    class="p-5 text-center"
                    style="
                        background: linear-gradient(135deg, #1e3a8a, #2563eb);
                    "
                >
                    <!-- AVATAR -->
                    <div
                        class="rounded-circle mx-auto d-flex align-items-center justify-content-center text-white fw-bold shadow"
                        style="
                            width: 110px;
                            height: 110px;
                            font-size: 2.5rem;
                            background: rgba(255, 255, 255, 0.15);
                            border: 4px solid rgba(255, 255, 255, 0.2);
                            backdrop-filter: blur(10px);
                        "
                    >
                        {{ strtoupper(substr($admin->username ?? 'A', 0, 1)) }}
                    </div>

                    <h3 class="fw-bold text-white mt-4 mb-1">
                        {{ $admin->username }}
                    </h3>

                    <p class="text-white-50 mb-0">Administrator Sistem Buku Tamu</p>
                </div>

                <!-- BODY -->
                <div class="card-body p-5">
                    <form
                        action="{{ route('admin.profil.update') }}"
                        method="POST"
                    >
                        @csrf
                        @method ('PUT')

                        <div class="g-4">
                            <!-- USERNAME -->
                            <div>
                                <label class="form-label fw-semibold">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    value="{{ old('username', $admin->username) }}"
                                    required
                                />
                            </div>

                            <!-- PASSWORD -->
                            <div>
                                <label class="form-label fw-semibold">
                                    Password Baru
                                </label>

                                <div class="input-group">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="Kosongkan jika tidak diubah"
                                    />

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword()"
                                    >
                                        <i
                                            class="bi bi-eye"
                                            id="iconPassword"
                                        ></i>
                                    </button>
                                </div>
                            </div>

                            <!-- KONFIRMASI -->
                            <div>
                                <label class="form-label fw-semibold">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                />
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <div class="mt-5 text-end">
                            <button
                                type="submit"
                                class="btn btn-primary px-4 py-2"
                            >
                                <i class="bi bi-check-circle me-1"></i>

                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- SHOW PASSWORD -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');

            const icon = document.getElementById('iconPassword');

            if (password.type === 'password') {
                password.type = 'text';

                icon.classList.remove('bi-eye');

                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';

                icon.classList.remove('bi-eye-slash');

                icon.classList.add('bi-eye');
            }
        }
    </script>

@endsection
