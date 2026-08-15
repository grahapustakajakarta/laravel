@extends('layouts.app')

@section('title', 'Pencarian Artikel')

@section('content')
<style>
    /* Custom Styling for Search Page */
    .search-wrapper, .search-wrapper * {
        box-sizing: border-box;
    }
    .search-wrapper {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 15px 80px 15px;
        overflow-x: hidden;
    }
    .search-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .search-title {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 2.8rem;
        color: #111;
        margin-bottom: 10px;
        line-height: 1.2;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    .search-subtitle {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        color: #666;
        margin-bottom: 30px;
    }
    .search-form {
        display: flex;
        justify-content: center;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 50px;
        overflow: hidden;
    }
    .search-input {
        flex: 1;
        border: none;
        padding: 12px 20px;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        outline: none;
        width: 100%;
    }
    .search-btn {
        background-color: #b70d0f;
        color: #fff;
        border: none;
        padding: 12px 25px;
        font-family: 'Source Sans 3', sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .search-btn:hover {
        background-color: #8c0a0c;
    }
    
    .search-results {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .search-card {
        display: block;
        text-decoration: none;
        background: #F9F8F6;
        padding: 25px;
        border: 1px solid #eee;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .search-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #e0e0e0;
    }
    .search-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .search-card-category {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #b70d0f;
        font-weight: 700;
    }
    .search-card-date {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.8rem;
        color: #888;
    }
    .search-card-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #111;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    .search-card-excerpt {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.95rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    .search-card-author {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.85rem;
        color: #888;
        font-weight: 600;
    }
    
    .search-empty {
        text-align: center;
        padding: 50px 20px;
        background: #F9F8F6;
        border: 1px dashed #ccc;
        border-radius: 8px;
    }
    .search-empty-icon {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
    .search-empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 10px;
    }
    .search-empty-desc {
        font-family: 'Source Sans 3', sans-serif;
        color: #666;
    }

    /* Paginasi sederhana Custom non-bootstrap */
    .search-pagination {
        margin-top: 40px;
        text-align: center;
        display: flex;
        justify-content: center;
    }
    .search-pagination nav svg {
        height: 20px;
    }
    .search-pagination nav div.flex {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .search-pagination p.text-sm {
        font-family: 'Source Sans 3', sans-serif;
        color: #666;
        margin-top: 15px;
    }

    /* Media Query for Mobile Responsiveness */
    @media (max-width: 768px) {
        .search-title {
            font-size: 2rem;
        }
        .search-wrapper {
            padding: 30px 15px 60px 15px;
        }
        .search-card {
            padding: 15px;
        }
        .search-card-title {
            font-size: 1.25rem;
        }
        .search-card-excerpt {
            font-size: 0.9rem;
        }
        .search-input {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        .search-btn {
            padding: 10px 20px;
        }
    }
</style>

<div class="search-wrapper">
    <div class="search-header">
        <h1 class="search-title">
            @if($keyword)
                Hasil untuk "{{ $keyword }}"
            @else
                Pencarian Artikel
            @endif
        </h1>
        <p class="search-subtitle">Menampilkan {{ $artikels->total() }} tulisan terkait</p>
        
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Ketik kata kunci..." value="{{ $keyword }}" required>
            <button class="search-btn" type="submit">Cari</button>
        </form>
    </div>

    @if($artikels->count() > 0)
        <div class="search-results">
            @foreach($artikels as $artikel)
                <a href="{{ route('artikel.show', $artikel->slug) }}" class="search-card">
                    <div class="search-card-meta">
                        @if($artikel->kategori)
                            <span class="search-card-category">{{ $artikel->kategori->nama }}</span>
                        @else
                            <span class="search-card-category">Umum</span>
                        @endif
                        <span class="search-card-date">{{ $artikel->created_at->format('d M Y') }}</span>
                    </div>
                    <h4 class="search-card-title">{{ $artikel->judul }}</h4>
                    <p class="search-card-excerpt">
                        {{ Str::limit(strip_tags($artikel->konten), 160) }}
                    </p>
                    <div class="search-card-author">
                        Oleh {{ $artikel->penulis->nama ?? 'Redaksi' }}
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="search-pagination">
            {{ $artikels->appends(['search' => $keyword])->links() }}
        </div>
    @else
        <div class="search-empty">
            <div class="search-empty-icon"><i class="fal fa-search-minus"></i></div>
            <h3 class="search-empty-title">Tidak Ditemukan</h3>
            <p class="search-empty-desc">Maaf, tidak ada artikel yang cocok dengan pencarian Anda. Silakan gunakan kata kunci lain.</p>
        </div>
    @endif
</div>
@endsection
