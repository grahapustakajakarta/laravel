@extends('admin.layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Tulisan User</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tulisan Masuk</h6>
    </div>
    <div class="card-body">
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4" id="tulisanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-semua" data-bs-toggle="tab" data-filter="" type="button" role="tab">Semua</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-pending" data-bs-toggle="tab" data-filter="Pending" type="button" role="tab"><span class="text-warning"><i class="fas fa-clock"></i> Menunggu Kurasi</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-revisi" data-bs-toggle="tab" data-filter="Request Edit" type="button" role="tab"><span class="text-info"><i class="fas fa-exclamation-circle"></i> Request Edit</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-disetujui" data-bs-toggle="tab" data-filter="Disetujui" type="button" role="tab"><span class="text-success"><i class="fas fa-check"></i> Disetujui</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-ditolak" data-bs-toggle="tab" data-filter="Ditolak" type="button" role="tab"><span class="text-danger"><i class="fas fa-times"></i> Ditolak</span></button>
            </li>
        </ul>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Kirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tulisans as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->pengguna->nama }}<br><small>{{ $t->pengguna->email }}</small></td>
                        <td>{{ $t->judul }}</td>
                        <td>{{ $t->kategori->nama }}</td>
                        <td>
                            @if($t->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @if($t->artikel_id)
                                    <br><span class="badge bg-primary mt-1"><i class="fas fa-edit"></i> Revisi Baru</span>
                                @endif
                            @elseif($t->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                                @if($t->pesan_revisi)
                                    <br><span class="badge bg-info text-dark mt-1"><i class="fas fa-exclamation-circle"></i> Request Edit</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.penggunatulisan.show', $t->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Review
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "order": [[ 4, "desc" ]], // Urutkan berdasarkan kolom tanggal secara descending
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });

        // Filter tabs logic
        $('#tulisanTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var filter = $(e.target).data('filter');
            if (filter) {
                // Kolom Status (kolom indeks ke-4)
                table.column(4).search(filter).draw();
            } else {
                table.column(4).search('').draw();
            }
        });
    });
</script>
@endpush
