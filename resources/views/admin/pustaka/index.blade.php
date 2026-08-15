@extends('admin.layouts.app')

@section('title', 'Manajemen Pustaka')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Pustaka</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Kelola daftar buku dan detail buku untuk katalog pustaka.</p>
    </div>
    <a href="{{ route('admin.pustaka.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Buku</a>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.pustaka.index') }}" class="d-flex align-items-center gap-3">
            <input type="text" name="search" class="form-control form-control-sm" style="max-width:300px;" placeholder="Cari judul buku..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.pustaka.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover w-100 align-middle" id="tbl-pustaka">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="8%">Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pustaka as $index => $item)
                <tr>
                    <td>{{ $pustaka->firstItem() + $index }}</td>
                    <td>
                        @if($item->gambar_1)
                            <img src="{{ asset('img/' . $item->gambar_1) }}" style="width:50px; height:65px; object-fit:cover; border-radius:4px;" alt="cover">
                        @else
                            <div style="width:50px;height:65px;background:#f1f5f9;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-book text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->judul }}</strong> @if(isset($item->status) && $item->status === 'draft') <span class="badge bg-secondary ms-1">Draft</span> @endif
                        <div class="text-muted" style="font-size:0.8rem;">{{ Str::limit($item->deskripsi, 60) }}</div>
                    </td>
                    <td>{{ $item->penulis ? $item->penulis->nama : '-' }}</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">{{ $item->harga ?? '-' }}</span></td>
                    <td>
                        <a href="{{ route('admin.pustaka.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square"></i> Edit</a>
                        <form action="{{ route('admin.pustaka.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-book fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                        Belum ada data buku pustaka.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $pustaka->links() }}
        </div>
    </div>
</div>
@endsection
