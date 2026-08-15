<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyUserEmail extends Notification
{
    use Queueable;

    public function __construct(public string $verificationUrl) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Email — Galeri Buku Jakarta')
            ->greeting('Halo, ' . $notifiable->nama . '!')
            ->line('Terima kasih telah mendaftar di Galeri Buku Jakarta.')
            ->line('Klik tombol di bawah untuk memverifikasi alamat email Anda.')
            ->action('Verifikasi Email Saya', $this->verificationUrl)
            ->line('Link ini berlaku selama 60 menit.')
            ->line('Jika Anda tidak mendaftar, abaikan email ini.')
            ->salutation('Salam, Tim Galeri Buku Jakarta');
    }
}
