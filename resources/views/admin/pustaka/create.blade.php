@extends('admin.layouts.app')

@section('title', 'Tambah Buku Pustaka')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Tambah Buku</h2>
    <a href="{{ route('admin.pustaka.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.pustaka.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Utama</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Buku Baru" {{ old('kategori') == 'Buku Baru' ? 'selected' : '' }}>Buku Baru</option>
                        <option value="Akan Terbit" {{ old('kategori') == 'Akan Terbit' ? 'selected' : '' }}>Akan Terbit</option>
                        <option value="Terlaris" {{ old('kategori') == 'Terlaris' ? 'selected' : '' }}>Terlaris</option>
                        <option value="Koleksi" {{ old('kategori') == 'Koleksi' ? 'selected' : '' }}>Koleksi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" placeholder="200000">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tipe Buku</label>
                    <input type="text" name="tipe_buku" class="form-control" value="{{ old('tipe_buku', 'A Novel') }}" placeholder="Contoh: A Novel">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Penulis</label>
                    <select name="penulis_id" class="form-select">
                        <option value="">-- Pilih Penulis (Opsional) --</option>
                        @foreach($penulis as $p)
                            <option value="{{ $p->id }}" {{ old('penulis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Ketik Penulis Manual</label>
                    <input type="text" name="penulis_manual" class="form-control" placeholder="Nama penulis manual" value="{{ old('penulis_manual') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end pb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_on_tour" name="is_on_tour" value="1" {{ old('is_on_tour') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_on_tour">Tandai sebagai "On Tour"</label>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Spesifikasi (Accordion)</h5>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Bahasa</label>
                    <select name="bahasa" class="form-select">
                        <option value="Indonesia" {{ old('bahasa', 'Indonesia') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                        <option value="Inggris" {{ old('bahasa') == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                        <option value="Bilingual" {{ old('bahasa') == 'Bilingual' ? 'selected' : '' }}>Bilingual</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Halaman</label>
                    <div class="input-group">
                        <input type="number" name="halaman" class="form-control" value="{{ old('halaman') }}" placeholder="304">
                        <span class="input-group-text">hlm</span>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Format Buku</label>
                    <input type="text" name="format_buku" class="form-control" value="{{ old('format_buku', 'Soft Cover') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Ukuran</label>
                    <div class="input-group">
                        <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran') }}" placeholder="18 x 21">
                        <span class="input-group-text">cm</span>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Berat</label>
                    <div class="input-group">
                        <input type="number" name="berat" class="form-control" value="{{ old('berat') }}" placeholder="300">
                        <span class="input-group-text">gram</span>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Konten Teks</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Buku</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Ulasan Singkat</label>
                <textarea name="ulasan" class="form-control" rows="3">{{ old('ulasan') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Tentang Pengarang (Opsional)</label>
                <textarea name="tentang_pengarang" class="form-control" rows="3">{{ old('tentang_pengarang') }}</textarea>
                <small class="text-muted">Akan menimpa profil Penulis bawaan jika diisi.</small>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Link & Ketersediaan</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Vidio Produk</label>
                    <input type="text" name="link_vidio_produk" class="form-control" value="{{ old('link_vidio_produk') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Read Sample</label>
                    <input type="text" name="link_read_sample" class="form-control" value="{{ old('link_read_sample') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Nomor WhatsApp</label>
                    <input type="text" name="nomor_wa" class="form-control" value="{{ old('nomor_wa') }}" placeholder="Cth: 08123456789">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Tokopedia</label>
                    <input type="text" name="link_tokopedia" class="form-control" value="{{ old('link_tokopedia') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Shopee</label>
                    <input type="text" name="link_shopee" class="form-control" value="{{ old('link_shopee') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Instagram</label>
                    <input type="text" name="link_instagram" class="form-control" value="{{ old('link_instagram') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Tiktok</label>
                    <input type="text" name="link_tiktok" class="form-control" value="{{ old('link_tiktok') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Coffeesophia</label>
                    <input type="text" name="link_coffeesophia" class="form-control" value="{{ old('link_coffeesophia') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Togamas</label>
                    <input type="text" name="link_togamas" class="form-control" value="{{ old('link_togamas') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Ebook</label>
                    <input type="text" name="link_ebook" class="form-control" value="{{ old('link_ebook') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Link Toko Lainnya</label>
                    <input type="text" name="link_lainnya" class="form-control" value="{{ old('link_lainnya') }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Gambar Slide</h5>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Gambar Slide 1 <span class="text-muted">(Opsional)</span></label>
                    <input type="file" name="gambar_1" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Gambar Slide 2 <span class="text-muted">(Opsional)</span></label>
                    <input type="file" name="gambar_2" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Gambar Slide 3 <span class="text-muted">(Opsional)</span></label>
                    <input type="file" name="gambar_3" class="form-control" accept="image/*">
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">File PDF Pustaka</h5>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Unggah PDF <span class="text-muted">(Untuk Pembelian)</span></label>
                    <input type="file" name="file_pdf" class="form-control" accept="application/pdf">
                </div>
            </div>
            <div class="text-end">
                <button type="submit" name="action" value="draft" class="btn btn-outline-secondary px-4"><i class="fas fa-save me-1"></i> Simpan Draft</button>
                <button type="submit" name="action" value="publish" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-1"></i> Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection
