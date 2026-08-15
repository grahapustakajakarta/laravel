@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Manajemen Artikel</h2>
    <div>
        <form id="bulkDeleteForm" action="{{ route('admin.artikel.bulkDestroy') }}" method="POST" class="d-inline" style="display: none;">
            @csrf
            <input type="hidden" name="ids" id="bulkDeleteIds">
            <button type="button" id="btnBulkDelete" class="btn btn-danger me-2"><i class="fas fa-trash-alt"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)</button>
        </form>
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tulis Artikel</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover datatable w-100">
            <thead>
                <tr>
                    <th width="3%"><input type="checkbox" id="selectAll"></th>
                    <th width="5%">No</th>
                    <th width="35%">Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Jenis</th>
                    <th>Tgl Publikasi</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($artikel as $index => $item)
                <tr>
                    <td><input type="checkbox" class="select-item" value="{{ $item->id }}"></td>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->judul }}</strong> @if(isset($item->status) && $item->status === 'draft') <span class="badge bg-secondary ms-1">Draft</span> @endif</td>
                    <td><span class="badge bg-dark">{{ $item->kategori->nama ?? '-' }}</span></td>
                    <td>{{ $item->penulis->nama ?? '-' }}</td>
                    <td><span class="badge {{ $item->jenis_artikel == 'premium' ? 'bg-warning text-dark' : 'bg-success' }}">{{ ucfirst($item->jenis_artikel) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.artikel.edit', $item->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.artikel.destroy', $item->id) }}" method="POST" class="d-inline">
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

@push('scripts')
<script>
$(document).ready(function() {
    let selectedIds = new Set();
    
    // Listen to changes on the table specifically for DataTables pagination
    $('.datatable').on('change', '.select-item', function() {
        if(this.checked) {
            selectedIds.add(this.value);
        } else {
            selectedIds.delete(this.value);
            $('#selectAll').prop('checked', false);
        }
        updateBulkButton();
    });

    $('#selectAll').on('change', function() {
        let isChecked = this.checked;
        $('.select-item').each(function() {
            this.checked = isChecked;
            if(isChecked) {
                selectedIds.add(this.value);
            } else {
                selectedIds.delete(this.value);
            }
        });
        updateBulkButton();
    });

    function updateBulkButton() {
        let count = selectedIds.size;
        if(count > 0) {
            $('#bulkDeleteForm').show();
            $('#bulkDeleteCount').text(count);
        } else {
            $('#bulkDeleteForm').hide();
        }
    }

    $('#btnBulkDelete').on('click', function() {
        if(confirm('Apakah Anda yakin ingin menghapus ' + selectedIds.size + ' artikel terpilih?')) {
            $('#bulkDeleteIds').val(Array.from(selectedIds).join(','));
            $('#bulkDeleteForm').submit();
        }
    });
});
</script>
@endpush
