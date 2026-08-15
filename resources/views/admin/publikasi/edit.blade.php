@extends('admin.layouts.app')

@section('title', 'Edit Publikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Publikasi</h2>
    <a href="{{ route('admin.publikasi.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 750px;">
    <div class="card-body">
        <form action="{{ route('admin.publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Publikasi <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $publikasi->judul) }}" required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                <input type="text" name="kategori" list="kategoriList" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $publikasi->kategori) }}" required>
                <datalist id="kategoriList">
                    @foreach($kategoris as $k)
                        <option value="{{ $k }}">
                    @endforeach
                </datalist>
                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti File PDF <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror" accept=".pdf">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                        @error('file_pdf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="mt-2">
                            <a href="{{ asset('pdf/' . $publikasi->file_pdf) }}" target="_blank" class="text-primary text-decoration-none" style="font-size:0.85rem;">
                                <i class="fas fa-file-pdf me-1"></i>Lihat PDF Saat Ini
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Gambar Cover <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="cover_gambar" class="form-control @error('cover_gambar') is-invalid @enderror" accept="image/*" id="coverInput">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                        @error('cover_gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @if($publikasi->cover_gambar)
                        <div id="coverPreview">
                            <img id="previewImg" src="{{ asset('img/' . $publikasi->cover_gambar) }}" style="max-width:100px; border-radius:8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="cover">
                        </div>
                    @else
                        <div id="coverPreview" class="d-none">
                            <img id="previewImg" src="" style="max-width:100px; border-radius:8px;" alt="preview">
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" name="action" value="draft" class="btn btn-outline-secondary px-4"><i class="fas fa-save me-1"></i> Simpan sebagai Draft</button>
            <button type="submit" name="action" value="publish" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-1"></i> Perbarui & Publikasikan</button>
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
