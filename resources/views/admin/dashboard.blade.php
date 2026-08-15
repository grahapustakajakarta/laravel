@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Dashboard</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>

<div class="row mb-4">
    <!-- Total Artikel -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-start border-4 border-danger">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-danger text-uppercase mb-1">Total Artikel</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($totalArtikel) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-3x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-start border-4 border-dark">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-dark text-uppercase mb-1">Total Kategori</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($totalKategori) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-3x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tayangan -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-start border-4 border-secondary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Total Tayangan</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($totalTayang) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-3x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        @if((isset($badge_tulisan_pending) && $badge_tulisan_pending > 0) || (isset($badge_deletion_requests) && $badge_deletion_requests > 0) || (isset($badge_keuangan) && $badge_keuangan > 0) || (isset($badge_new_users) && $badge_new_users > 0))
            <div class="card shadow-sm border-left-warning mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-danger"><i class="fas fa-bell"></i> Pemberitahuan Penting</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($badge_tulisan_pending) && $badge_tulisan_pending > 0)
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.penggunatulisan.index') }}" class="text-decoration-none">
                                <div class="alert alert-warning mb-0 text-center shadow-sm">
                                    <h3 class="fw-bold mb-1">{{ $badge_tulisan_pending }}</h3>
                                    <span>Tulisan User Pending</span>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset($badge_deletion_requests) && $badge_deletion_requests > 0 && auth()->user()->isSuperAdmin())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.deletion_requests.index') }}" class="text-decoration-none">
                                <div class="alert alert-danger mb-0 text-center shadow-sm">
                                    <h3 class="fw-bold mb-1">{{ $badge_deletion_requests }}</h3>
                                    <span>Request Hapus Artikel</span>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset($badge_keuangan) && $badge_keuangan > 0)
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.keuangan.index') }}" class="text-decoration-none">
                                <div class="alert alert-success mb-0 text-center shadow-sm">
                                    <h3 class="fw-bold mb-1">{{ $badge_keuangan }}</h3>
                                    <span>Transaksi Keuangan</span>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset($badge_new_users) && $badge_new_users > 0 && auth()->user()->isSuperAdmin())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.datauser.index') }}" class="text-decoration-none">
                                <div class="alert alert-info mb-0 text-center shadow-sm">
                                    <h3 class="fw-bold mb-1">{{ $badge_new_users }}</h3>
                                    <span>User Baru Hari Ini</span>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-dark">Selamat Datang di Panel Kontrol Galeri Buku Jakarta</h6>
            </div>
            <div class="card-body">
                <p>Gunakan menu navigasi di sebelah kiri untuk mengelola data website. Seluruh aksi yang Anda lakukan (tambah, ubah, hapus) akan langsung memperbarui tampilan pada website utama.</p>
                <ul>
                    <li><strong>Kategori:</strong> Kelola rubrik/kategori konten.</li>
                    <li><strong>Penulis:</strong> Kelola data nama penulis.</li>
                    <li><strong>Artikel:</strong> Manajemen seluruh konten artikel beserta gambar pendukungnya.</li>
                    @if(auth()->user()->isSuperAdmin())
                    <li><strong>Super Admin:</strong> Kelola admin, log aktivitas pengguna, transaksi keuangan, dan persetujuan penghapusan.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
