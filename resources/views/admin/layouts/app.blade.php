<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @yield ('title', 'Admin')
        - KSOP Dumai
    </title>
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
        /* ===== CSS Variables - Navy & White Theme ===== */
        :root {
            --navy-darkest: #0a1628;
            --navy-dark: #0d2244;
            --navy-primary: #1a3a6b;
            --navy-medium: #1e4d8c;
            --navy-accent: #2563b0;
            --navy-light: #dbeafe;
            --navy-lighter: #eff6ff;
            --white: #ffffff;
            --text-muted: #6b7280;
            --text-dark: #1f2937;
            --border: #e5e7eb;
            --bg-page: #f0f4f8;
            --sidebar-w: 260px;
        }

        /* ===== Base ===== */
        body {
            overflow-x: hidden;
            background-color: var(--bg-page);
            color: var(--text-dark);
            font-family:
                'Segoe UI',
                system-ui,
                -apple-system,
                sans-serif;
        }

        /* ===== Sidebar ===== */
        #sidebar {
            min-width: var(--sidebar-w);
            max-width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(
                180deg,
                var(--navy-darkest) 0%,
                var(--navy-dark) 100%
            );
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar-header {
            padding: 22px 20px;
            background: rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-header img {
            height: 48px;
            flex-shrink: 0;
        }
        .sidebar-brand-text h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 0.5px;
        }
        .sidebar-brand-text small {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.72rem;
        }

        /* Nav Items */
        .sidebar-nav {
            padding: 16px 0;
        }
        .sidebar-nav .nav-label {
            padding: 8px 20px 4px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }
        .sidebar-nav a i {
            font-size: 1rem;
            min-width: 20px;
        }
        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.07);
            color: var(--white);
            border-left-color: rgba(255, 255, 255, 0.3);
        }
        .sidebar-nav li.active a {
            background: rgba(37, 99, 176, 0.35);
            color: var(--white);
            font-weight: 600;
            border-left-color: var(--navy-accent);
        }
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin: 10px 16px;
        }
        .sidebar-nav a.logout-link {
            color: rgba(255, 180, 180, 0.8);
        }
        .sidebar-nav a.logout-link:hover {
            color: #fca5a5;
            background: rgba(220, 50, 50, 0.1);
        }

        /* ===== Content Area ===== */
        #content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== Top Navbar ===== */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }
        .topbar-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--navy-primary);
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .topbar-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .topbar-badge {
            width: 36px;
            height: 36px;
            background: linear-gradient(
                135deg,
                var(--navy-medium),
                var(--navy-accent)
            );
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* ===== Page Content ===== */
        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ===== Cards ===== */
        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        }
        .card-header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            border-radius: 12px 12px 0 0 !important;
            padding: 16px 20px;
        }
        .card-header h5,
        .card-header .card-title {
            color: var(--navy-primary);
            font-weight: 700;
            margin: 0;
        }

        /* ===== Stat Cards ===== */
        .stat-card {
            border: none !important;
            border-radius: 14px !important;
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;
        }
        .stat-card .icon-box {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* ===== Navy gradient card variants ===== */
        .card-navy-1 {
            background: linear-gradient(135deg, #1a3a6b 0%, #2563b0 100%);
            color: white;
        }
        .card-navy-2 {
            background: linear-gradient(135deg, #0d2244 0%, #1a3a6b 100%);
            color: white;
        }
        .card-navy-3 {
            background: linear-gradient(135deg, #1e4d8c 0%, #3b82f6 100%);
            color: white;
        }
        .card-navy-4 {
            background: linear-gradient(135deg, #0f4c75 0%, #1b6ca8 100%);
            color: white;
        }

        /* ===== Tables ===== */
        .table thead th {
            background: var(--navy-lighter);
            color: var(--navy-primary);
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid var(--navy-light);
            padding: 13px 16px;
        }
        .table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            font-size: 0.875rem;
        }
        .table-hover tbody tr:hover {
            background-color: var(--navy-lighter);
        }

        /* ===== Badges ===== */
        .badge-navy {
            background: var(--navy-light);
            color: var(--navy-primary);
        }
        .badge-antrian {
            background: var(--navy-light);
            color: var(--navy-primary);
            font-weight: 700;
        }

        /* ===== Buttons ===== */
        .btn-navy {
            background: var(--navy-primary);
            color: white;
            border: none;
        }
        .btn-navy:hover {
            background: var(--navy-medium);
            color: white;
        }
        .btn-navy-outline {
            border: 1.5px solid var(--navy-primary);
            color: var(--navy-primary);
        }
        .btn-navy-outline:hover {
            background: var(--navy-primary);
            color: white;
        }

        /* ===== Alerts ===== */
        .alert-success {
            border-left: 4px solid #10b981;
            background: #ecfdf5;
            color: #065f46;
            border-top: none;
            border-right: none;
            border-bottom: none;
        }

        /* ===== Form Controls ===== */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--navy-accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 176, 0.12);
        }

        /* ===== Print ===== */
        @media
        print {
                   .no-print {
                       display: none !important;
                   }
                   #content {
                       width: 100% !important;
                       margin-left: 0 !important;
                   }
                   body {
                       background-color: white;
                       font-size: 12px;
                   }
                   .card {
                       border: none !important;
                       box-shadow: none !important;
                   }
               }

               /* ===== Responsive ===== */
        @media (max-width: 768px)
        {
                   #sidebar {
                       margin-left: calc(-1 * var(--sidebar-w));
                   }
                   #content {
                       margin-left: 0;
                   }
                   #sidebar.active {
                       margin-left: 0;
                   }
               }
    </style>

    @stack ('styles')
