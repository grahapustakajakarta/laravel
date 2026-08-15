@extends('admin.layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Kelola Admin</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Manajemen akun admin dan super admin sistem.</p>
    </div>
    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Admin</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email Login</th>
                    <th>Role</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengguna as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:35px;height:35px;border-radius:50%;background:{{ $item->role === 'superadmin' ? '#e63946' : '#0f172a' }};color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:bold;flex-shrink:0;">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $item->nama }}</strong>
                                @if(auth()->id() === $item->id) <span class="badge bg-success ms-1">Anda</span> @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">{{ $item->email }}</td>
                    <td>
                        @if($item->role === 'superadmin')
                            <span class="badge fw-bold px-2 py-1" style="background: rgba(230,57,70,0.1); color: #e63946;">⬡ Super Admin</span>
                        @else
                            <span class="badge fw-bold px-2 py-1" style="background: rgba(15,23,42,0.1); color: #0f172a;">Admin</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pengguna.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square"></i> Edit</a>
                        @if(auth()->id() !== $item->id)
                        <form action="{{ route('admin.pengguna.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
