@extends('layouts.app')

@section('content')
<style>
    /* ====================================================
       HALAMAN PUBLIKASI — CSS terisolasi dengan prefix pub-
       ==================================================== */
    #publikasi-page {
        max-width: 820px;
        margin: 0 auto;
        /* main sudah punya padding-top: 55px (navbar), tambah 25px jarak napas */
        padding: 25px 24px 80px;
        min-height: 100vh;
        box-sizing: border-box;
    }

    /* --- Header Row --- */
    .pub-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pub-header-row h1 {
        font-family: var(--font-serif);
        font-size: 2.8rem;
        font-weight: 900;
        color: #111;
        margin: 0;
        letter-spacing: -1px;
        line-height: 1;
    }

    /* --- Filter --- */
    .pub-filter-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .pub-filter-wrap label {
        font-size: 0.85rem;
        color: #888;
        white-space: nowrap;
        font-family: var(--font-sans);
    }
    .pub-filter-wrap select {
        border: none;
        border-bottom: 1.5px solid #111;
        padding: 4px 28px 4px 4px;
        font-size: 0.9rem;
        font-family: var(--font-sans);
        background: transparent;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        color: #111;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%23111' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 4px center;
        background-size: 16px;
    }
    .pub-filter-wrap select:focus { outline: none; }

    /* --- Publication Item --- */
    .pub-item {
        padding: 36px 0;
        border-bottom: 1px solid #ddd;
    }
    .pub-list > .pub-item:first-child {
        border-top: 1px solid #ddd;
    }
    .pub-category {
        font-size: 0.75rem;
        color: #888;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        font-family: var(--font-sans);
        text-transform: uppercase;
    }
    .pub-title {
        font-family: var(--font-serif);
        font-size: 1.8rem;
        font-weight: 500;
        color: #111;
        margin-bottom: 20px;
        line-height: 1.2;
        text-decoration: none;
        display: block;
        transition: color 0.15s;
    }
    .pub-title:hover { color: #b70d0f; text-decoration: none; }

    .pub-body {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .pub-cover {
        flex-shrink: 0;
        width: 140px;
    }
    .pub-cover img {
        width: 140px;
        height: 185px;
        object-fit: contain;
        object-position: center top;
        display: block;
    }
    .pub-cover-placeholder {
        width: 140px;
        height: 185px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
        font-size: 2rem;
        text-decoration: none;
    }
    .pub-info { flex: 1; }
    .pub-description {
        font-size: 1rem;
        line-height: 1.65;
        color: #333;
        margin-bottom: 20px;
        font-family: var(--font-sans);
    }
    .pub-download {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        color: #111;
        text-decoration: underline;
        text-underline-offset: 3px;
        font-family: var(--font-sans);
        letter-spacing: 0.5px;
        transition: color 0.15s;
        text-transform: uppercase;
    }
    .pub-download:hover { color: #b70d0f; text-decoration: underline; }

    /* --- Empty State --- */
    .pub-empty {
        text-align: center;
        padding: 80px 20px;
        color: #aaa;
        font-family: var(--font-sans);
    }
    .pub-empty i { font-size: 3rem; margin-bottom: 16px; display: block; }

    /* --- Pagination --- */
    .pub-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
        margin-bottom: 20px;
    }
    .pub-pagination .pagination { 
        gap: 12px; 
        list-style: none; 
        display: flex; 
        padding: 0; 
        margin: 0;
        justify-content: center;
    }
    /* Hide the "Showing X to Y of Z results" text */
    .pub-pagination p.text-muted {
        display: none !important;
    }
    /* Force centering of the pagination container */
    .pub-pagination .justify-content-sm-between {
        justify-content: center !important;
    }
    .pub-pagination .page-item { border: none; }
    .pub-pagination .page-link {
        background-color: transparent;
        border: none !important;
        color: #535353ff;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.05rem;
        font-weight: 400;
        cursor: pointer;
        padding: 5px 12px;
        position: relative;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0;
        box-shadow: none;
        text-decoration: none;
    }
    .pub-pagination .page-link:hover, .pub-pagination .page-link:focus {
        background-color: transparent;
        color: #b70d0f;
        box-shadow: none;
    }
    .pub-pagination .page-item.active .page-link {
        background-color: transparent;
        color: #b70d0f;
        font-weight: 500;
    }
    .pub-pagination .page-item.active .page-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background-color: #b70d0f;
    }
    .pub-pagination .page-item.disabled .page-link {
        color: #ccd5da;
        background-color: transparent;
    }

    /* --- Responsive --- */
    @media (max-width: 640px) {
        #publikasi-page { padding: 72px 16px 60px; }
        .pub-header-row h1 { font-size: 2rem; }
        .pub-body { flex-direction: column; }
        .pub-cover,
        .pub-cover img,
        .pub-cover-placeholder { width: 100%; height: 200px; }
    }
</style>

<section id="publikasi-page">
    <!-- Header -->
    <div class="pub-header-row">
        <h1>Publications</h1>
        <div class="pub-filter-wrap">
            <label>Filter</label>
            <form method="GET" action="{{ route('publikasi.index') }}">
                <select name="kategori" onchange="this.form.submit()">
                    <option value="all" {{ (!request('kategori') || request('kategori') === 'all') ? 'selected' : '' }}>All</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Publication List -->
    <div class="pub-list">
        @forelse($publikasi as $item)
        <div class="pub-item">
            <p class="pub-category">{{ $item->kategori }}</p>
            <a href="{{ route('publikasi.show', $item->id) }}" class="pub-title" target="_blank" rel="noopener">{{ $item->judul }}</a>
            <div class="pub-body">
                <div class="pub-cover">
                    @if($item->cover_gambar)
                        <a href="{{ route('publikasi.show', $item->id) }}" target="_blank" rel="noopener">
                            <img src="{{ asset('img/' . $item->cover_gambar) }}" alt="{{ $item->judul }}">
                        </a>
                    @else
                        <a href="{{ route('publikasi.show', $item->id) }}" target="_blank" rel="noopener" class="pub-cover-placeholder">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    @endif
                </div>
                <div class="pub-info">
                    @if($item->deskripsi)
                    <p class="pub-description">{{ $item->deskripsi }}</p>
                    @endif
                    <a href="{{ route('publikasi.download', $item->id) }}"
                       class="pub-download" style="margin-right: 15px;">
                        <i class="fas fa-download" style="font-size: 0.8rem;"></i> Download
                    </a>
                    @if($item->file_pdf_preview)
                    <a href="{{ route('publikasi.preview_pdf', $item->id) }}"
                       class="pub-download" target="_blank" style="margin-right: 15px;">
                        <i class="fas fa-eye" style="font-size: 0.8rem;"></i> Preview PDF
                    </a>
                    @endif
                    <button type="button" class="pub-save-btn" onclick="saveKoleksi('publikasi', {{ $item->id }}, this)" style="background:none; border:none; color:#111; cursor:pointer; font-family:var(--font-sans); font-size:0.9rem; text-transform:uppercase; letter-spacing:0.5px; transition:color 0.15s; padding:0;">
                        @php
                            $isSaved = false;
                            if(\Illuminate\Support\Facades\Auth::guard('pengguna')->check()) {
                                $isSaved = \App\Models\PenggunaKoleksi::where('pengguna_id', \Illuminate\Support\Facades\Auth::guard('pengguna')->id())
                                    ->where('item_type', 'publikasi')
                                    ->where('item_id', $item->id)->exists();
                            }
                        @endphp
                        <i class="{{ $isSaved ? 'fas' : 'far' }} fa-bookmark" style="font-size: 0.8rem;"></i> <span class="save-text" style="text-decoration: underline; text-underline-offset: 3px;">{{ $isSaved ? 'Saved' : 'Save' }}</span>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="pub-empty">
            <i class="fas fa-book-open"></i>
            <p>Belum ada publikasi yang tersedia{{ request('kategori') && request('kategori') !== 'all' ? ' untuk kategori ini' : '' }}.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($publikasi->hasPages())
    <div class="pub-pagination">
        {{ $publikasi->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
</section>

<script>
function saveKoleksi(type, id, btn) {
    @if(!\Illuminate\Support\Facades\Auth::guard('pengguna')->check())
        window.location.href = "{{ route('user.signin') }}";
        return;
    @endif

    fetch("{{ route('user.profile.add_koleksi') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ item_type: type, item_id: id })
    })
    .then(res => res.json())
    .then(data => {
        let icon = btn.querySelector('i');
        let text = btn.querySelector('.save-text');
        if(data.status === 'added') {
            icon.classList.remove('far');
            icon.classList.add('fas');
            text.textContent = 'Saved';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            text.textContent = 'Save';
        }
    })
    .catch(err => console.error(err));
}
</script>
@endsection
