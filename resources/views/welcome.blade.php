<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SWarga - Suara Warga RT 09</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-emerald-50 via-white to-emerald-50">

    {{-- NAVBAR --}}
    <header class="border-b border-emerald-100 bg-white/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between gap-6">
            {{-- Logo kiri --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white font-semibold text-lg">
                    SW
                </span>
                <div class="leading-tight">
                    <span class="font-bold text-emerald-900 text-lg">SWarga</span>
                    <p class="text-[11px] text-emerald-600 -mt-1">
                        Suara Warga • Pengaduan Warga RT 09
                    </p>
                </div>
            </a>

            {{-- Menu tengah --}}
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('welcome') }}"
                   class="{{ request()->routeIs('welcome') ? 'text-emerald-900 font-semibold' : 'text-emerald-800 hover:text-emerald-900' }}">
                    Beranda
                </a>
                <a href="{{ route('tentang-rt') }}"
                   class="{{ request()->routeIs('tentang-rt') ? 'text-emerald-900 font-semibold' : 'text-emerald-800 hover:text-emerald-900' }}">
                    Tentang RT 09
                </a>
            </nav>

            {{-- Auth kanan --}}
            @if (Route::has('login'))
                <div class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-emerald-800 hover:text-emerald-900 font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-emerald-800 hover:text-emerald-900 font-medium">
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-5 py-2 rounded-full text-sm font-semibold
                                      bg-emerald-600 text-white hover:bg-emerald-700 shadow transition">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <main>
        {{-- HERO FULL DESKTOP --}}
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 grid grid-cols-1 md:grid-cols-2 gap-14 items-center">

                {{-- KIRI --}}
                <div class="space-y-7">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">
                        Platform pengaduan infrastruktur warga RT 09, Kelurahan Pematang Sulur, Kecamatan Telanaipura
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-extrabold text-emerald-900 leading-tight">
                        Sampaikan aspirasi dan pengaduan Anda bersama
                        <span class="text-emerald-600">SWarga.</span>
                    </h1>

                    <p class="text-lg text-emerald-700 leading-relaxed">
                        SWarga (Suara Warga) adalah sistem pengaduan resmi warga RT 09.
                        Aplikasi ini membantu warga menyampaikan pengaduan secara cepat,
                        terstruktur, dan transparan kepada pengurus RT.
                    </p>

                    <div class="flex gap-4 mt-4">
                        @guest
                            <a href="{{ route('register') }}"
                               class="px-6 py-3 rounded-full bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                                Daftar Akun Warga
                            </a>

                            <a href="{{ route('login') }}"
                               class="px-6 py-3 rounded-full border border-emerald-600 text-emerald-700 text-sm font-semibold bg-white hover:bg-emerald-50 transition">
                                Masuk
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}"
                               class="px-6 py-3 rounded-full bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                                Masuk ke Dashboard
                            </a>
                        @endguest
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-6">
                        <div class="p-4 rounded-xl bg-white border border-emerald-100 shadow-sm">
                            <p class="font-semibold text-emerald-900">Terpusat</p>
                            <p class="text-sm text-emerald-700">Semua pengaduan dalam satu tempat.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white border border-emerald-100 shadow-sm">
                            <p class="font-semibold text-emerald-900">Transparan</p>
                            <p class="text-sm text-emerald-700">Pantau progres secara realtime.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white border border-emerald-100 shadow-sm">
                            <p class="font-semibold text-emerald-900">Responsif</p>
                            <p class="text-sm text-emerald-700">Diproses oleh pengurus RT.</p>
                        </div>
                    </div>
                </div>

               

        
        <div class="-mt-6 rounded-3xl overflow-hidden shadow-xl border border-emerald-100 
            w-full h-72 md:h-96 lg:h-[430px] transform transition duration-500 hover:scale-[1.01]">
    <img 
        src="{{ asset('images/rt.jpg') }}" 
        alt="Suasana RT 09" 
        class="w-full h-full object-cover"
    >