</head>
<body>
    <div class="">
        <!-- ===== SIDEBAR ===== -->
        <nav id="sidebar" class="no-print">
            <div class="sidebar-header">
                <img
                    src="{{ asset('logo-ksop-kelas-1-dumai.png') }}"
                    alt="Logo KSOP"
                />
                <div class="sidebar-brand-text">
                    <h5>KANTOR KSOP KELAS I DUMAI</h5>
                    <small>Sistem Buku Tamu</small>
                </div>
            </div>

            <!-- PROFILE -->
            <div class="px-3 py-3 border-bottom border-secondary-subtle">
                <div class="d-flex align-items-center gap-3">
                    <!-- AVATAR -->
                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                        style="
                            width: 50px;
                            height: 50px;
                            background: linear-gradient(
                                135deg,
                                #2563eb,
                                #1e40af
                            );
                            font-size: 1.1rem;
                        "
                    >
                        {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 1)) }}
                    </div>

                    <!-- INFO -->
                    <div class="text-white">
                        <div class="fw-semibold">
                            {{ Auth::guard('admin')->user()->nama ?? 'Administrator' }}
                        </div>

                        <small class="text-white-50">
                            {{ Auth::guard('admin')->user()->email ?? 'admin@mail.com' }}
                        </small>
                    </div>
                </div>
            </div>

            <ul class="list-unstyled sidebar-nav">
                <li class="nav-label">Menu Utama</li>
                <li
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li
                    class="{{ request()->routeIs('admin.tamu.*') ? 'active' : '' }}"
                >
                    <a href="{{ route('admin.tamu.index') }}">
                        <i class="bi bi-people-fill"></i> Data Tamu
                    </a>
                </li>
                <li
                    class="{{ request()->routeIs('admin.kunjungan.*') ? 'active' : '' }}"
                >
                    <a href="{{ route('admin.kunjungan.index') }}">
                        <i class="bi bi-calendar-check"></i> Data Kunjungan
                    </a>
                </li>
                <li
                    class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}"
                >
                    <a href="{{ route('admin.laporan') }}">
                        <i class="bi bi-journal-text"></i> Laporan
                    </a>
                </li>

                <div class="sidebar-divider"></div>
                <li class="nav-label">Akun</li>

                <li
                    class="{{ request()->routeIs('admin.profil') ? 'active' : '' }}"
                >
                    <a href="{{ route('admin.profil') }}">
                        <i class="bi bi-person-circle"></i>

                        Profil Saya
                    </a>
                </li>

                <li>
                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        id="logout-form"
                        class="d-none"
                    >
                        @csrf
                    </form>
                    <a
                        href="#"
                        class="logout-link"
                        onclick="
                            event.preventDefault();
                            document.getElementById('logout-form').submit();
                        "
                    >
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- ===== MAIN CONTENT ===== -->
        <div id="content">
            <!-- Top Bar -->
            <div class="topbar no-print">
                <div class="d-flex align-items-center gap-3">
                    @yield ('topbar-left')
                    <span class="topbar-title">
                        @yield ('page-title', 'Dashboard')
                    </span>
                </div>
                <div class="topbar-right">
                    <span class="topbar-time">
                        <i class="bi bi-clock me-1"></i>
                        {{ now()->format('d M Y, H:i') }}
                    </span>
                    <div class="dropdown">
                        <button
                            class="btn p-0 border-0 bg-transparent"
                            data-bs-toggle="dropdown"
                        >
                            <div
                                class="topbar-badge"
                                style="
                                    width: 42px;
                                    height: 42px;
                                    border-radius: 50%;
                                "
                            >
                                {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 1)) }}
                            </div>
                        </button>

                        <ul
                            class="dropdown-menu dropdown-menu-end shadow border-0"
                            style="min-width: 240px"
                        >
                            <li class="px-3 py-3">
                                <div class="fw-bold">
                                    {{ Auth::guard('admin')->user()->nama ?? 'Administrator' }}
                                </div>

                                <small class="text-muted">
                                    {{ Auth::guard('admin')->user()->email ?? '-' }}
                                </small>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('admin.profil') }}"
                                >
                                    <i class="bi bi-person me-2"></i>

                                    Profil Saya
                                </a>
                            </li>

                            <li>
                                <a
                                    class="dropdown-item text-danger"
                                    href="#"
                                    onclick="
                                        event.preventDefault();
                                        document
                                            .getElementById('logout-form')
                                            .submit();
                                    "
                                >
                                    <i class="bi bi-box-arrow-right me-2"></i>

                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div class="px-4 pt-3">
                @if (session('success'))
                    <div
                        class="alert alert-success alert-dismissible fade show shadow-sm"
                        role="alert"
                    >
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="alert alert-danger alert-dismissible fade show shadow-sm"
                        role="alert"
                    >
                        <i class="bi bi-x-circle-fill me-2"></i>
                        {{ session('error') }}
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="page-content">
                @yield ('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack ('scripts')
</body>
</html>
