<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SellerApprovedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Akun Anda Telah Disetujui')
                    ->greeting('Halo ' . $notifiable->nama . '!')
                    ->line('Selamat, akun Anda sebagai penjual telah disetujui oleh admin.')
                    ->line('Silakan login untuk mulai menggunakan platform kami.')
                    ->action('Login Sekarang', url('/login'))
                    ->line('Terima kasih telah bergabung dengan kami!');
    }
}
