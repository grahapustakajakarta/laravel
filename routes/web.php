<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WebhookController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');

// Sign In, Sign Up & Logout (pengguna frontend)
Route::get('/signin',  [AuthUserController::class, 'showSignIn'])->name('user.signin');
Route::post('/signin', [AuthUserController::class, 'signIn'])->name('user.signin.post');
Route::get('/signup',  [AuthUserController::class, 'showSignUp'])->name('user.signup');
Route::post('/signup', [AuthUserController::class, 'signUp'])->name('user.signup.post');
Route::post('/signout',[AuthUserController::class, 'signOut'])->name('user.signout');

// Socialite
Route::get('/auth/{provider}/redirect', [AuthUserController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [AuthUserController::class, 'handleProviderCallback'])->name('socialite.callback');
// Verifikasi Email
Route::get('/email/verify',          [AuthUserController::class, 'verificationNotice'])->name('user.verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthUserController::class, 'verifyEmail'])->name('user.verification.verify')->middleware('signed');
Route::post('/email/resend',         [AuthUserController::class, 'resendVerification'])->name('user.verification.resend');

// Subscribe
Route::get('/subscribe',             [SubscribeController::class, 'index'])->name('subscribe');
Route::post('/subscribe/snap-token', [SubscribeController::class, 'createSnapToken'])->name('subscribe.snap_token');
Route::post('/subscribe/notif',      [SubscribeController::class, 'notification'])->name('subscribe.notification');
Route::get('/subscribe/success',     [SubscribeController::class, 'success'])->name('subscribe.success');

// Sentral Webhook Midtrans
Route::post('/midtrans/webhook', [WebhookController::class, 'handle'])->name('midtrans.webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// User Dashboard & Profile
use App\Http\Controllers\UserProfileController;
Route::middleware('auth:pengguna')->prefix('profile')->name('user.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/tulisan', [UserProfileController::class, 'storeTulisan'])->name('profile.tulisan');
    Route::post('/tulisan/{id}/update', [UserProfileController::class, 'updateTulisan'])->name('profile.update_tulisan');
    Route::post('/tulisan/{id}/request-revisi', [UserProfileController::class, 'requestRevisi'])->name('profile.request_revisi');
    Route::delete('/tulisan/{id}/delete', [UserProfileController::class, 'deleteTulisan'])->name('profile.delete_tulisan');
    Route::post('/simpan-artikel/{id}', [UserProfileController::class, 'saveArtikel'])->name('profile.save_artikel');
    Route::post('/koleksi', [UserProfileController::class, 'addKoleksi'])->name('profile.add_koleksi');
    Route::delete('/simpan-artikel/{id}/remove', [UserProfileController::class, 'removeArtikel'])->name('profile.remove_artikel');
    Route::delete('/koleksi/{id}/remove', [UserProfileController::class, 'removeKoleksi'])->name('profile.remove_koleksi');
});

// Pustaka
use App\Http\Controllers\PustakaController;
Route::get('/katalog-pustaka', [PustakaController::class, 'index'])->name('pustaka.index');
Route::get('/katalog-pustaka/{slug}', [PustakaController::class, 'show'])->name('pustaka.detail');
Route::get('/katalog-pustaka/{slug}/beli', [PustakaController::class, 'beli'])->name('pustaka.beli');
Route::post('/katalog-pustaka/{slug}/bayar', [PustakaController::class, 'prosesBayar'])->name('pustaka.bayar');
Route::get('/katalog-pustaka/{slug}/baca', [PustakaController::class, 'bacaPustaka'])->name('pustaka.baca');
Route::get('/katalog-pustaka/{slug}/preview-pdf', [PustakaController::class, 'previewPdfPustaka'])->name('pustaka.preview_pdf');
Route::post('/katalog-pustaka/notif', [PustakaController::class, 'notification'])->name('pustaka.notification');

// Keranjang Belanja
use App\Http\Controllers\CartController;
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/toggle', [CartController::class, 'toggle'])->name('cart.toggle');
Route::delete('/keranjang/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/keranjang/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/keranjang/jumlah', [CartController::class, 'count'])->name('cart.count');
Route::post('/keranjang/notifikasi', [CartController::class, 'notification'])->name('cart.notification');

// Kategori & Statis
Route::get('/page/{category}', [CategoryController::class, 'show'])->name('page.show');

// Kontak
Route::get('/kontak', function() {
    return view('pages.info.contact');
})->name('kontak');

// Donasi Midtrans
use App\Http\Controllers\DonationController;
Route::get('/donate', function() {
    return view('pages.info.donate');
})->name('donate');
Route::post('/donate/snap-token', [DonationController::class, 'createSnapToken'])->name('donate.snap_token');
Route::post('/donate/notif', [DonationController::class, 'notification'])->name('donate.notification');

// Advertise
Route::get('/advertise-with-us', function() {
    return view('pages.info.advertise');
})->name('advertise');

// Sponsorship
Route::get('/sponsorship', function() {
    return view('pages.info.sponsorship');
})->name('sponsorship');

// Tentang
Route::get('/tentang', function() {
    return view('pages.info.about');
})->name('tentang');

// Penerbitan
Route::get('/penerbitan', function() {
    return view('pages.info.penerbitan');
})->name('penerbitan');

// Editorial Team
Route::get('/editorial-team', function() {
    $kategoris = \App\Models\Kategori::all();
    return view('pages.info.associate', compact('kategoris'));
})->name('editorial_team');

// Siapakah Jakarta
Route::get('/siapakah-jakarta', function() {
    return view('pages.info.jakarta');
})->name('siapakah_jakarta');

// Getting Published (Kirim Tulisan Landing Page)
Route::get('/getting-published', function() {
    if (auth('pengguna')->check() && auth('pengguna')->user()->isPremium()) {
        return redirect()->route('user.profile', ['tab' => 'kirim-tulisan']);
    }
    return view('pages.info.getting_published');
})->name('getting_published');

// Donate
Route::get('/donate', function() {
    return view('pages.info.donate');
})->name('donate');

// Kebijakan Privasi
Route::get('/kebijakan-privasi', function() {
    return view('pages.info.privacy');
})->name('privacy');

// Artikel
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');

// Publikasi (Frontend)
Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');
Route::get('/publikasi/{publikasi}/download', [PublikasiController::class, 'download'])->name('publikasi.download');
Route::get('/publikasi/{publikasi}/preview-pdf', [PublikasiController::class, 'previewPdf'])->name('publikasi.preview_pdf');
Route::get('/publikasi/{publikasi}', [PublikasiController::class, 'show'])->name('publikasi.show');

// MAGZ (Frontend)
Route::get('/magz', [PublikasiController::class, 'magz'])->name('magz.index');
Route::get('/magz/{slug}/preview', [PublikasiController::class, 'preview'])->name('magz.preview');
Route::get('/magz/{slug}/beli', [PublikasiController::class, 'beli'])->name('magz.beli');
Route::post('/magz/{slug}/bayar', [PublikasiController::class, 'prosesBayar'])->name('magz.bayar');
Route::get('/magz/{slug}/baca', [PublikasiController::class, 'bacaMagz'])->name('magz.baca');
Route::get('/magz/{slug}/preview-pdf', [PublikasiController::class, 'previewPdfMagz'])->name('magz.preview_pdf');
Route::post('/magz/notif', [PublikasiController::class, 'notification'])->name('magz.notification');

// Admin Panel
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenulisController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PublikasiController as AdminPublikasiController;
use App\Http\Controllers\Admin\PustakaController as AdminPustakaController;
use App\Http\Controllers\Admin\MagzController as AdminMagzController;
use App\Http\Controllers\Admin\DataUserController;
use App\Http\Controllers\Admin\KeuanganController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest:web');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest:web');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Routes (all authenticated admins)
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('admin.permission:kategori')->group(function() {
            Route::resource('kategori', KategoriController::class)->except(['show']);
        });

        Route::middleware('admin.permission:penulis')->group(function() {
            Route::resource('penulis', PenulisController::class)->except(['show']);
        });

        Route::middleware('admin.permission:artikel')->group(function() {
            Route::delete('artikel/destroy-all', [ArtikelController::class, 'destroyAll'])->name('artikel.destroyAll');
            Route::post('artikel/bulk-destroy', [ArtikelController::class, 'bulkDestroy'])->name('artikel.bulkDestroy');
            Route::post('artikel/live-preview', [ArtikelController::class, 'livePreview'])->name('artikel.live_preview');
            Route::delete('artikel/gambar/{id}', [ArtikelController::class, 'destroyGambar'])->name('artikel.gambar.destroy');
            Route::resource('artikel', ArtikelController::class)->except(['show']);
        });

        Route::middleware('admin.permission:puisi')->group(function() {
            Route::resource('puisi', \App\Http\Controllers\Admin\PuisiController::class)->except(['show']);
        });

        Route::middleware('admin.permission:publikasi')->group(function() {
            Route::resource('publikasi', AdminPublikasiController::class)->except(['show']);
        });

        Route::middleware('admin.permission:pustaka')->group(function() {
            Route::resource('pustaka', AdminPustakaController::class)->except(['show']);
        });

        Route::middleware('admin.permission:magz')->group(function() {
            Route::resource('magz', AdminMagzController::class)->except(['show']);
        });

        // Kelola Tulisan User (diproteksi permission)
        Route::middleware('admin.permission:tulisan_user')->group(function() {
            Route::get('penggunatulisan', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'index'])->name('penggunatulisan.index');
            Route::get('penggunatulisan/{id}', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'show'])->name('penggunatulisan.show');
            Route::get('penggunatulisan/{id}/preview', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'preview'])->name('penggunatulisan.preview');
            Route::post('penggunatulisan/{id}/approve', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'approve'])->name('penggunatulisan.approve');
            Route::post('penggunatulisan/{id}/reject', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'reject'])->name('penggunatulisan.reject');
            Route::post('penggunatulisan/{id}/unpublish', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'unpublish'])->name('penggunatulisan.unpublish');
            Route::post('penggunatulisan/{id}/approve-revisi', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'approveRevisi'])->name('penggunatulisan.approve_revisi');
            Route::post('penggunatulisan/{id}/reject-revisi', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'rejectRevisi'])->name('penggunatulisan.reject_revisi');
            Route::delete('penggunatulisan/{id}/destroy', [\App\Http\Controllers\Admin\PenggunaTulisanController::class, 'destroy'])->name('penggunatulisan.destroy');
        });

        // Kelola Keuangan
        Route::middleware('admin.permission:keuangan')->group(function() {
            Route::get('/laporan-keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
            Route::post('/laporan-keuangan/sync', [KeuanganController::class, 'syncMidtrans'])->name('keuangan.sync');
        });

        // Super Admin Only Routes
        Route::middleware('superadmin')->group(function () {
            Route::resource('pengguna', PenggunaController::class)->except(['show']);
            Route::resource('datauser', DataUserController::class)->only(['index', 'destroy']);
            Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
            Route::delete('log-aktivitas/clear', [LogAktivitasController::class, 'clear'])->name('log.clear');
            
            // Persetujuan Hapus Artikel
            Route::get('deletion-requests', [\App\Http\Controllers\Admin\DeletionRequestController::class, 'index'])->name('deletion_requests.index');
            Route::post('deletion-requests/{id}/approve', [\App\Http\Controllers\Admin\DeletionRequestController::class, 'approve'])->name('deletion_requests.approve');
            Route::post('deletion-requests/{id}/reject', [\App\Http\Controllers\Admin\DeletionRequestController::class, 'reject'])->name('deletion_requests.reject');
        });
    });
});

Route::get('/temp-update-images', function () {
    $kategori = \App\Models\Kategori::where('nama', 'Inspirasi')->first();
    if ($kategori) {
        $images = ['f1.jpg', 'f2.jpg', 'f3.jpg', 'g1.jpg', 'g5.jpg', 'jkt.jpg', 'jktaku.jpg', 'jakarta.jpg', 'paris.jpg', 'soekarno.jpg'];
        $artikels = \App\Models\Artikel::where('kategori_id', $kategori->id)->get();
        foreach ($artikels as $index => $artikel) {
            $artikel->gambar_pertama = $images[$index % count($images)];
            $artikel->save();
        }
        return "Images updated for Inspirasi";
    }
    return "Category not found";
});

// Fallback routes for split-directory architecture (e.g. cPanel public_html vs public)
// If Apache cannot find the file in public_html, it passes the 404 to Laravel.
// Laravel will then serve the file directly from its internal public/storage paths.
Route::get('/img/{filename}', function ($filename) {
    $path = public_path('img/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '.*');

Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');
