@extends('admin.layouts.app')

@section('title', 'Edit MAGZ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit MAGZ</h2>
    <a href="{{ route('admin.magz.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card shadow-sm" style="max-width: 750px;">
    <div class="card-body">
        <form action="{{ route('admin.magz.update', $magz->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul MAGZ <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $magz->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Penulis</label>
                    <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $magz->penulis) }}" placeholder="Opsional...">
                    @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Edisi</label>
                    <input type="text" name="edisi" class="form-control @error('edisi') is-invalid @enderror" value="{{ old('edisi', $magz->edisi) }}" placeholder="Contoh: Spring 2026">
                    @error('edisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="kategori" list="kategoriList" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $magz->kategori) }}" required>
                        <datalist id="kategoriList">
                            @foreach($kategoris as $k)
                                <option value="{{ $k }}">
                            @endforeach
                        </datalist>
                    </div>
                    @error('kategori') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Harga <span class="text-muted">(0 = Gratis)</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $magz->harga) }}" min="0" placeholder="0">
                    </div>
                    @error('harga') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Singkat (Tampil di Halaman Beli)</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $magz->deskripsi) }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Isi Preview (HTML diizinkan)</label>
                <textarea name="isi_preview" class="form-control @error('isi_preview') is-invalid @enderror" rows="6" placeholder="<p>Isi utama untuk halaman preview...</p>">{{ old('isi_preview', $magz->isi_preview) }}</textarea>
                <small class="text-muted">Masukkan format paragraf yang akan tampil di halaman Preview.</small>
                @error('isi_preview') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="card mb-3 border-secondary">
                <div class="card-header bg-secondary text-white fw-bold">
                    Table of Contents (Daftar Isi)
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Tulis judul-judul karya per baris (Enter). Tidak perlu kode HTML.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fiksi</label>
                            <textarea name="table_of_contents[fiksi]" class="form-control" rows="4" placeholder="Misal:&#10;Ingeborg Bachmann - The Welder&#10;Yu Hua - Sleeper Bus">{{ old('table_of_contents.fiksi', is_array($magz->table_of_contents) ? ($magz->table_of_contents['fiksi'] ?? '') : '') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Interview</label>
                            <textarea name="table_of_contents[interview]" class="form-control" rows="4" placeholder="Misal:&#10;Darryl Pinckney - The Art of Nonfiction No. 15">{{ old('table_of_contents.interview', is_array($magz->table_of_contents) ? ($magz->table_of_contents['interview'] ?? '') : '') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sajak & Puisi</label>
                            <textarea name="table_of_contents[puisi]" class="form-control" rows="4" placeholder="Misal:&#10;Nakahara Chuya - Early Summer">{{ old('table_of_contents.puisi', is_array($magz->table_of_contents) ? ($magz->table_of_contents['puisi'] ?? '') : '') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Essai</label>
                            <textarea name="table_of_contents[essai]" class="form-control" rows="4" placeholder="Judul essai...">{{ old('table_of_contents.essai', is_array($magz->table_of_contents) ? ($magz->table_of_contents['essai'] ?? '') : '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti File PDF <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror" accept=".pdf">
                        <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah file PDF saat ini.</small>
                        <a href="{{ asset('pdf/' . $magz->file_pdf) }}" target="_blank" class="text-primary text-decoration-none" style="font-size:0.85rem;"><i class="fas fa-external-link-alt me-1"></i>Lihat PDF Saat Ini</a>
                        @error('file_pdf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Gambar Cover <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="cover_gambar" class="form-control @error('cover_gambar') is-invalid @enderror" accept="image/*" id="coverInput">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                        @error('cover_gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div id="coverPreview" class="mt-2 {{ $magz->cover_gambar ? '' : 'd-none' }}">
                        <img id="previewImg" src="{{ $magz->cover_gambar ? asset('img/' . $magz->cover_gambar) : '' }}" style="max-width:120px; border-radius:8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" alt="preview">
                    </div>
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
