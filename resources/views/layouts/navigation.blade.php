<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur border-b border-emerald-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-600 text-white font-semibold">
                            RT
                        </span>
                        <span class="font-semibold text-emerald-800">
                            Pengaduan Warga
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{-- Beranda (semua user yang login) --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Beranda
                    </x-nav-link>

                    {{-- Riwayat Pengaduan (KHUSUS warga / role = warga) --}}
                    @if(auth()->check() && auth()->user()->role === 'warga')
                        <x-nav-link :href="route('pengaduan.riwayat')" :active="request()->routeIs('pengaduan.riwayat')">
                            Riwayat Pengaduan
                        </x-nav-link>
                    @endif

                    {{--notifikasi--}}
                    @if(auth()->check() && auth()->user()->role === 'warga')
                        <x-nav-link :href="route('notif.index')" :active="request()->routeIs('notif.index')">
    Notifikasi
</x-nav-link>

                    @endif

                    {{-- Panel Admin (KHUSUS admin) --}}
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->is('admin/*')">
                            Panel Admin
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings: Nama + tombol Keluar (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                {{-- NOTIFIKASI: Hanya untuk role warga --}}
@php
    $unreadCount = Auth::user()->unreadNotifications()->count();
@endphp

<a href="{{ route('notif.index') }}" class="relative inline-flex items-center">
    <span class="text-2xl text-emerald-700 hover:text-emerald-900 transition">
        🔔
    </span>

    @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-semibold 
                     px-1.5 py-[1px] rounded-full shadow">
            {{ $unreadCount }}
        </span>
    @endif
</a>

                <div class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-900 text-sm font-medium">
                    {{ Auth::user()->name }}
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-full border border-emerald-600 text-sm font-semibold
                               text-emerald-700 bg-white hover:bg-emerald-50 hover:text-emerald-800 focus:outline-none transition"
                    >
                        Keluar
                    </button>
                </form>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 focus:outline-none focus:bg-emerald-50 focus:text-emerald-900 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-emerald-100 bg-white/95">
        {{-- Link utama (mobile) --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Beranda
            </x-responsive-nav-link>

            {{-- Riwayat Pengaduan untuk warga (role = warga) --}}
            @if(auth()->check() && auth()->user()->role === 'warga')
                <x-responsive-nav-link :href="route('pengaduan.riwayat')" :active="request()->routeIs('pengaduan.riwayat')">
                    Riwayat Pengaduan
                </x-responsive-nav-link>
            @endif

            {{-- notifikasi (role = warga) --}}
            @if(auth()->check() && auth()->user()->role === 'warga')
                <x-responsive-nav-link :href="route('notif.index')" :active="request()->routeIs('notif.index')">
    Notifikasi
</x-responsive-nav-link>

            @endif

            {{-- Panel Admin --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->is('admin/*')">
                    Panel Admin
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-100">
            <div class="px-4">
                <div class="font-medium text-base text-emerald-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-emerald-600">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>
                {{-- Notifikasi Mobile --}}
@php
    $unreadCount = Auth::user()->unreadNotifications()->count();
@endphp

<x-responsive-nav-link :href="route('notif.index')" :active="request()->routeIs('notif.index')">
    🔔 Notifikasi 
    @if($unreadCount > 0)
        <span class="ml-2 bg-red-500 text-white text-[10px] px-2 py-[2px] rounded-full">
            {{ $unreadCount }}
        </span>
    @endif
</x-responsive-nav-link>


                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
