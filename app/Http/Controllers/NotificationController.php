<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Halaman inbox notifikasi
    public function index(Request $request)
    {
        $user = $request->user();

        // Notifikasi belum dibaca
        $unreadNotifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->get();

        // Notifikasi yang sudah dibaca (batasi 30 terakhir)
        $readNotifications = $user->readNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

        return view('notifikasi.index', compact('unreadNotifications', 'readNotifications'));
    }

    // Tombol "Tandai semua sudah dibaca"
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        // Kalau dipanggil dari dashboard, redirect ke dashboard, kalau dari halaman notif, tetap di sana
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
