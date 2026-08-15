{{--
    CROP MODAL PARTIAL
    Include di create.blade.php & edit.blade.php
    Usage: @include('admin.artikel.partials.crop-modal')
--}}

{{-- ─── CROP MODAL ─────────────────────────────────────────────────── --}}
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#1a1a2e; color:#fff;">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-crop-alt me-2"></i>Sesuaikan Gambar</h5>
                    <small id="crop-ratio-label" style="opacity:.7; font-size:12px;"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" id="btn-crop-cancel"></button>
            </div>
            <div class="modal-body p-0" style="background:#111; min-height:450px; display:flex; align-items:center; justify-content:center;">
                <div style="max-width:100%; max-height:70vh; overflow:hidden; width:100%;">
                    <img id="crop-image-el" src="" alt="Crop" style="max-width:100%; display:block;">
                </div>
            </div>
            <div class="modal-footer" style="background:#f8f8f8; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cropperInst && cropperInst.rotate(-90)" title="Putar Kiri">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cropperInst && cropperInst.rotate(90)" title="Putar Kanan">
                        <i class="fas fa-redo"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cropperInst && cropperInst.scaleX(cropperInst.getData().scaleX === -1 ? 1 : -1)" title="Flip Horizontal">
                        <i class="fas fa-arrows-alt-h"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cropperInst && cropperInst.reset()" title="Reset">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <span style="border-left:1px solid #ccc; height:28px; margin:0 4px;"></span>
                    <span id="crop-size-info" style="font-size:12px; color:#666;"></span>
                    <div id="dynamic-ratio-selector" style="display:none; border-left:1px solid #ccc; padding-left:10px; margin-left:6px; align-items:center;">
                        <span style="font-size:12px; color:#444; margin-right:6px;">Orientasi:</span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-ratio-portrait">Portrait</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-ratio-landscape">Landscape</button>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" class="btn btn-secondary" id="btn-crop-cancel2">Batal</button>
                    <button type="button" class="btn btn-danger" id="btn-crop-apply">
                        <i class="fas fa-check me-1"></i>Gunakan Gambar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── CROPPER.JS ────────────────────────────────────────────────────── --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<style>
