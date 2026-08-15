<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #e63946;
            --primary-hover: #d62828;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --body-bg: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: #334155;
        }

        /* Wrapper & Layout */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background: var(--sidebar-bg);
            color: #f1f5f9;
            transition: all var(--transition-speed);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        #sidebar .sidebar-header {
            padding: 30px 20px;
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        #sidebar .sidebar-header h3 {
            color: #fff;
            font-weight: 800;
            margin: 0;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }
        
        #sidebar .sidebar-header h3 span {
            color: var(--primary-color);
        }

        #sidebar ul.components {
            padding: 20px 15px;
            flex-grow: 1;
        }

        #sidebar ul li {
            margin-bottom: 8px;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        #sidebar ul li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: transform 0.2s;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: var(--sidebar-hover);
            transform: translateX(5px);
        }

        #sidebar ul li.active > a {
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
        }

        /* Main Content */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Topbar with Glassmorphism */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 15px 30px;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .main-content {
            padding: 40px;
            flex: 1;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(230, 57, 70, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(230, 57, 70, 0.3);
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 16px;
            background: #fff;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 700;
            color: #1e293b;
            padding: 20px 25px;
        }
        
        .card-body {
            padding: 25px;
        }

        /* Typography */
        .page-title {
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 0;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }
        .table > :not(caption) > * > * {
            padding: 1rem 1rem;
            border-bottom-color: #f1f5f9;
        }
        .table th {
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        /* Dropdown profile */
        .dropdown-toggle::after {
            display: none;
        }
        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Footer */
        footer {
            background: transparent !important;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8 !important;
            font-size: 0.9rem;
        }

        /* Sidebar section labels */
        #sidebar ul li.nav-section-label {
            padding: 8px 20px 4px;
            font-size: 0.65rem;
            font-weight: 800;
            color: #475569;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: default;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>GBJ<span>ADMIN</span></h3>
            @if(auth()->check() && auth()->user()->isSuperAdmin())
                <small class="d-block mt-1" style="color: #e63946; font-size: 0.7rem; letter-spacing: 1px; font-weight: 700;">⬡ SUPER ADMIN</small>
            @endif
        </div>

        <ul class="list-unstyled components">
            <li class="nav-section-label">MENU UTAMA</li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge-high"></i> Dashboard</a>
            </li>
            @if(auth()->check() && auth()->user()->hasPermission('kategori'))
            <li class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <a href="{{ route('admin.kategori.index') }}"><i class="fas fa-layer-group"></i> Kategori</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('penulis'))
            <li class="{{ request()->routeIs('admin.penulis.*') ? 'active' : '' }}">
                <a href="{{ route('admin.penulis.index') }}"><i class="fas fa-user-pen"></i> Penulis</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('artikel'))
            <li class="{{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
                <a href="{{ route('admin.artikel.index') }}"><i class="fas fa-file-lines"></i> Artikel</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('puisi'))
            <li class="{{ request()->routeIs('admin.puisi.*') ? 'active' : '' }}">
                <a href="{{ route('admin.puisi.index') }}"><i class="fas fa-feather"></i> puisi</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('publikasi'))
            <li class="{{ request()->routeIs('admin.publikasi.*') ? 'active' : '' }}">
                <a href="{{ route('admin.publikasi.index') }}"><i class="fas fa-book-open"></i> Publikasi</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('pustaka'))
            <li class="{{ request()->routeIs('admin.pustaka.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pustaka.index') }}"><i class="fas fa-book"></i> Pustaka</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('magz'))
            <li class="{{ request()->routeIs('admin.magz.*') ? 'active' : '' }}">
                <a href="{{ route('admin.magz.index') }}"><i class="fas fa-newspaper"></i> MAGZ</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('tulisan_user'))
            <li class="{{ request()->routeIs('admin.penggunatulisan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.penggunatulisan.index') }}" class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-signature"></i> Kelola Tulisan User</span>
                    @if(isset($badge_tulisan_pending) && $badge_tulisan_pending > 0)
                        <span class="badge bg-danger rounded-pill">{{ $badge_tulisan_pending }}</span>
                    @endif
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasPermission('keuangan'))
            <li class="{{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.keuangan.index') }}" class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-wallet"></i> Kelola Keuangan</span>
                    @if(isset($badge_keuangan) && $badge_keuangan > 0)
                        <span class="badge bg-warning text-dark rounded-pill">{{ $badge_keuangan }}</span>
                    @endif
                </a>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->isSuperAdmin())
            <li class="nav-section-label" style="margin-top: 10px;">SUPER ADMIN</li>
            <li class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pengguna.index') }}"><i class="fas fa-users-gear"></i> Kelola Admin</a>
            </li>
            <li class="{{ request()->routeIs('admin.datauser.*') ? 'active' : '' }}">
                <a href="{{ route('admin.datauser.index') }}" class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users"></i> Kelola User</span>
                    @if(isset($badge_new_users) && $badge_new_users > 0)
                        <span class="badge bg-info text-dark rounded-pill">Baru: {{ $badge_new_users }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
                <a href="{{ route('admin.log.index') }}" class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-clock-rotate-left"></i> Log Aktivitas</span>
                    @if(isset($badge_logs_today) && $badge_logs_today > 0)
                        <span class="badge bg-secondary rounded-pill">{{ $badge_logs_today }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.deletion_requests.*') ? 'active' : '' }}">
                <a href="{{ route('admin.deletion_requests.index') }}" class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-trash-check"></i> Persetujuan Hapus</span>
                    @if(isset($badge_deletion_requests) && $badge_deletion_requests > 0)
                        <span class="badge bg-danger rounded-pill">{{ $badge_deletion_requests }}</span>
                    @endif
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm">
                    <i class="fas fa-bars text-secondary"></i>
                </button>
            </div>
            <div class="dropdown">
                <a class="text-dark text-decoration-none dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-img">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <span class="fw-bold text-secondary d-none d-md-inline">{{ auth()->user()->nama ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="dropdownMenuLink">
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        
        <footer class="text-center p-4 mt-auto">
            <span>Copyright &copy; Galeri Buku Jakarta {{ date('Y') }}</span>
        </footer>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            if($(window).width() <= 768) {
                $('#sidebar').toggleClass('active');
                if($('#sidebar').hasClass('active')) {
                    $('#sidebar').css('margin-left', '0');
                } else {
                    $('#sidebar').css('margin-left', '-260px');
                }
            } else {
                $('#sidebar').toggleClass('active');
                if($('#sidebar').hasClass('active')) {
                    $('#sidebar').css('margin-left', '-260px');
                } else {
                    $('#sidebar').css('margin-left', '0');
                }
            }
        });

        // Initialize DataTables
        $('.datatable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
            }
        });

        // Delete Confirmation
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e63946',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });

        // Flash Messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@stack('scripts')
</body>
</html>
