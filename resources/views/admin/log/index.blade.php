@extends('admin.layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Log Aktivitas</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Riwayat seluruh tindakan yang dilakukan oleh admin di sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.log.index') }}" method="GET" id="filterForm">
            <select name="admin_id" class="form-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- Semua Admin --</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $adminId == $admin->id ? 'selected' : '' }}>
                        {{ $admin->nama }} ({{ $admin->role }})
                    </option>
                @endforeach
            </select>
        </form>
        <form action="{{ route('admin.log.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-delete text-nowrap"><i class="fas fa-trash-can"></i> Bersihkan Log</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        @if($logs->count() === 0)
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                <p class="mb-0">Belum ada log aktivitas yang tercatat.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover w-100 mb-0 align-middle" id="tbl-log">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Admin</th>
                        <th>Modul</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $index => $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:30px;height:30px;border-radius:50%;background:#e63946;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.8rem;flex-shrink:0;">
                                    {{ strtoupper(substr($log->pengguna->nama ?? 'A', 0, 1)) }}
                                </div>
                                <span class="fw-bold">{{ $log->pengguna->nama ?? 'Dihapus' }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $colors = ['Artikel'=>'primary','Kategori'=>'success','Penulis'=>'info','Admin User'=>'danger'];
                                $color = $colors[$log->modul] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} fw-bold px-2 py-1">{{ $log->modul }}</span>
                        </td>
                        <td>{{ $log->aksi }}</td>
                        <td><code class="text-muted">{{ $log->ip_address ?? '-' }}</code></td>
                        <td>
                            <span title="{{ $log->created_at }}">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
