@extends('admin.layouts.app')

@section('title', 'Manajemen puisi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Manajemen Artikel Puisi</h2>
    <a href="{{ route('admin.puisi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tulis Puisi / Sajak</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Judul</th>
                    <th>Penulis</th>
                    <th>Tgl Publikasi</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($artikel as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->judul }}</strong></td>
                    <td>{{ $item->penulis->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.puisi.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.puisi.destroy', $item->id) }}" method="POST" class="d-inline">
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
