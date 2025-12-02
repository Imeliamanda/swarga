<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusPengaduanDiubah extends Notification
{
    use Queueable;

    public Pengaduan $pengaduan;
    public string $statusLama;

    public function __construct(Pengaduan $pengaduan, string $statusLama)
    {
        $this->pengaduan   = $pengaduan;
        $this->statusLama  = $statusLama;
    }

    // Simpan ke database (channel bawaan Laravel)
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'pengaduan_id'   => $this->pengaduan->id,
            'isi'            => $this->pengaduan->isi,
            'status_lama'    => $this->statusLama,
            'status_baru'    => $this->pengaduan->status,
            'updated_at'     => now()->toDateTimeString(),
        ];
    }
}