/* ── Crop Trigger Button ────────────────────────────── */
.crop-upload-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 12px 16px;
    cursor: pointer;
    background: #fafafa;
    transition: all .2s;
    width: 100%;
    text-align: left;
}
.crop-upload-btn:hover {
    border-color: #b70d0f;
    background: #fff8f8;
}
.crop-upload-btn .icon { font-size: 20px; color: #b70d0f; }
.crop-upload-btn .text { font-size: 13px; color: #555; line-height: 1.3; }
.crop-upload-btn .text strong { color: #222; display: block; }

/* ── Gambar Preview Thumbnail ───────────────────────── */
.crop-thumb-wrap {
    position: relative;
    display: inline-block;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #e0e0e0;
    background: #f5f5f5;
    margin-top: 8px;
}
.crop-thumb-wrap img {
    display: block;
    max-height: 160px;
    max-width: 100%;
    object-fit: cover;
}
.crop-thumb-wrap .btn-recrop {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.55);
    color: #fff;
    font-size: 11px;
    text-align: center;
    padding: 5px;
    cursor: pointer;
    transition: background .2s;
}
.crop-thumb-wrap .btn-recrop:hover { background: rgba(183,13,15,.8); }
.crop-thumb-wrap .btn-remove-crop {
    position: absolute;
    top: 4px; right: 4px;
    background: rgba(0,0,0,.6);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 22px; height: 22px;
    font-size: 11px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}

/* ── Ratio Badge ────────────────────────────────────── */
.ratio-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #e8f0ff;
    color: #1a3a8a;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}
.ratio-badge.portrait { background: #fff0e0; color: #8a4a00; }
</style>

<script>
/* ═══════════════════════════════════════════════════════
   CROP SYSTEM — Buku Jakarta Admin
   ═══════════════════════════════════════════════════════ */

var cropperInst    = null;
var cropTargetEl   = null;   // Hidden file input yg dituju
var cropBlobTarget = null;   // Elemen penyimpan blob result
var cropContainerId = null;  // ID container row

// Rasio per layout
var CROP_RATIOS = {
    'artikel1':      { ratio: 16/9,  label: '16:9 — Landscape (Hero Banner)',          w: 1920, h: 1080 },
    'artikel2':      { ratio: 16/9,  label: '16:9 — Landscape (Hero Banner)',          w: 1920, h: 1080 },
    'artikel3':      { ratio: 4/3,   label: '4:3 — Landscape (Cover Puisi)',           w: 1200, h: 900  },
    'artikel4':      { ratio: 2/3,   label: '2:3 – Portrait (Cover Buku 1000x1500)', w: 1000, h: 1500 },
    'artikel4extra': { ratio: 2/3,   label: 'Pilih Orientasi (Portrait / Landscape)', w: 1000, h: 1500 },
};

function getCurrentLayout() {
    // Coba dari select edit.blade (name="layout")
    var selEdit = document.getElementById('edit-layout-select');
    if (selEdit && selEdit.value) return selEdit.value;
    // Coba dari hidden input create.blade
    var hidCreate = document.getElementById('layout-hidden');
    if (hidCreate && hidCreate.value) return hidCreate.value;
    return 'artikel1';
}

/* ── Buka modal crop ───────────────── */
function openCropModal(file, inputEl, containerRowId, ratioKeyOverride) {
    cropTargetEl    = inputEl;
    cropContainerId = containerRowId;

    var cfgKey = ratioKeyOverride || getCurrentLayout();
    var cfg    = CROP_RATIOS[cfgKey] || CROP_RATIOS['artikel1'];

    var reader = new FileReader();
    reader.onload = function(e) {
        var imgEl = document.getElementById('crop-image-el');
        imgEl.src = e.target.result;

        // Tampilkan info rasio
        document.getElementById('crop-ratio-label').textContent = cfg.label;
        document.getElementById('crop-size-info').textContent   = 'Output: ' + (cfg.w ? cfg.w : 'Auto') + 'x' + (cfg.h ? cfg.h : 'Auto') + ' px';

        // Tentukan badge class
        var badge = document.getElementById('crop-ratio-badge-dyn');
        if (badge) {
            badge.textContent = cfg.label;
            badge.className   = 'ratio-badge' + (cfg.ratio && cfg.ratio < 1 ? ' portrait' : '');
        }

        // Simpan cfg ke variable global agar apply btn bisa akses
        window._currentCropCfg = cfg;
        window._currentCropCfgKey = cfgKey;

        // Tampilkan tombol orientasi jika layout artikel4extra
        var dynSelector = document.getElementById('dynamic-ratio-selector');
        if (dynSelector) {
            dynSelector.style.display = (cfgKey === 'artikel4extra') ? 'flex' : 'none';
        }

        // Buka modal
        var modal = new bootstrap.Modal(document.getElementById('cropModal'));
        modal.show();

        // Init cropper setelah modal tampil
        document.getElementById('cropModal').addEventListener('shown.bs.modal', function handler() {
            if (cropperInst) { cropperInst.destroy(); cropperInst = null; }
            cropperInst = new Cropper(imgEl, {
                aspectRatio: cfg.ratio,
                viewMode:    1,
                dragMode:    'move',
                autoCropArea: 0.9,
                responsive:  true,
                background:  true,
                movable:     true,
                zoomable:    true,
                rotatable:   true,
                scalable:    true,
                guides:      true,
                center:      true,
                highlight:   false,
                cropBoxMovable: true,
                cropBoxResizable: true,
            });
            this.removeEventListener('shown.bs.modal', handler);
        });
    };
    reader.readAsDataURL(file);
}

/* ── Apply crop ──────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {

    var applyBtn   = document.getElementById('btn-crop-apply');
    var cancelBtn  = document.getElementById('btn-crop-cancel');
    var cancelBtn2 = document.getElementById('btn-crop-cancel2');

    function cancelCrop() {
        if (cropperInst) { cropperInst.destroy(); cropperInst = null; }
        // Reset file input agar tidak tersubmit file asli yg belum di-crop
        if (cropTargetEl) cropTargetEl.value = '';
        bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
    }

    cancelBtn.addEventListener('click', cancelCrop);
    cancelBtn2.addEventListener('click', cancelCrop);

    // Tombol Orientasi
    var btnPortrait = document.getElementById('btn-ratio-portrait');
    var btnLandscape = document.getElementById('btn-ratio-landscape');

    if (btnPortrait) {
        btnPortrait.addEventListener('click', function() {
            if (!cropperInst || window._currentCropCfgKey !== 'artikel4extra') return;
            var cfg = window._currentCropCfg;
            cfg.ratio = 2/3; cfg.w = 1000; cfg.h = 1500; cfg.label = '2:3 – Portrait (Gambar Isi)';
            cropperInst.setAspectRatio(cfg.ratio);
            document.getElementById('crop-ratio-label').textContent = cfg.label;
            document.getElementById('crop-size-info').textContent   = 'Output: ' + cfg.w + 'x' + cfg.h + ' px';
        });
    }

    if (btnLandscape) {
        btnLandscape.addEventListener('click', function() {
            if (!cropperInst || window._currentCropCfgKey !== 'artikel4extra') return;
            var cfg = window._currentCropCfg;
            cfg.ratio = 16/9; cfg.w = 1920; cfg.h = 1080; cfg.label = '16:9 – Landscape (Gambar Isi)';
            cropperInst.setAspectRatio(cfg.ratio);
            document.getElementById('crop-ratio-label').textContent = cfg.label;
            document.getElementById('crop-size-info').textContent   = 'Output: ' + cfg.w + 'x' + cfg.h + ' px';
        });
    }

    applyBtn.addEventListener('click', function() {
        if (!cropperInst || !cropContainerId) return;

        // Gunakan cfg dari window._currentCropCfg jika ada, fallback ke getCropConfig()
        var cfg = window._currentCropCfg || getCropConfig();
        
        var canvasOpts = { imageSmoothingQuality: 'high' };
        if (cfg.w) canvasOpts.width = cfg.w;
        if (cfg.h) canvasOpts.height = cfg.h;
        
        var canvas = cropperInst.getCroppedCanvas(canvasOpts);

        canvas.toBlob(function(blob) {
            // Buat File dari blob
            var croppedFile = new File([blob], 'gambar_crop_' + Date.now() + '.jpg', { type: 'image/jpeg' });

            // Inject ke DataTransfer → masuk ke hidden file input
            var dt = new DataTransfer();
            dt.items.add(croppedFile);
            cropTargetEl.files = dt.files;

            // Tampilkan thumbnail di container row
            var rowEl = document.getElementById(cropContainerId);
            if (rowEl) {
                var previewImg = document.getElementById('preview-' + cropContainerId); // e.g., preview-img-15
                if (previewImg) {
                    // Logic untuk Ganti Gambar (existing image)
                    var thumbUrl = URL.createObjectURL(blob);
                    previewImg.src = thumbUrl;
                    
                    var label = rowEl.querySelector('.ganti-label');
                    if (!label) {
                        label = document.createElement('span');
                        label.className = 'badge bg-success ganti-label position-absolute top-0 start-0 m-2';
                        label.textContent = 'Gambar siap diganti';
                        rowEl.appendChild(label);
                    }
                } else {
                    // Logic untuk Tambah Gambar Baru (createCropRow)
                    var existingThumb = rowEl.querySelector('.crop-thumb-wrap');
                    if (existingThumb) existingThumb.remove();

                    var thumbUrl = URL.createObjectURL(blob);
                    var thumbWrap = document.createElement('div');
                    thumbWrap.className = 'crop-thumb-wrap';
                    thumbWrap.innerHTML =
                        '<img src="' + thumbUrl + '" alt="Preview">' +
                        '<div class="btn-recrop" onclick="reCropRow(\'' + cropContainerId + '\')">' +
                            '<i class="fas fa-crop-alt me-1"></i>Crop Ulang' +
                        '</div>' +
                        '<button type="button" class="btn-remove-crop" onclick="removeCropRow(\'' + cropContainerId + '\')" title="Hapus">' +
                            '<i class="fas fa-times"></i>' +
                        '</button>';
                    rowEl.insertBefore(thumbWrap, rowEl.firstChild);
                }
            }

            if (cropperInst) { cropperInst.destroy(); cropperInst = null; }
            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();

        }, 'image/jpeg', 0.88);
    });

    /* ── Delegasi event untuk file input baru ── */
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('crop-file-input') && e.target.files.length > 0) {
            var rowId    = e.target.closest('.gambar-row-crop') ? e.target.closest('.gambar-row-crop').id : null;
            var ratioKey = e.target.dataset.ratioKey || null;
            openCropModal(e.target.files[0], e.target, rowId, ratioKey);
        }
    });

    /* ── Delegasi click untuk trigger button ── */
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.crop-trigger-btn');
        if (btn) {
            var rowId    = btn.dataset.rowId;
            var ratioKey = btn.dataset.ratioKey || null;
            var inputEl  = document.getElementById('file-' + rowId);
            if (inputEl) inputEl.click();
            // Simpan ratioKey ke input agar digunakan saat file change
            if (inputEl && ratioKey) inputEl.dataset.ratioKey = ratioKey;
        }
    });
});

