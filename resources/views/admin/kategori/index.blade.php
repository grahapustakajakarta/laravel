@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Manajemen Kategori</h2>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kategori</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td><code>{{ $item->slug }}</code></td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="d-inline">
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
