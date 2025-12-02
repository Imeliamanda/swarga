@php
    use Illuminate\Support\Facades\Storage;

    function inisialNama($nama) {
        $parts = explode(' ', trim($nama));
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last  = mb_substr($parts[count($parts)-1] ?? '', 0, 1);
        return mb_strtoupper($first . $last);
    }

    // pastikan variabel selalu ada supaya tidak error
    $isAdminView = $isAdminView ?? false;
    $status      = $status      ?? request()->query('status');
    $q           = $q           ?? request()->query('q');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
                    {{ $isAdminView ? 'Timeline Pengaduan (Mode Admin)' : 'Beranda Pengaduan Warga' }}
                </h2>
                <p class="text-xs text-emerald-600">
                    {{ $isAdminView
                        ? 'Anda melihat semua pengaduan warga RT 09 sebagai admin dan dapat mengubah status laporan.'
                        : 'Sampaikan keluhan, aspirasi, atau laporan terkait lingkungan RT 09.' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-emerald-50 via-white to-emerald-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- INFO + SEARCH + FILTER STATUS --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                <div>
                    <p class="text-sm text-emerald-900 font-medium">
                        @if($q)
                            Menampilkan pengaduan yang mengandung kata
                            <span class="font-semibold">"{{ $q }}"</span>
                            @if($status)
                                dengan status <span class="font-semibold">{{ ucfirst($status) }}</span>.
                            @else
                                dari semua status.
                            @endif
                        @else
                            Anda melihat pengaduan seluruh warga RT 09.
                        @endif
                    </p>
                    <p class="text-xs text-emerald-600">
                        Contoh kata kunci:
                        <span class="font-semibold">banjir</span>,
                        <span class="font-semibold">sampah</span>,
                        <span class="font-semibold">lampu jalan</span>.
                    </p>
                </div>

                @php
                    $searchAction = $isAdminView ? route('admin.timeline') : route('dashboard');
                    $statusOptions = [
                        ''        => 'Semua',
                        'baru'    => 'Baru',
                        'diproses'=> 'Diproses',
                        'selesai' => 'Selesai',
                    ];
                @endphp

                {{-- Bar pencarian panjang + filter status di dalamnya --}}
                <form method="GET"
                      action="{{ $searchAction }}"
                      class="w-full sm:w-[30rem]">
                    <div class="flex items-center gap-2 bg-white border border-emerald-200 rounded-full px-3 py-1.5 shadow-sm">

                        {{-- ikon search --}}
                        <span class="inline-flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.387a1 1 0 01-1.414 1.414l-3.387-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z"
                                      clip-rule="evenodd" />
                            </svg>
                        </span>

                        {{-- input kata kunci --}}
                        <input
                            type="text"
                            name="q"
                            value="{{ $q ?? '' }}"
                            class="flex-1 text-xs bg-transparent border-none focus:outline-none focus:ring-0 text-emerald-900 placeholder-emerald-400"
                            placeholder="Cari pengaduan (banjir, sampah, lampu jalan, dll.)">

                        {{-- garis pemisah tipis --}}
                        <span class="h-5 w-px bg-emerald-100"></span>

                        {{-- filter status --}}
                        <span class="text-[11px] text-emerald-700 mr-1 hidden sm:inline">Status:</span>
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="text-[11px] bg-transparent border-none focus:outline-none cursor-pointer text-emerald-800">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ (string)($status ?? '') === (string)$value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>


            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
   {{-- notif --}}
           @php
    $statusNotification = auth()->user()
        ? auth()->user()->unreadNotifications
            ->where('type', \App\Notifications\StatusPengaduanDiubah::class)
            ->first()
        : null;
@endphp

@if($statusNotification)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition.opacity
        class="fixed top-4 right-4 z-50"
    >
        <div class="bg-emerald-700 text-white rounded-xl shadow-lg px-4 py-3 flex items-start gap-2 max-w-xs text-xs sm:text-sm">
            <span class="mt-0.5 text-lg">🔔</span>

            <div class="flex-1">
                <p class="font-semibold mb-0.5">
                    Status pengaduan diperbarui
                </p>

                @php
                    $data       = $statusNotification->data ?? [];
                    $idPeng     = $data['pengaduan_id']  ?? '-';
                    $statusLama = ucfirst($data['status_lama'] ?? '-');
                    $statusBaru = ucfirst($data['status_baru'] ?? '-');
                @endphp

                <p class="leading-snug">
                    Pengaduan <span class="font-semibold">#{{ $idPeng }}</span>
                    berubah dari <span class="font-semibold">{{ $statusLama }}</span>
                    menjadi <span class="font-semibold">{{ $statusBaru }}</span>.
                </p>

                <form action="{{ route('notif.markAllRead') }}" method="POST" class="mt-1.5">
                    @csrf
                    <button type="submit"
                            class="text-[11px] underline text-emerald-200 hover:text-white">
                        Tandai sudah dibaca
                    </button>
                </form>
            </div>

            <button
                @click="show = false"
                class="ml-2 text-emerald-100 hover:text-white text-lg leading-none"
                aria-label="Tutup notifikasi"
            >
                ×
            </button>
        </div>
    </div>
@endif



            {{-- FORM PENGADUAN - HANYA UNTUK WARGA --}}
            @if(!$isAdminView)
                <div class="rounded-3xl shadow-sm overflow-hidden bg-emerald-900 text-emerald-50">
                    {{-- Header kecil --}}
                    <div class="flex items-center justify-between px-4 sm:px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-emerald-700 flex items-center justify-center text-xs font-semibold">
                                {{ inisialNama(auth()->user()->name) }}
                            </div>
                            <div class="leading-tight">
                                <p class="text-[11px] uppercase tracking-wide text-emerald-200">Buat Pengaduan Baru</p>
                                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Body form (ultra compact) --}}
                    <div class="bg-emerald-50 text-emerald-900 px-4 sm:px-6 py-4">
                        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf

                            {{-- Isi pengaduan --}}
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-emerald-900">
                                    Tulis Pengaduan Anda
                                </label>
                                <textarea
                                    name="isi"
                                    rows="2"
                                    class="w-full rounded-2xl border border-emerald-200 bg-white/80 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm text-slate-800 placeholder-emerald-400 resize-none px-3 py-2"
                                    placeholder="Contoh: selokan tersumbat, lampu jalan mati, keamanan lingkungan, dll."></textarea>
                                @error('isi')
                                    <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Lokasi & Maps --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="flex items-center gap-1 text-[11px] font-semibold text-emerald-900 mb-1">
                                        <span>📍</span> Lokasi Kejadian
                                    </label>
                                    <input type="text"
                                           name="lokasi_text"
                                           class="w-full rounded-2xl border border-emerald-200 bg-white/80 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-xs px-3 py-2"
                                           placeholder="Contoh: Depan mushola RT 09, dekat pos ronda">
                                </div>

                                <div>
                                    <label class="flex items-center gap-1 text-[11px] font-semibold text-emerald-900 mb-1">
                                        🌐 Tautan Google Maps <span class="font-normal text-emerald-500">(opsional)</span>
                                    </label>
                                    <input type="text"
                                           name="lokasi_maps"
                                           class="w-full rounded-2xl border border-emerald-200 bg-white/80 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-xs px-3 py-2"
                                           placeholder="Tempelkan link share location di sini">
                                </div>
                            </div>

                            {{-- Foto + tombol kirim (1 baris) --}}
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-2 text-xs text-emerald-800">
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 border border-emerald-200 text-lg">
                                            📷
                                        </span>
                                        <div class="flex flex-col leading-tight">
                                            <span class="font-semibold text-[11px] text-emerald-900">Foto pendukung (opsional)</span>
                                            <span class="text-[10px] text-emerald-500">jpg, jpeg, png • maks 2 MB</span>
                                        </div>
                                        <input type="file" name="foto" class="hidden" accept="image/*">
                                    </label>
                                </div>

                                <div class="flex sm:justify-end w-full sm:w-auto">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold shadow-sm transition">
                                        <span>📨</span>
                                        <span>Kirim Pengaduan</span>
                                    </button>
                                </div>
                            </div>

                            @error('foto')
                                <p class="text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            @endif

            {{-- GARIS PEMISAH --}}
            <div class="border-t border-emerald-100"></div>

            {{-- TIMELINE PENGADUAN --}}
            <div class="space-y-4">
                @forelse ($pengaduans as $pengaduan)
                    <article class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 space-y-4">

                        {{-- Header --}}
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                    {{ inisialNama($pengaduan->user->name ?? 'Warga') }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $pengaduan->user->name ?? 'Warga RT 09' }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $pengaduan->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <span class="
                                px-4 py-1 rounded-full text-[11px] font-semibold
                                @if($pengaduan->status==='baru') bg-emerald-100 text-emerald-700
                                @elseif($pengaduan->status==='diproses') bg-amber-100 text-amber-700
                                @else bg-emerald-600 text-white @endif">
                                {{ ucfirst($pengaduan->status ?? 'baru') }}
                            </span>
                        </div>

                        {{-- 2 Kolom: Pengaduan Kiri & Respon Admin Kanan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Kolom kiri: isi + lokasi + foto warga --}}
                            <div class="space-y-3">
                                <p class="text-sm text-slate-700 leading-relaxed">
                                    {{ $pengaduan->isi }}
                                </p>

                                {{-- Lokasi kejadian --}}
                                @if($pengaduan->lokasi_text || $pengaduan->lokasi_maps)
                                    <div class="text-xs text-emerald-700 bg-emerald-50/70 border border-emerald-100 px-3 py-2 rounded-xl space-y-1">
                                        <p class="font-semibold text-emerald-900 flex items-center gap-1">
                                            <span>📍</span> Lokasi Kejadian
                                        </p>

                                        @if($pengaduan->lokasi_text)
                                            <p class="text-slate-800">
                                                {{ $pengaduan->lokasi_text }}
                                            </p>
                                        @endif

                                        @if($pengaduan->lokasi_maps)
                                            <a href="{{ $pengaduan->lokasi_maps }}"
                                               target="_blank"
                                               class="inline-flex items-center gap-1 text-emerald-600 underline">
                                                <span>Lihat di Google Maps</span>
                                                <span>↗</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if($pengaduan->foto)
                                    <img src="{{ Storage::url($pengaduan->foto) }}"
                                         class="rounded-xl border max-h-72 object-cover w-full shadow-sm"
                                         alt="foto pengaduan">
                                @endif
                            </div>

                            {{-- Kolom kanan: respons admin / placeholder --}}
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 space-y-3 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <div class="h-7 w-7 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                        RT
                                    </div>

                                    @if($pengaduan->catatan_admin || $pengaduan->foto_proses)
                                        <p class="text-xs font-semibold text-emerald-800">
                                            Tindak Lanjut Pengurus RT
                                        </p>
                                    @else
                                        <p class="text-xs font-semibold text-emerald-800">
                                            Menunggu Tindak Lanjut Pengurus RT
                                        </p>
                                    @endif
                                </div>

                                @if($pengaduan->catatan_admin || $pengaduan->foto_proses)
                                    @if($pengaduan->catatan_admin)
                                        <p class="text-xs text-slate-700 border-t border-emerald-100 pt-2 whitespace-pre-line">
                                            "{{ $pengaduan->catatan_admin }}"
                                        </p>
                                    @endif

                                    @if($pengaduan->foto_proses)
                                        <img src="{{ Storage::url($pengaduan->foto_proses) }}"
                                             class="rounded-lg border max-h-64 object-cover w-full shadow-sm"
                                             alt="foto proses penanganan">
                                    @endif
                                @else
                                    <div class="border-t border-emerald-100 pt-2 space-y-2">
                                        <p class="text-xs text-slate-600 leading-relaxed">
                                            Pengaduan Anda sudah tercatat di sistem SWarga.
                                            Pengurus RT 09 akan meninjau dan memberikan tindak lanjut secepatnya.
                                        </p>
                                        <div class="flex items-center gap-2 text-[11px] text-emerald-700">
                                            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100">
                                                ⏳
                                            </span>
                                            <span>
                                                Status saat ini:
                                                <span class="font-semibold">menunggu respon pengurus RT</span>.
                                            </span>
                                        </div>
                                    </div>
                                @endif
                              @if($pengaduan->prioritas)
        <div class="mt-2">
            @if($pengaduan->prioritas === 'darurat')
                <span class="badge bg-danger">🟥 Prioritas Darurat</span>
            @elseif($pengaduan->prioritas === 'tinggi')
                <span class="badge bg-warning">🟧 Prioritas Tinggi</span>
            @elseif($pengaduan->prioritas === 'sedang')
                <span class="badge bg-info">🟨 Prioritas Sedang</span>
            @else
                <span class="badge bg-success">🟩 Menunggu respon pengurus RT.</span>
            @endif
        </div>
    @endif  
    
                            </div>
                        </div>

                        {{-- Komentar --}}
                        <div class="border-t pt-3 space-y-3">
                            <p class="text-[11px] text-slate-500">
                                Komentar ({{ $pengaduan->komentars->count() }})
                            </p>

                            @foreach ($pengaduan->komentars as $komentar)
                                <div class="flex gap-2">
                                    <div class="h-7 w-7 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-[11px] font-semibold">
                                        {{ inisialNama($komentar->user->name ?? 'Warga') }}
                                    </div>
                                    <div class="bg-slate-50 border rounded-xl px-3 py-2 flex-1">
                                        <div class="flex justify-between items-center">
                                            <p class="text-xs font-semibold">{{ $komentar->user->name ?? 'Warga' }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $komentar->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-xs mt-1 text-slate-700">{{ $komentar->isi }}</p>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Form komentar --}}
                            <form action="{{ route('komentar.store', $pengaduan->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text"
                                       name="isi"
                                       placeholder="Tulis komentar..."
                                       class="flex-1 border rounded-full bg-white px-3 py-2 text-xs focus:ring-emerald-400 focus:border-emerald-400">
                                <button class="px-4 py-2 bg-emerald-600 text-white rounded-full text-xs">
                                    Kirim
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="text-center text-slate-500 mt-10 text-sm">
                        Belum ada pengaduan. Jadilah warga pertama yang menyampaikan suara Anda. 🌿
                    </p>
                @endforelse
            </div>

            {{-- PAGINASI --}}
            <div class="mt-4">
                {{ $pengaduans->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
