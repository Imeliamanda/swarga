<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
                    Riwayat Notifikasi Saya
                </h2>
                <p class="text-xs text-emerald-600">
                    Daftar semua notifikasi terkait pembaruan status pengaduan Anda di SWarga.
                </p>
            </div>

            {{-- Tombol tandai semua sudah dibaca --}}
            @if($unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notif.markAllRead') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-600 text-white text-xs font-semibold hover:bg-emerald-700 shadow-sm"
                    >
                        Tandai semua sudah dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-emerald-50 via-white to-emerald-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- FLASH SUCCESS (misal setelah markAllRead) --}}
            @if(session('success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ========== BAGIAN 1: NOTIFIKASI BELUM DIBACA ========== --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-emerald-900">
                        Belum Dibaca
                    </h3>
                    <span class="text-[11px] text-emerald-600">
                        {{ $unreadNotifications->count() }} notifikasi
                    </span>
                </div>

                @if($unreadNotifications->isEmpty())
                    <p class="text-xs text-slate-500 italic">
                        Tidak ada notifikasi baru. Semua sudah dibaca.
                    </p>
                @else
                    @foreach($unreadNotifications as $notif)
                        @php
                            $data = $notif->data;
                            $pengaduanId   = $data['pengaduan_id'] ?? null;
                            $statusLama    = $data['status_lama'] ?? '-';
                            $statusBaru    = $data['status_baru'] ?? '-';
                            $judul         = $data['judul'] ?? 'Status pengaduan diperbarui';
                            $pesan         = $data['pesan'] ?? "Status pengaduan #{$pengaduanId} berubah.";
                        @endphp

                        <div class="bg-white border border-emerald-100 rounded-2xl px-4 py-3 shadow-sm flex gap-3 items-start">
                            <div class="flex-shrink-0">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                    ⚠️
                                </span>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-emerald-900">
                                    {{ $judul }}
                                </p>
                                <p class="text-xs text-slate-700 mt-1">
                                    {{ $pesan }}
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1">
                                    #{{ $pengaduanId }} •
                                    <span class="font-semibold text-amber-700">{{ $statusLama }}</span>
                                    → 
                                    <span class="font-semibold text-emerald-700">{{ $statusBaru }}</span>
                                    • {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-emerald-100"></div>

            {{-- ========== BAGIAN 2: NOTIFIKASI SUDAH DIBACA ========== --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-emerald-900">
                        Riwayat Sebelumnya
                    </h3>
                    <span class="text-[11px] text-emerald-600">
                        Menampilkan {{ $readNotifications->count() }} notifikasi terakhir
                    </span>
                </div>

                @if($readNotifications->isEmpty())
                    <p class="text-xs text-slate-500 italic">
                        Belum ada riwayat notifikasi.
                    </p>
                @else
                    <div class="bg-white/70 border border-emerald-100 rounded-2xl divide-y divide-emerald-50 shadow-sm">
                        @foreach($readNotifications as $notif)
                            @php
                                $data = $notif->data;
                                $pengaduanId   = $data['pengaduan_id'] ?? null;
                                $statusLama    = $data['status_lama'] ?? '-';
                                $statusBaru    = $data['status_baru'] ?? '-';
                                $judul         = $data['judul'] ?? 'Status pengaduan diperbarui';
                                $pesan         = $data['pesan'] ?? "Status pengaduan #{$pengaduanId} berubah.";
                            @endphp

                            <div class="px-4 py-3 flex items-start gap-3 hover:bg-emerald-50/40 transition">
                                <div class="flex-shrink-0 mt-1">
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-slate-500 text-xs">
                                        ✔
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-slate-800">
                                        {{ $judul }}
                                    </p>
                                    <p class="text-xs text-slate-600 mt-1">
                                        {{ $pesan }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-1">
                                        #{{ $pengaduanId }} •
                                        {{ $statusLama }} → {{ $statusBaru }} •
                                        {{ $notif->created_at->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
