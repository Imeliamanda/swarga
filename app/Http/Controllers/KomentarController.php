<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        Komentar::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'isi'          => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }
}
