<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $artikel = Artikel::with(['kategori', 'penulis', 'gambar'])->where('slug', $slug)->firstOrFail();

        // Update jumlah_tayang
        $artikel->increment('jumlah_tayang');

        // Untuk related/slider
        $relatedSlider = Artikel::where('kategori_id', $artikel->kategori_id)
                                ->where('id', '!=', $artikel->id)
                                ->orderByRaw('(jumlah_tayang / POW(GREATEST(TIMESTAMPDIFF(HOUR, tanggal_publikasi, NOW()), 0) + 2, 1.5)) DESC')
                                ->limit(25)
                                ->get();

        // Untuk popular
        $popular = Artikel::with('kategori')
                          ->where('id', '!=', $artikel->id)
                          ->orderBy('jumlah_tayang', 'desc')
                          ->limit(7)
                          ->get();

        // Pass 'template' type if it needs artikel1 or artikel2 based on logic, or just fallback to artikel1
        // Usually, the legacy code had modelartikel/artikel1 and modelartikel/artikel2 mapped directly from the links.
        // We'll pass the type via query string maybe? 
        // For now, we render a generic artikel template.
        
        // Cek query parameter layout, jika tidak ada, tentukan berdasarkan kategori
        $template = request()->query('layout');
        if (!$template) {
            if (!empty($artikel->layout)) {
                $template = $artikel->layout;
            } elseif ($artikel->kategori && $artikel->kategori->nama === 'Kata & Kota') {
                $template = 'artikel3';
            } else {
                $template = 'artikel1';
            }
        }
        
        // --- PAYWALL LOGIC ---
        $hasAccess = true;
        if ($artikel->jenis_artikel === 'premium') {
            $hasAccess = false;
            
            if (\Illuminate\Support\Facades\Auth::guard('pengguna')->check()) {
                $user = \Illuminate\Support\Facades\Auth::guard('pengguna')->user();
                if ($user->isPremium()) {
                    $hasAccess = true;
                }
            }
        }
        
        // Truncate content to 2 text paragraphs if no access
        if (!$hasAccess) {
            $content = $artikel->konten;
            if (stripos($content, '</p>') !== false) {
                $parts = preg_split('#</p>#i', $content);
                $truncated = '';
                $textPCount = 0;
                foreach ($parts as $part) {
                    if (trim($part) === '') continue; // Skip empty trailing split part
                    
                    $truncated .= $part . '</p>';
                    // Count only if the paragraph has actual text
                    if (trim(strip_tags($part)) !== '') {
                        $textPCount++;
                    }
                    if ($textPCount >= 2) {
                        break;
                    }
                }
                $artikel->konten = $truncated;
            } else {
                // Fallback for plain text without <p> tags
                $parts = explode("\n", $content);
                $truncated = '';
                $textPCount = 0;
                foreach ($parts as $part) {
                    $truncated .= $part . "\n";
                    if (trim($part) !== '') {
                        $textPCount++;
                    }
                    if ($textPCount >= 2) {
                        break;
                    }
                }
                $artikel->konten = $truncated;
            }
        }
        
        return view('pages.modelartikel.' . $template, compact('artikel', 'relatedSlider', 'popular', 'hasAccess'));
    }
}
