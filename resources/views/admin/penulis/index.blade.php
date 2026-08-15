@extends('admin.layouts.app')

@section('title', 'Manajemen Penulis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Manajemen Penulis</h2>
    <a href="{{ route('admin.penulis.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Penulis</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Penulis</th>
                    <th>Biografi Singkat</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penulis as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>{{ Str::limit(strip_tags($item->biografi), 50) }}</td>
                    <td>
                        <a href="{{ route('admin.penulis.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.penulis.destroy', $item->id) }}" method="POST" class="d-inline">
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
