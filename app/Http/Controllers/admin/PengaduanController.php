<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Notifications\StatusPengaduanDiubah;

class PengaduanController extends Controller
{
    /**
     * LIST PENGADUAN UNTUK ADMIN (tampilan tabel di AdminLTE)
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Pengaduan::with('user')->orderBy('created_at', 'desc');

        if ($status && in_array($status, ['baru', 'diproses', 'selesai'])) {
            $query->where('status', $status);
        }

        $pengaduans = $query->paginate(15)->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduans', 'status'));
    }

    /**
     * FORM EDIT DETAIL PENGADUAN
     */
    public function edit(Pengaduan $pengaduan)
    {
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * UPDATE DETAIL PENGADUAN (status, catatan, foto_proses) dari halaman edit
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status'         => 'required|in:baru,diproses,selesai',
            'catatan_admin'  => 'nullable|string',
            'foto_proses'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $statusLama = $pengaduan->status;

        $data = [
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        // kalau admin upload foto proses baru
        if ($request->hasFile('foto_proses')) {
            $path = $request->file('foto_proses')->store('pengaduan_proses', 'public');
            $data['foto_proses'] = $path;
        }

        $pengaduan->update($data);

        // Opsional: kirim notifikasi hanya jika status berubah
        if ($pengaduan->user && $statusLama !== $pengaduan->status) {
            $pengaduan->user->notify(
                new StatusPengaduanDiubah($pengaduan, $statusLama)
            );
        }

        return redirect()
            ->route('admin.pengaduan.index')
            ->with('success', 'Status, catatan, dan bukti proses pengaduan berhasil diperbarui.');
    }

    /**
     * UPDATE STATUS CEPAT DARI TIMELINE ADMIN
     * (dipakai misalnya untuk dropdown "Baru / Diproses / Selesai" di timeline admin)
     */
    // 🔹 UPDATE STATUS CEPAT DARI TIMELINE ADMIN + NOTIFIKASI WARGA
public function updateStatus(Request $request, Pengaduan $pengaduan)
{
    // validasi sederhana
    $request->validate([
        'status' => 'required',
    ]);

    // normalisasi ke huruf kecil
    $statusBaru = strtolower($request->status);

    if (! in_array($statusBaru, ['baru', 'diproses', 'selesai'])) {
        return back()->with('error', 'Status tidak valid.');
    }

    $statusLama = $pengaduan->status;

    $pengaduan->status = $statusBaru;
    $pengaduan->save();

    // kirim notifikasi ke warga (kalau ada relasi user)
    if ($pengaduan->user) {
        $pengaduan->user->notify(
            new \App\Notifications\StatusPengaduanDiubah($pengaduan, $statusLama)
        );
    }

    return back()->with('success', 'Status pengaduan #' . $pengaduan->id . ' berhasil diperbarui.');
}
  public function updatePrioritas(Request $request, Pengaduan $pengaduan)
{
    // Validasi input
    $request->validate([
        'prioritas' => 'required|in:darurat,tinggi,sedang,rendah',
    ]);

    // Mengupdate prioritas pengaduan
    $pengaduan->prioritas = $request->prioritas;
    $pengaduan->save();

    // Mengembalikan ke halaman sebelumnya dengan notifikasi
    return back()->with('success', 'Prioritas pengaduan #' . $pengaduan->id . ' berhasil diperbarui.');
}

}