/* ── Re-crop: buka ulang dengan file yg sama ─ */
function reCropRow(rowId) {
    var inputEl = document.getElementById('file-' + rowId);
    if (inputEl && inputEl.files.length > 0) {
        openCropModal(inputEl.files[0], inputEl, rowId);
    } else {
        if (inputEl) inputEl.click();
    }
}

/* ── Hapus baris gambar ───────────────────── */
function removeCropRow(rowId) {
    var row = document.getElementById(rowId);
    if (row) row.remove();
}

/* ── Buat baris gambar baru dengan crop ──── */
var _cropRowCounter = 0;
function createCropRow(isRequired, ratioKey) {
    _cropRowCounter++;
    var rowId  = 'crop-row-' + _cropRowCounter;
    var cfgKey = ratioKey || getCurrentLayout();
    var cfg    = CROP_RATIOS[cfgKey] || CROP_RATIOS['artikel1'];
    var isPort = cfg.ratio < 1;

    var div = document.createElement('div');
    div.className = 'gambar-row-crop mb-3 p-3 border rounded bg-light';
    div.id        = rowId;

    div.innerHTML =
        '<div class="ratio-badge ' + (isPort ? 'portrait' : '') + ' mb-2">' +
            '<i class="fas fa-' + (isPort ? 'book' : 'image') + '"></i> ' +
            cfg.label +
        '</div>' +
        '<button type="button" class="crop-trigger-btn" data-row-id="' + rowId + '" data-ratio-key="' + cfgKey + '">' +
            '<div class="crop-upload-btn">' +
                '<span class="icon"><i class="fas fa-crop-alt"></i></span>' +
                '<div class="text">' +
                    '<strong>Pilih & Crop Gambar</strong>' +
                    'Klik untuk pilih foto, lalu sesuaikan area crop' +
                '</div>' +
            '</div>' +
        '</button>' +
        '<input type="file" id="file-' + rowId + '" name="gambar[]" class="crop-file-input d-none" accept="image/*"' + (isRequired ? ' required' : '') + '>' +
        '<input type="text" name="deskripsi_gambar[]" class="form-control form-control-sm mt-2" placeholder="Kredit / Deskripsi foto (opsional)">' +
        '<button type="button" class="btn btn-sm btn-link text-danger p-0 mt-1" onclick="removeCropRow(\'' + rowId + '\')">' +
            '<i class="fas fa-trash-alt me-1"></i>Hapus field ini' +
        '</button>';

    return div;
}
</script>
