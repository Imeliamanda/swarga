@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Pagination\AbstractPaginator;

    // Biar bisa pakai metode collection untuk hitung status
    $collection = $pengaduans instanceof AbstractPaginator
        ? $pengaduans->getCollection()
        : collect($pengaduans);

    $totalSemua    = $collection->count();
    $totalBaru     = $collection->where('status', 'baru')->count();
    $totalDiproses = $collection->where('status', 'diproses')->count();
    $totalSelesai  = $collection->where('status', 'selesai')->count();
@endphp

<x-app-layout>
    {{-- HEADER ATAS --}}
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
                Riwayat Pengaduan Saya
            </h2>
            <p class="text-xs text-emerald-600">
                Daftar semua pengaduan yang pernah Anda sampaikan melalui SWarga.
            </p>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-emerald-50 via-white to-emerald-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- RINGKASAN SINGKAT --}}
            <div class="bg-emerald-50/90 border border-emerald-100 rounded-3xl p-4 sm:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-emerald-900">
                            Ringkasan Pengaduan Anda
                        </p>
                        <p class="text-xs text-emerald-600">
                            Lihat status terbaru setiap pengaduan, termasuk yang sedang diproses dan yang sudah selesai.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                        <div class="px-3 py-2 rounded-2xl bg-white border border-emerald-100 text-center shadow-xs">
                            <p class="text-[11px] text-emerald-600">Total</p>
                            <p class="text-base font-semibold text-emerald-900">
                                {{ $pengaduans->total() }}
                            </p>
                        </div>
                        <div class="px-3 py-2 rounded-2xl bg-emerald-900 text-center text-emerald-50 shadow-xs">
                            <p class="text-[11px] text-emerald-200">Baru</p>
                            <p class="text-base font-semibold">
                                {{ $totalBaru }}
                            </p>
                        </div>
                        <div class="px-3 py-2 rounded-2xl bg-amber-50 text-center border border-amber-100 shadow-xs">
                            <p class="text-[11px] text-amber-700">Diproses</p>
                            <p class="text-base font-semibold text-amber-800">
                                {{ $totalDiproses }}
                            </p>
                        </div>
                        <div class="px-3 py-2 rounded-2xl bg-emerald-100 text-center border border-emerald-200 shadow-xs">
                            <p class="text-[11px] text-emerald-700">Selesai</p>
                            <p class="text-base font-semibold text-emerald-900">
                                {{ $totalSelesai }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TIMELINE RIWAYAT --}}
            <div class="space-y-4">
                @forelse ($pengaduans as $pengaduan)
                    <article class="relative bg-white border border-emerald-50 rounded-3xl shadow-sm p-4 sm:p-5 overflow-hidden">

                        {{-- Garis timeline di kiri (hanya dekorasi) --}}
                        <span class="absolute left-3 top-0 h-full w-px bg-emerald-100 hidden sm:block"></span>
                        <span class="absolute left-2.5 top-5 h-3 w-3 rounded-full bg-emerald-500 border-2 border-white hidden sm:block shadow-sm"></span>

                        {{-- HEADER CARD --}}
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                <span class="px-2 py-0.5 rounded-full bg-slate-50 border border-slate-200 text-[11px]">
                                    ID #{{ $pengaduan->id }}
                                </span>
                                <span class="text-[11px]">
                                    {{ $pengaduan->created_at->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>

                            {{-- Status pill --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold
                                @if($pengaduan->status === 'baru')
                                    bg-emerald-100 text-emerald-700
                                @elseif($pengaduan->status === 'diproses')
                                    bg-amber-100 text-amber-700
                                @else
                                    bg-emerald-700 text-emerald-50
                                @endif
                            ">
                                Status:
                                <span class="ml-1">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </span>
                        </div>

                        {{-- ISI + LOKASI + FOTO --}}
                        <div class="space-y-3">
                            {{-- Judul singkat dari isi pengaduan (ambil baris pertama) --}}
                            <p class="text-sm font-semibold text-slate-800">
                                {{ Str::limit(preg_split("/\r\n|\n|\r/", $pengaduan->isi)[0] ?? $pengaduan->isi, 110) }}
                            </p>

                            {{-- Lokasi --}}
                            @if($pengaduan->lokasi_text || $pengaduan->lokasi_maps)
                                <div class="flex flex-wrap items-center gap-3 text-xs">
                                    @if($pengaduan->lokasi_text)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-800">
                                            <span>📍</span>
                                            <span class="truncate max-w-[220px] sm:max-w-[280px]">
                                                {{ $pengaduan->lokasi_text }}
                                            </span>
                                        </span>
                                    @endif

                                    @if($pengaduan->lokasi_maps)
                                        <a href="{{ $pengaduan->lokasi_maps }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-emerald-600 text-[11px] underline decoration-dotted">
                                            <span>Lihat Maps ↗</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Foto pengaduan --}}
                            @if($pengaduan->foto)
                                <div class="mt-1 rounded-2xl overflow-hidden border border-emerald-50 bg-slate-50">
                                    <img
                                        src="{{ Storage::url($pengaduan->foto) }}"
                                        alt="Foto pengaduan"
                                        class="w-full max-h-64 object-cover"
                                    >
                                </div>
                            @endif
                        </div>

                        {{-- FOOTER: Status lanjutan / catatan admin --}}
                        <div class="mt-4 border-t border-slate-100 pt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="text-[11px] text-slate-500">
                                Terakhir diperbarui:
                                <span class="font-medium">
                                    {{ $pengaduan->updated_at->diffForHumans() }}
                                </span>
                            </div>

                            @if($pengaduan->catatan_admin)
                                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl px-3 py-2 text-xs text-emerald-900 max-w-xl">
                                    <p class="font-semibold text-[11px] mb-1 flex items-center gap-1">
                                        <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-600 text-[9px] text-white">RT</span>
                                        Catatan dari Pengurus RT
                                    </p>
                                    <p class="leading-snug whitespace-pre-line text-slate-800">
                                        "{{ $pengaduan->catatan_admin }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="bg-white border border-dashed border-emerald-200 rounded-3xl p-6 text-center text-sm text-slate-500">
                        <p class="font-semibold text-emerald-800 mb-1">Belum ada pengaduan yang tercatat.</p>
                        <p>
                            Sampaikan keluhan atau aspirasi Anda melalui halaman <span class="font-semibold">Beranda</span>,
                            lalu pengaduan Anda akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINASI --}}
            <div class="mt-3">
                {{ $pengaduans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
