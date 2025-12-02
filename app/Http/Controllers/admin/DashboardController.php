<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL SEMUA PENGADUAN
        $totalPengaduan = Pengaduan::count();

        // STATUS BARU
        $pengaduanBaru = Pengaduan::where('status', 'baru')->count();

        // STATUS DIPROSES
        $pengaduanDiproses = Pengaduan::where('status', 'diproses')->count();

        // STATUS SELESAI (opsional)
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();

        return view('admin.dashboard', compact(
            'totalPengaduan',
            'pengaduanBaru',
            'pengaduanDiproses',
            'pengaduanSelesai'
        ));
    }
}
