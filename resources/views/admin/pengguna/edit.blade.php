@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Admin</h2>
    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pengguna->nama) }}" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email Login <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pengguna->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                <select name="role" id="role-select" class="form-select @error('role') is-invalid @enderror" required {{ auth()->id() === $pengguna->id ? 'disabled' : '' }}>
                    <option value="admin" {{ old('role', $pengguna->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $pengguna->role) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @if(auth()->id() === $pengguna->id)
                    <input type="hidden" id="hidden-role" name="role" value="{{ $pengguna->role }}">
                    <small class="text-warning"><i class="fas fa-lock"></i> Anda tidak dapat mengubah role akun Anda sendiri.</small>
                @endif
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
                                $userPerms = is_array($pengguna->permissions) ? $pengguna->permissions : [];
                            @endphp
                            @foreach($modules as $key => $label)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ $key }}" {{ in_array($key, $userPerms) ? 'checked' : '' }}>
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
                <label class="form-label fw-bold">Password Baru <span class="text-muted">(Opsional)</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Perbarui Admin</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role-select');
        const hiddenRole = document.getElementById('hidden-role');
        const permSection = document.getElementById('permissions-section');

        function togglePermissions() {
            let roleVal = roleSelect.value;
            if (roleSelect.disabled && hiddenRole) {
                roleVal = hiddenRole.value;
            }

            if (roleVal === 'admin') {
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
