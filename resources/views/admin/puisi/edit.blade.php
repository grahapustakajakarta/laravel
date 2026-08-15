@extends('admin.layouts.app')

@section('title', 'Edit Puisi')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
<style>
    .puisi-editor-wrap {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .puisi-editor-pane { flex: 1; min-width: 0; }
    .puisi-preview-pane {
        flex: 1; min-width: 0;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
        padding: 24px 32px;
        min-height: 360px;
    }
    .puisi-preview-label {
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #999;
        margin-bottom: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;
    }
    .puisi-preview-content {
        font-family: 'EB Garamond', Garamond, Georgia, serif;
        font-size: 18px; line-height: 1.1; color: #1a1a1a;
    }
    .puisi-preview-content p { margin: 0 0 3px 0; white-space: nowrap; }
    .puisi-line-count { font-size: 12px; color: #888; text-align: right; margin-top: 4px; }
    .puisi-guide {
        background: #f8f9fa; border-left: 4px solid #0d6efd;
        border-radius: 0 6px 6px 0; padding: 12px 16px; margin-bottom: 12px; font-size: 13px;
    }
    .puisi-guide .guide-item { display: flex; align-items: baseline; gap: 8px; margin-bottom: 6px; }
    .puisi-guide .guide-item:last-child { margin-bottom: 0; }
    .puisi-guide .key {
        background: #e9ecef; border: 1px solid #ccc; border-radius: 3px;
        padding: 1px 6px; font-family: monospace; font-size: 12px; white-space: nowrap; flex-shrink: 0;
    }
    #konten-puisi-editor {
        font-family: 'EB Garamond', Garamond, Georgia, serif;
        font-size: 17px; line-height: 1.4; resize: vertical; width: 100%;
    }
    @media (max-width: 768px) { .puisi-editor-wrap { flex-direction: column; } }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Edit Puisi / Sajak (Puisi)</h2>
    <a href="{{ route('admin.puisi.index') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.puisi.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
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

                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten Puisi / Sajak <span class="text-danger">*</span></label>

                        <div class="puisi-guide mb-2">
                            <div class="guide-item"><span class="key">Enter</span><span>Ganti baris — setiap Enter = satu baris baru dalam puisi.</span></div>
                            <div class="guide-item"><span class="key">Enter 2×</span><span>Baris kosong = jarak antar bait / stanza.</span></div>
                            <div class="guide-item"><span class="key"># Judul Bab</span><span>Awali baris dengan <code>#</code> untuk <strong>subjudul tebal</strong>.</span></div>
                            <div class="guide-item"><span class="key">Preview</span><span>Pratinjau tampilan puisi di sebelah kanan update otomatis.</span></div>
                        </div>

                        <div class="puisi-editor-wrap">
                            <div class="puisi-editor-pane">
                                <textarea name="konten" id="konten-puisi-editor"
                                    class="form-control @error('konten') is-invalid @enderror"
                                    rows="18" required>{{ old('konten', $artikel->konten) }}</textarea>
                                @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                <div class="puisi-line-count"><span id="line-count">0</span> baris</div>
                            </div>
                            <div class="puisi-preview-pane">
                                <div class="puisi-preview-label"><i class="fas fa-eye me-1"></i> Pratinjau Tampilan</div>
                                <div class="puisi-preview-content" id="puisi-preview-output"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Layout Tampilan <span class="text-danger">*</span></label>
                        <select name="layout" class="form-select @error('layout') is-invalid @enderror" required>
                            <option value="artikel3" {{ old('layout', $artikel->layout) == 'artikel3' ? 'selected' : '' }}>Layout Puisi / Sajak (artikel3)</option>
                            <option value="artikel1" {{ old('layout', $artikel->layout) == 'artikel1' ? 'selected' : '' }}>Layout Standar (artikel1)</option>
                            <option value="artikel2" {{ old('layout', $artikel->layout) == 'artikel2' ? 'selected' : '' }}>Layout Review Buku (artikel2)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Penulis <span class="text-danger">*</span></label>
                        <select name="penulis_id" class="form-select @error('penulis_id') is-invalid @enderror" required>
                            <option value="">Pilih Penulis</option>
                            @foreach($penulis as $p)
                                <option value="{{ $p->id }}" {{ old('penulis_id', $artikel->penulis_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tgl Publikasi <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_publikasi" class="form-control" value="{{ old('tanggal_publikasi', \Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sponsor (Opsional)</label>
                        <input type="text" name="sponsor" class="form-control" value="{{ old('sponsor', $artikel->sponsor) }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar Saat Ini</label>
                        <div class="row g-2 mb-3">
                            @foreach($artikel->gambar as $gbr)
                            <div class="col-6 position-relative" id="img-{{ $gbr->id }}">
                                <img src="{{ asset('img/' . $gbr->file_gambar) }}" class="img-fluid rounded border mb-1" alt="Gambar">
                                <input type="text" name="existing_deskripsi_gambar[{{ $gbr->id }}]" class="form-control form-control-sm" value="{{ old('existing_deskripsi_gambar.'.$gbr->id, $gbr->deskripsi) }}" placeholder="Kredit Foto">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-delete-gambar" data-id="{{ $gbr->id }}"><i class="fas fa-times"></i></button>
                            </div>
                            @endforeach
                        </div>

                        <label class="form-label fw-bold">Tambah Gambar Baru</label>
                        <div id="gambar-container">
                            <div class="gambar-row mb-2 p-2 border rounded bg-light">
                                <input type="file" name="gambar[]" class="form-control mb-1" accept="image/*">
                                <input type="text" name="deskripsi_gambar[]" class="form-control form-control-sm" placeholder="Kredit Foto / Caption (opsional)">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Perbarui Artikel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // AJAX Delete Gambar
        $('.btn-delete-gambar').click(function() {
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
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if(res.success) {
                                $(`#img-${id}`).fadeOut(300, function() { $(this).remove(); });
                            }
                        }
                    });
                }
            })
        });

        // Live Preview Puisi
        function renderPuisiPreview(raw) {
            if (!raw || !raw.trim()) return '<p style="color:#bbb;font-style:italic;">Pratinjau kosong...</p>';
            var lines = raw.split('\n');
            var html = '';
            lines.forEach(function(line) {
                if (/^#\s*(.+)/.test(line)) {
                    html += '<p><strong>' + line.replace(/^#\s*/, '') + '</strong></p>';
                } else if (line.trim() === '') {
                    html += '<p style="margin-bottom:14px;">&nbsp;</p>';
                } else {
                    html += '<p>' + line + '</p>';
                }
            });
            return html;
        }

        var $editor = $('#konten-puisi-editor');
        var $preview = $('#puisi-preview-output');
        var $lineCount = $('#line-count');

        function updatePreview() {
            $preview.html(renderPuisiPreview($editor.val()));
            $lineCount.text($editor.val() === '' ? 0 : $editor.val().split('\n').length);
        }
        $editor.on('input keyup', updatePreview);
        updatePreview();
    });
</script>
@endpush
