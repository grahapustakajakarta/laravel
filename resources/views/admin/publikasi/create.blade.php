@extends('admin.layouts.app')

@section('title', 'Tambah Publikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Tambah Publikasi</h2>
    <a href="{{ route('admin.publikasi.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 750px;">
    <div class="card-body">
        <form action="{{ route('admin.publikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Publikasi <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required placeholder="Contoh: Laporan Tahunan Galeri Buku Jakarta 2024">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" name="kategori" list="kategoriList" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" required placeholder="Ketik atau pilih kategori...">
                    <datalist id="kategoriList">
                        @foreach($kategoris as $k)
                            <option value="{{ $k }}">
                        @endforeach
                    </datalist>
                </div>
                <small class="text-muted">Bisa mengetik kategori baru atau memilih yang sudah ada.</small>
                @error('kategori') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Ringkasan isi publikasi...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">File PDF <span class="text-danger">*</span></label>
                        <input type="file" name="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror" accept=".pdf" required>
                        <small class="text-muted">Format: PDF. Maks: 20 MB.</small>
                        @error('file_pdf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Cover <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="cover_gambar" class="form-control @error('cover_gambar') is-invalid @enderror" accept="image/*" id="coverInput">
                        <small class="text-muted">JPG/PNG/WEBP. Maks: 2 MB.</small>
                        @error('cover_gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div id="coverPreview" class="mt-2 d-none">
                        <img id="previewImg" src="" style="max-width:120px; border-radius:8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="preview">
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" name="action" value="draft" class="btn btn-outline-secondary px-4"><i class="fas fa-save me-1"></i> Simpan Draft</button>
            <button type="submit" name="action" value="publish" class="btn btn-primary px-4"><i class="fas fa-cloud-arrow-up me-1"></i> Simpan Publikasi</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('coverInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('previewImg').src = ev.target.result;
                document.getElementById('coverPreview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
