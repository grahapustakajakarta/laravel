@extends('admin.layouts.app')

@section('title', 'Tambah Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Tambah Admin Baru</h2>
    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.pengguna.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email Login <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="off">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                <select name="role" id="role-select" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                <small class="text-muted">Super Admin memiliki akses penuh termasuk kelola admin lain & log aktivitas.</small>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3" id="permissions-section" style="display: none;">
                <label class="form-label fw-bold">Hak Akses Modul <span class="text-danger">*</span></label>
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            @php
                                $modules = [
                                    'kategori' => 'Kategori',
                                    'penulis' => 'Penulis',
                                    'artikel' => 'Artikel',
                                    'puisi' => 'puisi',
                                    'publikasi' => 'Publikasi',
                                    'pustaka' => 'Pustaka',
                                    'magz' => 'MAGZ',
                                    'tulisan_user' => 'Kelola Tulisan User',
                                    'keuangan' => 'Kelola Keuangan'
                                ];
                            @endphp
                            @foreach($modules as $key => $label)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ $key }}">
                                    <label class="form-check-label" for="perm_{{ $key }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                <small class="text-muted">Minimal 6 karakter.</small>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Admin</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role-select');
        const permSection = document.getElementById('permissions-section');

        function togglePermissions() {
            if (roleSelect.value === 'admin') {
                permSection.style.display = 'block';
            } else {
                permSection.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', togglePermissions);
        togglePermissions(); // initial check
    });
</script>
@endpush
