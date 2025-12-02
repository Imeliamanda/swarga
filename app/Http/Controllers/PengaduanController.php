<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // TAMPILKAN TIMELINE / DASHBOARD (untuk warga & admin timeline)
   public function index(Request $request)
{
    // status = null / 'baru' / 'diproses' / 'selesai'
    $status = $request->query('status');

    // q = kata kunci pencarian (misal: "banjir", "sampah")
    $q = $request->query('q');

    $query = Pengaduan::with(['user', 'komentars.user'])
        ->orderBy('created_at', 'desc');

    // filter status kalau dipilih
    if ($status && in_array($status, ['baru', 'diproses', 'selesai'])) {
        $query->where('status', $status);
    }

    // filter pencarian isi pengaduan
    if ($q) {
        $query->where('isi', 'like', '%' . $q . '%');
    }

    $pengaduans = $query->paginate(10)->withQueryString();

    // apakah ini mode admin (route: admin.timeline) atau warga (route: dashboard)
    $isAdminView = request()->routeIs('admin.timeline');

    return view('dashboard', compact('pengaduans', 'isAdminView', 'status', 'q'));
}

    // SIMPAN PENGADUAN BARU (WARGA)
    public function store(Request $request)
{
    $data = $request->validate([
        'isi'         => 'required|string|max:1000',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'lokasi_text' => 'nullable|string|max:255',
        'lokasi_maps' => 'nullable|string|max:500',
    ]);

    $data['user_id'] = auth()->id();
    $data['status']  = 'baru';

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('pengaduan_foto', 'public');
    }

    Pengaduan::create($data);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Pengaduan berhasil dikirim.');
}
    public function riwayat()
{
    // Ambil semua pengaduan milik user yang sedang login
    $pengaduans = Pengaduan::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Kita pakai view khusus riwayat
    $isAdminView = false; // supaya layout tetap mode warga

    return view('pengaduan.riwayat', compact('pengaduans', 'isAdminView'));
}
    
}