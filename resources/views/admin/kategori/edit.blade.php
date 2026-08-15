@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Kategori</h2>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kategori->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Kategori</button>
        </form>
    </div>
</div>
@endsection
