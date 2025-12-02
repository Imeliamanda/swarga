<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SWarga Admin')</title>

    {{-- Font & Icon --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- AdminLTE + Bootstrap (CDN) --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        {{-- Left navbar links --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.pengaduan.index') }}" class="nav-link">Data Pengaduan</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.timeline') }}" class="nav-link">Timeline Warga</a>
            </li>
        </ul>

        {{-- Right navbar --}}
        <ul class="navbar-nav ml-auto">
            {{-- Nama admin --}}
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link">
                    <i class="far fa-user"></i>
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </li>

            {{-- Tombol logout WAJIB POST --}}
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger my-1 mx-2">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        {{-- Brand Logo --}}
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">
                <strong>SWarga Admin</strong>
            </span>
        </a>

        {{-- Sidebar --}}
        <div class="sidebar">
            {{-- Sidebar Menu --}}
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                    role="menu">

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.pengaduan.index') }}"
                           class="nav-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-circle"></i>
                            <p>Data Pengaduan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.timeline') }}"
                           class="nav-link {{ request()->routeIs('admin.timeline') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stream"></i>
                            <p>Timeline Warga</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- CONTENT WRAPPER --}}
    <div class="content-wrapper">
        {{-- Header halaman (breadcrumb + title) --}}
        <section class="content-header">
            @yield('content-header')
        </section>

        {{-- Konten utama --}}
        <section class="content">
            @yield('content')
        </section>
    </div>

    {{-- FOOTER --}}
    <footer class="main-footer text-sm">
        <strong>© 2025 SWarga RT 09.</strong> Semua hak dilindungi.
        <div class="float-right d-none d-sm-inline-block">
            SWarga • Panel Admin
        </div>
    </footer>
</div>

{{-- JS: jQuery + Bootstrap + AdminLTE --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
