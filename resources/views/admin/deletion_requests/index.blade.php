@extends('admin.layouts.app')

@section('title', 'Persetujuan Hapus Artikel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Persetujuan Hapus Artikel (Super Admin)</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Admin Peminta</th>
                    <th>Tipe Hapus</th>
                    <th>Detail Artikel</th>
                    <th>Status</th>
                    <th>Waktu Request</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $index => $req)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $req->pengguna->nama ?? '-' }}</strong></td>
                    <td>
                        @if($req->type == 'all')
                            <span class="badge bg-danger">HAPUS SEMUA</span>
                        @else
                            <span class="badge bg-warning text-dark">SINGLE</span>
                        @endif
                    </td>
                    <td>
                        @if($req->type == 'single' && $req->artikel)
                            {{ $req->artikel->judul }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($req->status == 'pending')
                            <span class="badge bg-secondary">Pending</span>
                        @elseif($req->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-dark">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($req->status == 'pending')
                        <form action="{{ route('admin.deletion_requests.approve', $req->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui penghapusan ini?');"><i class="fas fa-check"></i> Setujui</button>
                        </form>
                        <form action="{{ route('admin.deletion_requests.reject', $req->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm('Tolak penghapusan ini?');"><i class="fas fa-times"></i> Tolak</button>
                        </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada permintaan penghapusan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
