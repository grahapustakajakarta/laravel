@extends('admin.layouts.app')

@section('title', 'Manajemen Publikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Publikasi</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Kelola dokumen PDF publikasi yang dapat diunduh pengunjung.</p>
    </div>
    <a href="{{ route('admin.publikasi.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Publikasi</a>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.publikasi.index') }}" class="d-flex align-items-center gap-3">
            <label class="fw-bold text-muted mb-0" style="font-size:0.85rem; white-space:nowrap;">Filter Kategori:</label>
            <select name="kategori" class="form-select form-select-sm" style="max-width:220px;" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            @if(request('kategori'))
                <a href="{{ route('admin.publikasi.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover w-100 align-middle" id="tbl-publikasi">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Cover</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>File PDF</th>
                    <th>Ditambahkan</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publikasi as $index => $item)
                <tr>
                    <td>{{ $publikasi->firstItem() + $index }}</td>
                    <td>
                        @if($item->cover_gambar)
                            <img src="{{ asset('img/' . $item->cover_gambar) }}" style="width:50px; height:65px; object-fit:cover; border-radius:4px;" alt="cover">
                        @else
                            <div style="width:50px;height:65px;background:#f1f5f9;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-file-pdf text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->judul }}</strong> @if(isset($item->status) && $item->status === 'draft') <span class="badge bg-secondary ms-1">Draft</span> @endif
                        <div class="text-muted" style="font-size:0.8rem;">{{ Str::limit($item->deskripsi, 60) }}</div>
                    </td>
                    <td><span class="badge bg-dark bg-opacity-10 text-dark fw-bold px-2 py-1">{{ $item->kategori }}</span></td>
                    <td>
                        <a href="{{ asset('pdf/' . $item->file_pdf) }}" target="_blank" class="text-decoration-none text-primary" style="font-size:0.8rem;">
                            <i class="fas fa-file-pdf me-1"></i>Lihat PDF
                        </a>
                    </td>
                    <td class="text-muted" style="font-size:0.85rem;">{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.publikasi.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square"></i> Edit</a>
                        <form action="{{ route('admin.publikasi.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-book-open fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                        Belum ada data publikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $publikasi->links() }}
        </div>
    </div>
</div>
@endsection
