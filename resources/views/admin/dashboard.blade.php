@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- KARTU RINGKASAN --}}
        <div class="row">
            {{-- Total Pengaduan --}}
            <div class="col-lg-4 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalPengaduan ?? 0 }}</h3>
                        <p>Total Pengaduan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    {{-- PENTING: route admin, BUKAN route('dashboard') --}}
                    <a href="{{ route('admin.pengaduan.index') }}" class="small-box-footer">
                        Lihat semua <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Pengaduan Baru --}}
            <div class="col-lg-4 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pengaduanBaru ?? 0 }}</h3>
                        <p>Pengaduan Baru</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    {{-- arahkan ke data pengaduan admin dengan filter status=baru --}}
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'baru']) }}" class="small-box-footer">
                        Lihat detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Pengaduan Sedang Diproses --}}
            <div class="col-lg-4 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $pengaduanDiproses ?? 0 }}</h3>
                        <p>Pengaduan Sedang Diproses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    {{-- filter status=diproses --}}
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'diproses']) }}" class="small-box-footer">
                        Lihat detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- {{-- (Opsional) kartu untuk selesai, kalau mau --}}
        {{-- 
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $pengaduanSelesai ?? 0 }}</h3>
                        <p>Pengaduan Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('admin.pengaduan.index', ['status' => 'selesai']) }}" class="small-box-footer">
                        Lihat detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        --}} -->

        {{-- RINGKASAN SISTEM --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Sistem</h3>
                    </div>
                    <div class="card-body">
                        <p>
                            Selamat datang di <strong>Panel Admin SWarga</strong>. Di halaman ini pengurus RT dapat
                            memantau seluruh pengaduan warga, mengubah status, dan mengakses timeline warga.
                        </p>
                        <ul>
                            <li>
                                Menu <strong>Data Pengaduan</strong> untuk melihat list pengaduan
                                dalam bentuk tabel.
                            </li>
                            <li>
                                Menu <strong>Timeline Warga</strong> untuk melihat tampilan pengaduan
                                seperti beranda SWarga.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
