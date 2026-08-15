@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="page-title">Dashboard Keuangan</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Ringkasan pendapatan dari langganan premium dan penjualan MAGZ.</p>
    </div>
    <div class="d-flex gap-3">
        <form action="{{ route('admin.keuangan.sync') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning px-3 shadow-sm text-dark fw-bold" onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Syncing...'; this.disabled=true; this.form.submit();">
                <i class="fas fa-sync-alt"></i> Sync Midtrans
            </button>
        </form>
        <form action="{{ route('admin.keuangan.index') }}" method="GET" class="d-flex gap-2">
            <div>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
            </div>
            <div class="d-flex align-items-center"><span class="text-muted">s/d</span></div>
            <div>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
            </div>
            <button type="submit" class="btn btn-primary px-3"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>

@if($startDate == now()->startOfMonth()->format('Y-m-d') && $endDate == now()->endOfMonth()->format('Y-m-d'))
    <div class="alert py-2 mb-4" style="background: rgba(15,23,42,0.05); border-left: 4px solid #0f172a; font-size: 0.9rem; color: #334155;">
        <i class="fas fa-info-circle me-1"></i> Menampilkan rekapitulasi data <strong>Bulan Ini ({{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }})</strong>.
    </div>
@else
    <div class="alert py-2 mb-4" style="background: rgba(15,23,42,0.05); border-left: 4px solid #0f172a; font-size: 0.9rem; color: #334155;">
        <i class="fas fa-info-circle me-1"></i> Menampilkan rekapitulasi data dari tanggal <strong>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</strong> hingga <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>.
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">TOTAL PENDAPATAN</p>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">PENDAPATAN LANGGANAN</p>
                        <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalLangganan, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-crown fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">USER PREMIUM AKTIF</p>
                        <h4 class="mb-0 text-dark fw-bold">{{ number_format($totalPremium, 0, ',', '.') }} <span style="font-size:0.8rem;" class="text-muted fw-normal">User</span></h4>
                    </div>
                    <div class="bg-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">PENDAPATAN MAGZ</p>
                        <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalMagz, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-light text-info rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">PENDAPATAN PUSTAKA</p>
                        <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalPustaka, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.85rem; letter-spacing:0.5px;">PENDAPATAN DONASI</p>
                        <h4 class="mb-0 text-dark fw-bold">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                        <i class="fas fa-heart fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
        <div class="col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-3"><i class="fas fa-list-alt text-primary me-2"></i> Semua Transaksi Terbaru</h5>
                <ul class="nav nav-tabs border-bottom-0" id="transaksiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="magz-tab" data-bs-toggle="tab" data-bs-target="#magz" type="button" role="tab"><i class="fas fa-newspaper me-1"></i> MAGZ</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="pustaka-tab" data-bs-toggle="tab" data-bs-target="#pustaka" type="button" role="tab"><i class="fas fa-book me-1"></i> Pustaka</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="subs-tab" data-bs-toggle="tab" data-bs-target="#subs" type="button" role="tab"><i class="fas fa-address-card me-1"></i> Langganan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="donasi-tab" data-bs-toggle="tab" data-bs-target="#donasi" type="button" role="tab"><i class="fas fa-heart text-danger me-1"></i> Donasi</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="transaksiTabsContent">
                    <!-- Tab MAGZ -->
                    <div class="tab-pane fade show active" id="magz" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Pengguna</th>
                                        <th>MAGZ</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentMagzTx as $tx)
                                    <tr>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $tx->order_id }}</span></td>
                                        <td><strong>{{ $tx->pengguna->nama ?? 'Unknown' }}</strong></td>
                                        <td>{{ Str::limit($tx->magz->judul ?? 'Unknown', 20) }}</td>
                                        <td class="fw-bold text-success">Rp {{ number_format($tx->gross_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if(in_array($tx->status, ['settlement', 'success', 'capture']))
                                                <span class="badge bg-success">Berhasil</span>
                                            @elseif($tx->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($tx->status) }}</span>
                                            @endif
                                        </td>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $tx->created_at->format('d M Y, H:i') }}</span></td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi MAGZ.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Pustaka -->
                    <div class="tab-pane fade" id="pustaka" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Pengguna</th>
                                        <th>Pustaka</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPustakaTx as $tx)
                                    <tr>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $tx->order_id }}</span></td>
                                        <td><strong>{{ $tx->pengguna->nama ?? 'Unknown' }}</strong></td>
                                        <td>{{ Str::limit($tx->pustaka->judul ?? 'Unknown', 20) }}</td>
                                        <td class="fw-bold text-success">Rp {{ number_format($tx->gross_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if(in_array($tx->status, ['settlement', 'success', 'capture']))
                                                <span class="badge bg-success">Berhasil</span>
                                            @elseif($tx->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($tx->status) }}</span>
                                            @endif
                                        </td>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $tx->created_at->format('d M Y, H:i') }}</span></td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi Pustaka.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <!-- Tab Langganan -->
                    <div class="tab-pane fade" id="subs" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pengguna</th>
                                        <th>Paket</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Berlaku s/d</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSubs as $sub)
                                    @php
                                        $totalNominal = 0;
                                        if ($sub->histories && $sub->histories->count() > 0) {
                                            $totalNominal = $sub->histories->sum('nominal');
                                        } else {
                                            // Fallback jika tidak ada history
                                            $totalNominal = 37500;
                                            if($sub->paket === 'paket4bulan') $totalNominal = 112500;
                                            elseif($sub->paket === 'paket6bulan') $totalNominal = 125000;
                                        }
                                    @endphp
                                    <tr data-bs-toggle="collapse" data-bs-target="#history-{{ $sub->id }}" style="cursor: pointer;" title="Klik untuk melihat riwayat">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width:30px;height:30px;border-radius:50%;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:bold;flex-shrink:0;">
                                                    {{ strtoupper(substr($sub->pengguna->nama ?? 'A', 0, 1)) }}
                                                </div>
                                                <strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px; display: inline-block;">{{ $sub->pengguna->nama ?? 'Unknown' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($sub->paket === 'bulanan') 1 Bulan
                                            @elseif($sub->paket === 'paket4bulan') 4 Bulan
                                            @elseif($sub->paket === 'paket6bulan') 6 Bulan
                                            @else {{ $sub->paket }}
                                            @endif
                                        </td>
                                        <td class="fw-bold text-success">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                                        <td>
                                            @if($sub->status === 'aktif' && \Carbon\Carbon::parse($sub->berlaku_hingga)->isFuture())
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $sub->created_at->format('d M Y, H:i') }}</span></td>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($sub->berlaku_hingga)->format('d/m/Y') }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="p-0 border-0">
                                            <div class="collapse" id="history-{{ $sub->id }}">
                                                <div class="p-3 bg-light border-bottom border-top">
                                                    @if($sub->histories && $sub->histories->count() > 0)
                                                        <ul class="list-unstyled mb-0 ms-4 text-muted" style="font-size:0.9rem;">
                                                            @foreach($sub->histories as $history)
                                                                @php
                                                                    $paketStr = '1 Bulan';
                                                                    if($history->paket === 'paket4bulan') $paketStr = '4 Bulan';
                                                                    elseif($history->paket === 'paket6bulan') $paketStr = '6 Bulan';
                                                                @endphp
                                                                <li class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> langganan pada {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y') }} selama {{ $paketStr }} total Rp {{ number_format($history->nominal, 0, ',', '.') }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mb-0 ms-4 text-muted" style="font-size:0.9rem;">Belum ada riwayat lainnya.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada langganan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Donasi -->
                    <div class="tab-pane fade" id="donasi" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Nama Donatur</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentDonations as $donasi)
                                    <tr>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $donasi->order_id }}</span></td>
                                        <td><strong>{{ $donasi->donor_name ?? 'Donatur Anonim' }}</strong></td>
                                        <td class="fw-bold text-success">Rp {{ number_format($donasi->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if(in_array($donasi->status, ['settlement', 'success', 'capture']))
                                                <span class="badge bg-success">Berhasil</span>
                                            @elseif($donasi->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($donasi->status) }}</span>
                                            @endif
                                        </td>
                                        <td><span class="text-muted" style="font-size:0.85rem;">{{ $donasi->created_at->format('d M Y, H:i') }}</span></td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada donasi masuk.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
