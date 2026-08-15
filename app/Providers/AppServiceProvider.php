<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Artikel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // === PROTEKSI SENIOR IT: BLOKIR PERINTAH DESTRUKTIF ===
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Console\Events\CommandStarting::class, function (\Illuminate\Console\Events\CommandStarting $event) {
            $destructiveCommands = ['migrate:fresh', 'migrate:refresh', 'db:wipe'];
            
            if (in_array($event->command, $destructiveCommands)) {
                echo "\n\033[41m\033[1;37m [SISTEM TERKUNCI OLEH SENIOR IT] \033[0m\n";
                echo "\033[31mPerintah 'php artisan {$event->command}' telah DIBLOKIR secara permanen.\033[0m\n";
                echo "Perintah ini akan menghapus SELURUH data artikel dan gambar Anda!\n\n";
                echo "Jika Anda hanya ingin menambahkan tabel atau kolom baru:\n";
                echo "1. Buat file migration baru: \033[32mphp artisan make:migration nama_perubahan\033[0m\n";
                echo "2. Jalankan perintah aman: \033[32mphp artisan migrate\033[0m (TANPA :fresh)\n\n";
                exit(1);
            }
        });

        // View composer for the header menu (Coffeeshophia + Buku articles)
        View::composer('layouts.app', function ($view) {
            $coffeeshophia = Artikel::whereHas('kategori', function($q) {
                $q->where('nama', 'Coffeeshophia');
            })->orderBy('id', 'desc')->limit(2)->get();

            $buku_menu = Artikel::whereHas('kategori', function($q) {
                $q->where('nama', 'Buku');
            })->orderBy('id', 'desc')->limit(2)->get();

            $view->with('coffeeshophia_menu', $coffeeshophia);
            $view->with('buku_menu', $buku_menu);
        });

        // View composer for Admin Dashboard & Sidebar (Notification Badges)
        View::composer(['admin.layouts.app', 'admin.dashboard'], function ($view) {
            $view->with('badge_tulisan_pending', \App\Models\PenggunaTulisan::where('status', 'pending')->count());
            $view->with('badge_deletion_requests', \App\Models\DeletionRequest::where('status', 'pending')->count());
            $view->with('badge_new_users', \App\Models\Pengguna::where('is_read', 0)->count());
            $view->with('badge_logs_today', \App\Models\LogAktivitas::where('is_read', 0)->count());
            
            // For Keuangan: count transactions that are pending or new today
            $view->with('badge_keuangan', \App\Models\MagzTransaction::where('status', 'pending')->count());
        });
    }
}
