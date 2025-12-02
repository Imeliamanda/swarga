<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tentang RT 09 - SWarga</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-emerald-50 via-white to-emerald-50">

    {{-- NAVBAR --}}
    <header class="border-b border-emerald-100 bg-white/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white font-semibold text-lg">
                    SW
                </span>
                <div>
                    <p class="font-bold text-emerald-900 text-lg leading-tight">SWarga</p>
                    <p class="text-[11px] text-emerald-600 -mt-1">Suara Warga • RT 09</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('welcome') }}" class="text-emerald-800 hover:text-emerald-900">Beranda</a>
                <a href="{{ route('tentang-rt') }}" class="font-semibold text-emerald-900">Tentang RT 09</a>
            </nav>

            <div class="text-sm">
                <a href="{{ route('login') }}" class="text-emerald-700 hover:text-emerald-900">Masuk</a>
            </div>
        </div>
    </header>

    {{-- HEADER SECTION --}}
    <section class="text-center py-14">
        <p class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">
            Profil Lengkap Pengurus
        </p>
        <h1 class="mt-4 text-4xl font-extrabold text-emerald-900">Struktur Pengurus RT 09</h1>
        <p class="mt-3 text-emerald-700 max-w-2xl mx-auto">
            Berikut adalah daftar pengurus resmi RT 09 beserta tugas dan tanggung jawabnya.
        </p>
    </section>

    {{-- FOTO & PROFIL PENGURUS --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 py-10">
        <div class="grid md:grid-cols-3 gap-8">

            {{-- KETUA RT --}}
            <div class="bg-white border border-emerald-100 rounded-2xl shadow-md p-5 text-center space-y-3">
                <img src="{{ asset('foto_pengurus/ketua.jpg') }}"
                     class="h-40 w-40 object-cover rounded-full mx-auto shadow-md border border-emerald-200"
                     alt="Foto Ketua RT">
                <h3 class="text-xl font-bold text-emerald-900 mt-2">Syafrizal</h3>
                <p class="text-sm text-emerald-600 font-semibold">Ketua RT 09</p>
                <p class="text-sm text-emerald-700">
                    Memimpin koordinasi lingkungan, memantau pengaduan warga, dan memastikan ketertiban RT.
                </p>
                <p class="text-sm text-emerald-700">📞 081234435665</p>
            </div>

            {{-- SEKRETARIS --}}
            <div class="bg-white border border-emerald-100 rounded-2xl shadow-md p-5 text-center space-y-3">
                <img src="{{ asset('foto_pengurus/sekretaris.jpg') }}"
                     class="h-40 w-40 object-cover rounded-full mx-auto shadow-md border border-emerald-200"
                     alt="Foto Sekretaris RT">
                <h3 class="text-xl font-bold text-emerald-900 mt-2">Teguh Putra</h3>
                <p class="text-sm text-emerald-600 font-semibold">Sekretaris RT 09</p>
                <p class="text-sm text-emerald-700">
                    Mengurus administrasi, pencatatan, dan surat menyurat serta mendampingi ketua RT.
                </p>
                <p class="text-sm text-emerald-700">📞 082310293847</p>
            </div>

            {{-- BENDAHARA --}}
            <div class="bg-white border border-emerald-100 rounded-2xl shadow-md p-5 text-center space-y-3">
                <img src="{{ asset('foto_pengurus/bendahara.jpg') }}"
                     class="h-40 w-40 object-cover rounded-full mx-auto shadow-md border border-emerald-200"
                     alt="Foto Bendahara RT">
                <h3 class="text-xl font-bold text-emerald-900 mt-2">Rehan Fiandra</h3>
                <p class="text-sm text-emerald-600 font-semibold">Bendahara RT 09</p>
                <p class="text-sm text-emerald-700">
                    Mengelola keuangan RT, pencatatan iuran, dan transparansi dana warga.
                </p>
                <p class="text-sm text-emerald-700">📞 08120899675</p>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-emerald-100 bg-white py-5">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 text-sm text-emerald-700 flex justify-between">
            <p>© {{ date('Y') }} SWarga — Suara Warga RT 09.</p>
            <p>Halaman Profil Pengurus RT 09.</p>
        </div>
    </footer>

</body>
</html>
