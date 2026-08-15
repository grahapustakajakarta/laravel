@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Kelola User</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Manajemen akun pengguna biasa (pembaca & penulis).</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email Login</th>
                    <th>Status Langganan</th>
                    <th>Terdaftar Sejak</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:35px;height:35px;border-radius:50%;background:#0f172a;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:bold;flex-shrink:0;">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $item->nama }}</strong>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">{{ $item->email }}</td>
                    <td>
                        @if($item->isPremium())
                            <span class="badge bg-success"><i class="fas fa-crown"></i> Premium</span>
                        @else
                            <span class="badge bg-secondary">Gratis</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.datauser.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
