@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
<style>
/* ── Type Picker ─────────────────────────────────── */
.tipe-picker { display: flex; gap: 20px; margin-bottom: 32px; }
.tipe-card {
    flex: 1; border: 2px solid #e0e0e0; border-radius: 14px;
    padding: 28px 24px; cursor: pointer; transition: all .2s;
    background: #fff; text-align: center; position: relative; overflow: hidden;
}
.tipe-card:hover { border-color: #b70d0f; box-shadow: 0 4px 20px rgba(183,13,15,.1); transform: translateY(-2px); }
.tipe-card.active { border-color: #b70d0f; background: #fff8f8; box-shadow: 0 4px 20px rgba(183,13,15,.15); }
.tipe-card .check-badge {
    display: none; position: absolute; top: 12px; right: 12px;
    background: #b70d0f; color: #fff; border-radius: 50%;
    width: 24px; height: 24px; align-items: center; justify-content: center; font-size: 12px;
}
.tipe-card.active .check-badge { display: flex; }
.tipe-icon { font-size: 2.5rem; margin-bottom: 10px; }
.tipe-title { font-size: 1.1rem; font-weight: 700; color: #222; margin-bottom: 4px; }
.tipe-desc { font-size: 12.5px; color: #777; line-height: 1.4; }

/* ── Model Picker ────────────────────────────────── */
.model-picker { display: flex; gap: 12px; margin-bottom: 16px; }
.model-card {
    flex: 1; border: 2px solid #e0e0e0; border-radius: 10px;
    padding: 14px 16px; cursor: pointer; transition: all .2s;
    background: #fff; text-align: center;
}
.model-card:hover { border-color: #0d6efd; }
.model-card.active { border-color: #0d6efd; background: #f0f5ff; }
.model-card .model-title { font-weight: 700; font-size: 14px; color: #333; }
.model-card .model-desc { font-size: 11.5px; color: #888; margin-top: 2px; }

/* ── Puisi editor ─────────────────────────────────── */
#konten-puisi-ta {
    font-family: 'EB Garamond', Garamond, Georgia, serif;
    font-size: 17px; line-height: 1.4; resize: vertical; width: 100%;
}
.puisi-guide {
    background: #fffbeb; border-left: 4px solid #f59e0b;
    border-radius: 0 8px 8px 0; padding: 10px 14px;
    font-size: 12.5px; margin-bottom: 10px;
    display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
}
.puisi-guide .kbd {
    background: #e9ecef; border: 1px solid #ccc; border-radius: 3px;
    padding: 1px 7px; font-family: monospace; font-size: 12px;
}
.line-count { font-size: 12px; color: #999; text-align: right; margin-top: 4px; }

/* ── Preview iframe wrap ────────────────────────── */
.btn-preview-real {
    background-color: #5bc0de;
    color: white;
    border: none;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-preview-real:hover { background-color: #46b8da; color: white; transform: translateY(-1px); }
.preview-wrap {
    border: 1px solid #e0e0e0; border-radius: 10px;
    overflow: hidden; background: #f5f5f5;
    margin-top: 16px;
}
.preview-header-bar {
    background: #f0f0f0; border-bottom: 1px solid #e0e0e0;
    padding: 10px 16px; font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: #666;
    display: flex; align-items: center; gap: 8px;
}
.preview-header-bar .dot { width: 10px; height: 10px; border-radius: 50%; background: #e0e0e0; }
.preview-header-bar .dot.red { background: #ff5f56; }
.preview-header-bar .dot.yellow { background: #ffbd2e; }
.preview-header-bar .dot.green { background: #27c93f; }
.preview-iframe {
    width: 100%; border: none; display: block;
    min-height: 600px; background: #fff;
}

#section-form { display: none; }
@if($errors->any() || old('layout'))
#section-form { display: block; }
@endif
@media (max-width: 768px) { .tipe-picker, .model-picker { flex-direction: column; } }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Tambah Artikel</h2>
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

{{-- Step 1: Pilih Kategori --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <p class="fw-bold mb-3" style="font-size:13px;color:#888;letter-spacing:.8px;text-transform:uppercase;">Langkah 1 — Pilih Kategori Artikel</p>
        <select id="master-kategori" class="form-select form-select-lg" onchange="onMasterCategoryChange(this.value)">
            <option value="">-- Silakan Pilih Kategori Dulu --</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" data-nama="{{ strtolower($k->nama) }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

<div id="section-form">

    {{-- ══ FORM PUISI ══ --}}
    <div id="form-puisi" style="display:none;">
        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" id="form-puisi-el">
            @csrf
            <input type="hidden" name="layout" value="artikel3" id="puisi-layout-input">

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="color:#b70d0f;font-size:12px;letter-spacing:1px;text-transform:uppercase;">📜 Konten Puisi — Layout Artikel3 (terkunci)</h6>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="puisi-judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required placeholder="Judul puisi...">
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold">Isi Puisi <span class="text-danger">*</span></label>
                                <textarea name="konten" id="summernote-puisi" class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                                @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#666;">⚙️ Detail Publikasi</h6>

                            <div class="alert alert-secondary py-2 mb-3" style="font-size:12px;">
                                <i class="fas fa-lock me-1"></i> Layout: <strong>Puisi / Sajak (artikel3)</strong>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Penulis</label>
                                <select name="penulis_id" id="puisi-penulis" class="form-select @error('penulis_id') is-invalid @enderror">
                                    <option value="">Pilih Penulis</option>
                                    @foreach($penulis as $p)
                                        <option value="{{ $p->id }}" {{ old('penulis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ketik Penulis Manual</label>
                                <input type="text" name="penulis_manual" class="form-control" placeholder="Nama penulis manual" value="{{ old('penulis_manual') }}">
                                <small class="text-muted">Isi jika penulis tidak ada di daftar pilihan atas.</small>
                            </div>

                            <input type="hidden" name="kategori_id" id="puisi-kategori-hidden" value="">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Artikel <span class="text-danger">*</span></label>
                                <select name="jenis_artikel" class="form-select" required>
                                    <option value="free">Free</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tgl Publikasi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_publikasi" id="puisi-tanggal" class="form-control" value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sponsor (Opsional)</label>
                                <input type="text" name="sponsor" class="form-control" value="{{ old('sponsor') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload Gambar Cover</label>
                                <div id="gambar-container-puisi"></div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-lg"><i class="fas fa-save me-1"></i> Simpan Draft</button>
                                <button type="submit" name="action" value="publish" class="btn btn-danger btn-lg"><i class="fas fa-paper-plane me-1"></i> Terbitkan Puisi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-2">
                <button type="button" class="btn btn-preview-real btn-lg w-100 py-3" onclick="loadRealPreview('puisi')">
                    <i class="fas fa-desktop me-2"></i> Simulasi Pratinjau Tampilan Web (Live Preview)
                </button>
            </div>
        </form>
    </div>

    {{-- ══ FORM ARTIKEL BIASA ══ --}}
    <div id="form-artikel" style="display:none;">
        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" id="form-artikel-el">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="color:#0d6efd;font-size:12px;letter-spacing:1px;text-transform:uppercase;">📰 Pilih Model Layout</h6>

                            <div class="model-picker">
                                <div class="model-card active" id="model-card-1" onclick="selectModel('artikel1')">
                                    <div class="model-title">📄 Model 1 — Standar</div>
                                    <div class="model-desc">Artikel berita / opini / esai</div>
                                </div>
                                <div class="model-card" id="model-card-2" onclick="selectModel('artikel2')">
                                    <div class="model-title">📖 Model 2 – Layout Khusus</div>
                                    <div class="model-desc">Artikel dengan tampilan layout spesial</div>
                                </div>
                                <div class="model-card" id="model-card-4" onclick="selectModel('artikel4')">
                                    <div class="model-title">📚 Model 4 – Buku & Inspirasi</div>
                                    <div class="model-desc">Gambar besar kiri, teks kanan. Khusus: Buku & Inspirasi</div>
                                </div>
                            </div>
                            <div id="prosa-model-notice" class="alert alert-info py-2 mb-2" style="font-size:12px; display:none;">
                                <i class="fas fa-info-circle me-1"></i> Kategori <strong>Prosa</strong> hanya menggunakan <strong>Model 1</strong> atau <strong>Model 2</strong>.
                            </div>
                            <div id="buku-model-notice" class="alert alert-warning py-2 mb-2" style="font-size:12px; display:none;">
                                <i class="fas fa-lock me-1"></i> Kategori <strong>Buku / Inspirasi</strong> hanya menggunakan <strong>Model 4</strong>.
                            </div>
                            <input type="hidden" name="layout" id="layout-hidden" value="{{ old('layout', 'artikel1') }}">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="artikel-judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sinopsis</label>
                                <textarea name="sinopsis" id="artikel-sinopsis" class="form-control" rows="2">{{ old('sinopsis') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Konten Artikel <span class="text-danger">*</span></label>
                                <textarea name="konten" id="summernote" class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                                @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#666;">⚙️ Detail Publikasi</h6>

                            <input type="hidden" name="kategori_id" id="kategori_id_final" value="{{ old('kategori_id') }}" required>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Artikel <span class="text-danger">*</span></label>
                                <select name="jenis_artikel" class="form-select" required>
                                    <option value="free">Free</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Penulis</label>
                                <select name="penulis_id" id="artikel-penulis" class="form-select @error('penulis_id') is-invalid @enderror">
                                    <option value="">Pilih Penulis</option>
                                    @foreach($penulis as $p)
                                        <option value="{{ $p->id }}" {{ old('penulis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ketik Penulis Manual</label>
                                <input type="text" name="penulis_manual" class="form-control" placeholder="Nama penulis manual" value="{{ old('penulis_manual') }}">
                                <small class="text-muted">Isi jika penulis tidak ada di daftar pilihan atas.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tgl Publikasi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_publikasi" id="artikel-tanggal" class="form-control" value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sponsor (Opsional)</label>
                                <input type="text" name="sponsor" class="form-control" value="{{ old('sponsor') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload Gambar</label>
                                <div id="gambar-container-artikel"></div>
                                <button type="button" class="btn btn-sm btn-outline-dark w-100 mt-2" id="btn-add-gambar">
                                    <i class="fas fa-plus me-1"></i> Tambah Gambar Lagi
                                </button>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-lg"><i class="fas fa-save me-1"></i> Simpan Draft</button>
                                <button type="submit" name="action" value="publish" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane me-1"></i> Terbitkan Artikel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="button" class="btn btn-preview-real btn-lg w-100 py-3" onclick="loadRealPreview('artikel')">
                    <i class="fas fa-desktop me-2"></i> Simulasi Pratinjau Tampilan Web (Live Preview)
                </button>
            </div>
        </form>
    </div>

    {{-- Form tersembunyi untuk submit data ke iframe preview --}}
    <form id="preview-form" action="{{ route('admin.artikel.live_preview') }}" method="POST" target="preview-iframe-box" style="display:none;">
        @csrf
        <input type="hidden" name="judul" id="preview-judul">
        <input type="hidden" name="konten" id="preview-konten">
        <input type="hidden" name="layout" id="preview-layout">
        <input type="hidden" name="penulis_id" id="preview-penulis">
        <input type="hidden" name="kategori_id" id="preview-kategori">
        <input type="hidden" name="tanggal_publikasi" id="preview-tanggal">
    </form>

    {{-- Kotak Preview Iframe Asli --}}
    <div id="real-preview-container" style="display:none;" class="mt-5">
        <div class="preview-wrap">
            <div class="preview-header-bar">
                <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                <span style="margin-left:8px;" id="preview-title-text"><i class="fas fa-globe me-1"></i> Pratinjau Asli Website</span>
            </div>
            <iframe name="preview-iframe-box" id="preview-iframe-box" class="preview-iframe"></iframe>
        </div>
    </div>

</div>{{-- end #section-form --}}

@include('admin.artikel.partials.crop-modal')

@endsection

@push('scripts')
<script>
/* ─── Tipe Picker ─────────────────────────────────── */
function selectTipe(tipe) {
    document.getElementById('section-form').style.display = 'block';

    // Reset iframe container
    document.getElementById('real-preview-container').style.display = 'none';

    if (tipe === 'puisi') {
        document.getElementById('form-puisi').style.display = 'block';
        document.getElementById('form-artikel').style.display = 'none';
    } else {
        document.getElementById('form-artikel').style.display = 'block';
        document.getElementById('form-puisi').style.display = 'none';
    }

    if ($('#summernote').next('.note-editor').length === 0 || $('#summernote-puisi').next('.note-editor').length === 0) {
        initSummernote();
    }

    setTimeout(function() {
        document.getElementById('section-form').scrollIntoView({ behavior: 'smooth' });
    }, 100);
}

/* ─── Model Picker ────────────────────────────────── */
function selectModel(val) {
    document.getElementById('layout-hidden').value = val;
    var c1 = document.getElementById('model-card-1');
    var c2 = document.getElementById('model-card-2');
    var c4 = document.getElementById('model-card-4');
    
    if(c1) c1.classList.toggle('active', val === 'artikel1');
    if(c2) c2.classList.toggle('active', val === 'artikel2');
    if(c4) c4.classList.toggle('active', val === 'artikel4');

    refreshArtikelCropContainer();
}

/* ─── Master Category Change ──────────────────────── */
function onMasterCategoryChange(val) {
    var sel = document.getElementById('master-kategori');
    var selectedOption = sel.options[sel.selectedIndex];
    var nama = selectedOption ? (selectedOption.dataset.nama || '') : '';

    if (!val) {
        document.getElementById('section-form').style.display = 'none';
        return;
    }

    var isPuisi = (nama === 'puisi');
    var isBukuInspirasi = (nama === 'buku' || nama === 'inspirasi');
    
    if (isPuisi) {
        selectTipe('puisi');
        document.getElementById('puisi-kategori-hidden').value = val;
    } else {
        selectTipe('artikel');
        document.getElementById('kategori_id_final').value = val;

        var card1  = document.getElementById('model-card-1');
        var card2  = document.getElementById('model-card-2');
        var card4  = document.getElementById('model-card-4');
        var prosaN = document.getElementById('prosa-model-notice');
        var bukuN  = document.getElementById('buku-model-notice');

        if (prosaN) prosaN.style.display = 'none';
        if (bukuN)  bukuN.style.display  = 'none';

        if (isBukuInspirasi) {
            if (card1) card1.style.display = 'none';
            if (card2) card2.style.display = 'none';
            if (card4) card4.style.display = 'block';
            if (bukuN) bukuN.style.display = 'block';
            selectModel('artikel4');
        } else {
            if (card1) card1.style.display = 'block';
            if (card2) card2.style.display = 'block';
            if (card4) card4.style.display = 'none';
            if (nama === 'prosa' && prosaN) prosaN.style.display = 'block';
            
            var layoutNow = document.getElementById('layout-hidden').value;
            if (layoutNow === 'artikel4' || !layoutNow) {
                selectModel('artikel1');
            }
        }
    }
}


/* ==================== Summernote ==================== */
function initSummernote() {
    var config = {
        height: 400,
        tabsize: 4,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    };
    $('#summernote').summernote(config);
    $('#summernote-puisi').summernote(config);
}

/* ─── Load Real Preview via POST Iframe ───────────── */
function loadRealPreview(tipe) {
    var formObj = document.getElementById(tipe === 'puisi' ? 'form-puisi-el' : 'form-artikel-el');
    
    // Jika tipe puisi, proses text areanya dulu ke hidden input
    if (tipe === 'puisi') {
        var rawText = document.getElementById('konten-puisi-ta').value;
        var processed = rawText.split('\n').map(function(line) {
            return /^#\s*(.+)/.test(line) ? '<strong>' + line.replace(/^#\s*/, '') + '</strong>' : line;
        }).join('<br />\n');
        document.getElementById('konten-puisi-hidden').value = processed || '<p>Konten kosong...</p>';
    } else {
        document.getElementById('summernote').value = $('#summernote').summernote('code');
    }

    // Tampilkan wrapper iframe
    var container = document.getElementById('real-preview-container');
    container.style.display = 'block';
    
    // Siapkan FormData
    var formData = new FormData(formObj);
    
    // Kirim data via AJAX fetch
    fetch("{{ route('admin.artikel.live_preview') }}", {
        method: "POST",
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        var iframe = document.getElementById('preview-iframe-box');
        iframe.srcdoc = html;
        
        setTimeout(function() {
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    })
    .catch(error => {
        console.error('Preview error:', error);
        alert('Terjadi kesalahan saat memuat preview. Silakan coba lagi.');
    });
}

/* ─── Refresh crop container artikel ─────────────── */
function refreshArtikelCropContainer() {
    var container = document.getElementById('gambar-container-artikel');
    if (!container) return;
    
    // Selalu reset container karena layout (dan rasio crop) berubah
    container.innerHTML = '';
    container.appendChild(createCropRow(true)); // gambar pertama = layout utama
}

/* ─── Init ────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {

    // Init baris gambar pertama — Puisi (layout artikel3 = 4:3)
    var puisiContainer = document.getElementById('gambar-container-puisi');
    if (puisiContainer) {
        // Override layout sementara ke artikel3 agar rasio 4:3
        var hidEl = document.getElementById('layout-hidden');
        var origVal = hidEl ? hidEl.value : 'artikel1';
        if (hidEl) hidEl.value = 'artikel3';
        puisiContainer.appendChild(createCropRow(false));
        if (hidEl) hidEl.value = origVal;
    }

    // Init baris gambar pertama — Artikel
    var artContainer = document.getElementById('gambar-container-artikel');
    if (artContainer) {
        artContainer.appendChild(createCropRow(true));
    }

    // Tambah gambar (extra)
    var btnAdd = document.getElementById('btn-add-gambar');
    if (btnAdd) {
        btnAdd.addEventListener('click', function() {
            var container = document.getElementById('gambar-container-artikel');
            var layout    = getCurrentLayout();
            // Gambar ekstra di artikel4 menggunakan rasio portrait 1000x1500
            var ratioKey  = (layout === 'artikel4') ? 'artikel4extra' : layout;
            container.appendChild(createCropRow(false, ratioKey));
        });
    }
});
</script>
@endpush
