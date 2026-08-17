@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Artikel</h2>
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" id="form-edit-artikel">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $artikel->judul) }}" required>
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sinopsis</label>
                        <textarea name="sinopsis" class="form-control" rows="3">{{ old('sinopsis', $artikel->sinopsis) }}</textarea>
                    </div>

                    <div class="mb-3" id="wrapper-summernote">
                        <label class="form-label fw-bold">Konten Artikel <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="konten" class="form-control @error('konten') is-invalid @enderror">{{ old('konten', $artikel->konten) }}</textarea>
                        @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <input type="hidden" name="konten" id="final-konten" value="">
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" id="edit-kategori-select" class="form-select @error('kategori_id') is-invalid @enderror" onchange="onEditKategoriChange(this)" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" data-nama="{{ strtolower($k->nama) }}" {{ old('kategori_id', $artikel->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Layout Tampilan <span class="text-danger">*</span></label>
                        <select name="layout" id="edit-layout-select" class="form-select @error('layout') is-invalid @enderror" required>
                            <!-- Options akan diisi oleh Javascript berdasarkan Kategori -->
                        </select>
                        <small class="text-muted" id="edit-layout-crop-hint" style="font-size:11px;"></small>
                        
                        <div id="edit-prosa-notice" class="alert alert-info py-2 mt-2" style="font-size:12px; display:none;">
                            <i class="fas fa-info-circle me-1"></i> Artikel <strong>Prosa</strong> hanya menggunakan Layout Standar (Model 1) atau Layout Khusus (Model 2).
                        </div>
                        <div id="edit-buku-notice" class="alert alert-warning py-2 mt-2" style="font-size:12px; display:none;">
                            <i class="fas fa-lock me-1"></i> Kategori <strong>Buku / Inspirasi</strong> hanya menggunakan Layout Buku & Inspirasi (Model 4).
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Artikel <span class="text-danger">*</span></label>
                        <select name="jenis_artikel" class="form-select @error('jenis_artikel') is-invalid @enderror" required>
                            <option value="free" {{ old('jenis_artikel', $artikel->jenis_artikel) == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="premium" {{ old('jenis_artikel', $artikel->jenis_artikel) == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penulis</label>
                        <select name="penulis_id" class="form-select @error('penulis_id') is-invalid @enderror">
                            <option value="">Pilih Penulis</option>
                            @foreach($penulis as $p)
                                <option value="{{ $p->id }}" {{ old('penulis_id', $artikel->penulis_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ketik Penulis Manual</label>
                        <input type="text" name="penulis_manual" class="form-control" placeholder="Nama penulis manual" value="{{ old('penulis_manual', $artikel->penulis_manual) }}">
                        <small class="text-muted">Isi jika penulis tidak ada di daftar pilihan atas.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tgl Publikasi <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_publikasi" class="form-control" value="{{ old('tanggal_publikasi', \Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Bio Pendek Penulis (Opsional)</label>
                        <textarea name="sponsor" class="form-control" rows="3" placeholder="Isi jika ingin menampilkan bio singkat untuk penulis manual...">{{ old('sponsor', $artikel->sponsor) }}</textarea>
                    </div>

                    {{-- ── Gambar Saat Ini ── --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar Saat Ini</label>
                        @if($artikel->gambar->count() > 0)
                        <div class="row g-2 mb-3">
                            @foreach($artikel->gambar as $gbr)
                            <div class="col-6 position-relative gambar-row-crop" id="img-{{ $gbr->id }}">
                                <img id="preview-img-{{ $gbr->id }}" src="{{ asset('img/' . $gbr->file_gambar) }}" class="img-fluid rounded border mb-1" alt="Gambar" style="object-fit:cover; width:100%; aspect-ratio:{{ $artikel->layout === 'artikel4' ? '2/3' : ($artikel->layout === 'artikel3' ? '4/3' : '16/9') }};">
                                <input type="text" name="existing_deskripsi_gambar[{{ $gbr->id }}]" class="form-control form-control-sm mb-1" value="{{ old('existing_deskripsi_gambar.'.$gbr->id, $gbr->deskripsi) }}" placeholder="Deskripsi gambar">
                                
                                <button type="button" class="btn btn-sm btn-primary crop-trigger-btn w-100" data-row-id="img-{{ $gbr->id }}">
                                    <i class="fas fa-edit me-1"></i> Ganti Gambar
                                </button>
                                <input type="file" id="file-img-{{ $gbr->id }}" name="ganti_gambar[{{ $gbr->id }}]" class="crop-file-input d-none" accept="image/*">
                                
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-delete-gambar" data-id="{{ $gbr->id }}" title="Hapus Gambar"><i class="fas fa-trash-alt"></i></button>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted small"><i class="fas fa-image me-1"></i>Belum ada gambar.</p>
                        @endif

                        {{-- ── Tambah Gambar Baru dengan Crop ── --}}
                        <label class="form-label fw-bold">Tambah Gambar Baru</label>
                        <div id="gambar-container"></div>
                        <button type="button" class="btn btn-sm btn-outline-dark w-100 mt-2" id="btn-add-gambar">
                            <i class="fas fa-plus me-1"></i> Tambah Gambar Lagi
                        </button>
                    </div>

                    <div class="d-grid gap-2 mb-3 mt-4">
                        <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-lg"><i class="fas fa-save me-1"></i> Simpan sebagai Draft</button>
                        <button type="submit" name="action" value="publish" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane me-1"></i> Perbarui & Publikasikan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('admin.artikel.partials.crop-modal')

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
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
        });

        // Initialize dynamic layout options on page load
        var katSelect = document.getElementById('edit-kategori-select');
        if (katSelect) {
            onEditKategoriChange(katSelect, true);
        }

        // Update crop info saat layout berubah (manual trigger by user)
        document.getElementById('edit-layout-select').addEventListener('change', function() {
            var container = document.getElementById('gambar-container');
            if (container) container.innerHTML = ''; // reset field gambar baru jika ganti layout
            updateLayoutCropHint();
        });

        // Tambah gambar baru
        $('#btn-add-gambar').click(function() {
            var layout   = getCurrentLayout();
            var ratioKey = (layout === 'artikel4') ? 'artikel4extra' : layout;
            document.getElementById('gambar-container').appendChild(createCropRow(false, ratioKey));
        });

        $(document).on('click', '.btn-remove-gambar', function() {
            $(this).parent('.gambar-row').remove();
        });

        // AJAX Delete Gambar
        $(document).on('click', '.btn-delete-gambar', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Gambar?',
                text: "File fisik akan dihapus dari server selamanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e03a3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/artikel/gambar/${id}`,
                        type: 'POST',
                        data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                        success: function(res) {
                            if(res.success) {
                                $(`#img-${id}`).fadeOut(300, function() { $(this).remove(); });
                            }
                        }
                    });
                }
            });
        });
        
        // Form submit logic untuk gabung konten
        var formEdit = document.getElementById('form-edit-artikel');
        if (formEdit) {
            formEdit.addEventListener('submit', function(e) {
                var finalInput = document.getElementById('final-konten');
                finalInput.value = $('#summernote').summernote('code');
            });
        }
    });

    function updateLayoutCropHint() {
        var sel   = document.getElementById('edit-layout-select');
        var hint  = document.getElementById('edit-layout-crop-hint');
        if (!sel || !hint || typeof CROP_RATIOS === 'undefined') return;
        var cfg   = CROP_RATIOS[sel.value] || CROP_RATIOS['artikel1'];
        hint.textContent = '📐 Info Crop layout ini: ' + cfg.label + ' (' + cfg.w + '×' + cfg.h + ')';
    }

    // Fungsi utama pengubah opsi layout dinamis
    var originalLayout = "{{ old('layout', $artikel->layout) }}";
    function onEditKategoriChange(sel, initialLoad = false) {
        if(!sel) return;
        var selectedOption = sel.options[sel.selectedIndex];
        var nama = selectedOption ? (selectedOption.dataset.nama || '') : '';
        
        var isPuisi = (nama === 'puisi');
        var isProsa = (nama === 'prosa');
        var isBukuInspirasi = (nama === 'buku' || nama === 'inspirasi');

        var layoutSel = document.getElementById('edit-layout-select');
        var prosaNotice = document.getElementById('edit-prosa-notice');
        var bukuNotice = document.getElementById('edit-buku-notice');

        // Toggle UI Layout Option untuk Puisi
        var layoutParent = layoutSel.parentElement;

        if (isPuisi) {
            if(layoutParent) layoutParent.style.display = 'none'; // Sembunyikan opsi layout sama sekali (locked to Model 3)
        } else {
            if(layoutParent) layoutParent.style.display = 'block';
        }

        // Sembunyikan notifikasi
        if(prosaNotice) prosaNotice.style.display = 'none';
        if(bukuNotice) bukuNotice.style.display = 'none';

        // Bersihkan opsi layout
        if(layoutSel) layoutSel.innerHTML = '';

        if (isPuisi) {
            layoutSel.add(new Option('Layout Puisi / Sajak (artikel3)', 'artikel3'));
        } else if (isBukuInspirasi) {
            layoutSel.add(new Option('Layout Buku & Inspirasi (artikel4)', 'artikel4'));
            if(bukuNotice) bukuNotice.style.display = 'block';
        } else {
            layoutSel.add(new Option('Layout Standar (artikel1)', 'artikel1'));
            layoutSel.add(new Option('Layout Khusus (artikel2)', 'artikel2'));
            if (isProsa && prosaNotice) prosaNotice.style.display = 'block';
        }

        // Set value
        if (initialLoad) {
            // Coba set ke original layout
            var optExists = Array.from(layoutSel.options).some(opt => opt.value === originalLayout);
            if (optExists) layoutSel.value = originalLayout;
        }

        updateLayoutCropHint();

        // Kosongkan container extra image jika layout berubah drastis oleh user
        if (!initialLoad) {
            var container = document.getElementById('gambar-container');
            if (container) container.innerHTML = '';
        }
    }
</script>
@endpush
