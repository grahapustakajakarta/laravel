@extends('admin.layouts.app')

@section('title', 'Edit Penulis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Penulis</h2>
    <a href="{{ route('admin.penulis.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.penulis.update', $penulis->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Penulis <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $penulis->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Foto Profil</label>
                @if($penulis->foto_profil)
                    <div class="mb-2">
                        <img src="{{ asset('storage/penulis/' . $penulis->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%;">
                    </div>
                @endif
                <input type="file" name="foto_profil" class="form-control @error('foto_profil') is-invalid @enderror" accept="image/*">
                @error('foto_profil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, WEBP. Maks: 2MB.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Biografi</label>
                <textarea name="biografi" id="penulisBio" class="form-control @error('biografi') is-invalid @enderror" rows="4">{{ old('biografi', $penulis->biografi) }}</textarea>
                <div class="text-end text-muted mt-1" style="font-size: 0.85rem;">
                        <div class="text-right mt-1"><small class="text-muted">Kata: <span id="wordCount">0</span> / 35</small></div>
                </div>
                @error('biografi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Penulis</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('penulisBio');
    const wordCountSpan = document.getElementById('wordCount');
    
    if (bioTextarea) {
        function countWords(str) {
            str = str.replace(/(^\s*)|(\s*$)/gi,"");
            str = str.replace(/[ ]{2,}/gi," ");
            str = str.replace(/\n /,"\n");
            if (str.length === 0) return 0;
            return str.split(' ').length;
        }

        function updateWordCount(e) {
            let words = countWords(bioTextarea.value);
            
            if (words > 35) {
                let strArr = bioTextarea.value.trim().split(/\s+/);
                bioTextarea.value = strArr.slice(0, 35).join(' ');
                words = 35;
                if (e && e.type === 'keydown' && e.key !== 'Backspace' && e.key !== 'Delete') {
                    e.preventDefault();
                }
            }
            
            wordCountSpan.innerText = words;
            if (words >= 35) {
                wordCountSpan.classList.add('text-danger');
            } else {
                wordCountSpan.classList.remove('text-danger');
            }
        }
        
        bioTextarea.addEventListener('input', updateWordCount);
        bioTextarea.addEventListener('keydown', updateWordCount);
        updateWordCount();
    }
});
</script>
@endpush