</div>


        </div>

       

            </div>
        </section>

        {{-- ABOUT --}}
        <section class="py-20 bg-white border-y border-emerald-100">
            <div class="max-w-6xl mx-auto px-6 lg:px-10 grid grid-cols-1 md:grid-cols-2 gap-14">

                <div>
                    <h2 class="text-2xl font-bold text-emerald-900 mb-4">Tentang SWarga</h2>
                    <p class="text-emerald-700 text-base leading-relaxed">
                        SWarga (Suara Warga) adalah aplikasi pengaduan berbasis web yang memudahkan warga RT 09
                        dalam menyampaikan keluhan atau masukan terkait lingkungan sekitar.
                        Semua pengaduan dicatat, diproses, dan ditindaklanjuti oleh pengurus RT secara transparan.
                    </p>
                    <p class="text-emerald-700 text-base leading-relaxed mt-3">
                        Sistem ini dirancang untuk memperkuat komunikasi antara warga dan pengurus, mendorong
                        partisipasi aktif, serta mempercepat penanganan masalah di lingkungan RT.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-emerald-900 mb-4">Cara Kerja</h2>
                    <ul class="space-y-3 text-emerald-700 text-base">
                        <li>📌 Warga membuat akun & login ke SWarga.</li>
                        <li>📸 Warga membuat pengaduan lengkap dengan foto dan lokasi.</li>
                        <li>📰 Pengaduan tampil di beranda warga.</li>
                        <li>💬 Warga lain dapat memberi komentar.</li>
                        <li>🛠️ Admin RT memproses dan memperbarui status.</li>
                    </ul>
                </div>

            </div>
        </section>

        {{-- FITUR + KONTAK --}}
        <section class="py-20">
            <div class="max-w-6xl mx-auto px-6 lg:px-10 grid grid-cols-1 md:grid-cols-3 gap-10">

                <div class="md:col-span-2 space-y-4">
                    <h2 class="text-2xl font-bold text-emerald-900">Fitur Utama SWarga</h2>
                    <div class="grid sm:grid-cols-2 gap-6 text-sm">
                        <div class="p-5 rounded-xl bg-white border border-emerald-100 shadow">
                            <p class="font-semibold text-emerald-900">Timeline Modern</p>
                            <p class="text-emerald-700 mt-1">Pengaduan tampil seperti linimasa sosial media.</p>
                        </div>
                        <div class="p-5 rounded-xl bg-white border border-emerald-100 shadow">
                            <p class="font-semibold text-emerald-900">Komentar Warga</p>
                            <p class="text-emerald-700 mt-1">Ajak warga lain berdiskusi tentang pengaduan.</p>
                        </div>
                        <div class="p-5 rounded-xl bg-white border border-emerald-100 shadow">
                            <p class="font-semibold text-emerald-900">Panel Admin LTE</p>
                            <p class="text-emerald-700 mt-1">Admin dapat melihat, memfilter, dan memperbarui status.</p>
                        </div>
                        <div class="p-5 rounded-xl bg-white border border-emerald-100 shadow">
                            <p class="font-semibold text-emerald-900">Upload Foto</p>
                            <p class="text-emerald-700 mt-1">Pengaduan lebih jelas dengan lampiran visual.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-emerald-900">Hubungi Pengurus RT 09</h2>
                    <div class="p-5 rounded-xl bg-white border border-emerald-100 shadow text-emerald-800 text-base space-y-2">
                        <div>
                            <p class="font-semibold text-emerald-900 text-lg">Ketua RT 09</p>
                            <p>📞 0812-3456-7890</p>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-900 text-lg">Email</p>
                            <p>📧 swarga.rt09@gmail.com</p>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-900 text-lg">Alamat Sekretariat</p>
                            <p>🏠 Jl. Raden Perang Lorong Amanah I, 1</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-emerald-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5 text-[13px] text-emerald-700 flex flex-col sm:flex-row justify-between">
            <p>© {{ date('Y') }} SWarga — Suara Warga RT 09.</p>
            <p>Dikembangkan untuk pelayanan publik yang lebih baik.</p>
        </div>
    </footer>
</body>
</html>
