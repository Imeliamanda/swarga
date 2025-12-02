@php
    use Illuminate\Support\Facades\Storage;

    function badgeStatus($status)
    {
        if ($status === 'diproses') {
            return '<span class="badge badge-warning">Diproses</span>';
        }
        if ($status === 'selesai') {
            return '<span class="badge badge-primary">Selesai</span>';
        }
        return '<span class="badge badge-success">Baru</span>';
    }
@endphp

@extends('layouts.admin')

@section('page-header')
    <h1 class="m-0 text-dark">Detail & Tindak Lanjut Pengaduan</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pengaduan.index') }}">Data Pengaduan</a></li>
        <li class="breadcrumb-item active">Detail Pengaduan</li>
    </ol>
@endsection

@section('content')

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tombol kembali --}}
    <div class="mb-3">
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Data Pengaduan
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: DETAIL PENGADUAN --}}
        <div class="col-lg-7 col-md-12">

            <div class="card card-outline card-success mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title">Detail Pengaduan Warga</h3>
                    </div>
                    <div class="text-right text-sm">
                        {!! badgeStatus($pengaduan->status) !!}
                    </div>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">ID Pengaduan</dt>
                        <dd class="col-sm-8">#{{ $pengaduan->id }}</dd>

                        <dt class="col-sm-4 text-muted">Nama Warga</dt>
                        <dd class="col-sm-8">{{ $pengaduan->user->name ?? 'Warga RT 09' }}</dd>

                        <dt class="col-sm-4 text-muted">Tanggal Laporan</dt>
                        <dd class="col-sm-8">
                            {{ $pengaduan->created_at->translatedFormat('d M Y, H:i') }}
                        </dd>
                    </dl>

                    <hr>

                    <h6 class="text-muted mb-2">Isi Pengaduan</h6>
                    <p class="border rounded p-3 mb-0" style="white-space: pre-line;">
                        {{ $pengaduan->isi }}
                    </p>

                    @if($pengaduan->foto)
                        <hr>
                        <h6 class="text-muted mb-2">Foto Pengaduan dari Warga</h6>
                        <div class="border rounded p-2 bg-light text-center">
                            <img src="{{ Storage::url($pengaduan->foto) }}"
                                 alt="Foto pengaduan"
                                 class="img-fluid rounded">
                        </div>
                    @endif
                </div>
            </div>

            {{-- PREVIEW YANG AKAN DILIHAT WARGA --}}
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Preview Tanggapan RT (Tampilan di Aplikasi Warga)</h3>
                </div>
                <div class="card-body">
                    @if($pengaduan->catatan_admin || $pengaduan->foto_proses)
                        <div class="border rounded p-3 bg-emerald-50" style="background-color:#f0fbf7;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-2"
                                     style="width:32px;height:32px;font-size:12px;">
                                    RT
                                </div>
                                <div>
                                    <div class="font-weight-semibold" style="font-size: 13px;">Tindak Lanjut Pengurus RT</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        Catatan ini akan terlihat oleh warga sebagai bukti bahwa laporan diproses.
                                    </div>
                                </div>
                            </div>

                            @if($pengaduan->catatan_admin)
                                <p class="mb-2" style="font-size: 13px; white-space: pre-line;">
                                    "{{ $pengaduan->catatan_admin }}"
                                </p>
                            @endif

                            @if($pengaduan->foto_proses)
                                <div class="mt-2 border rounded bg-white p-2 text-center">
                                    <img src="{{ Storage::url($pengaduan->foto_proses) }}"
                                         alt="Foto proses penanganan"
                                         class="img-fluid rounded">
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Belum ada catatan atau foto proses dari pengurus RT.<br>
                            Tambahkan pada formulir di sebelah kanan agar warga mengetahui tindak lanjutnya.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM STATUS & TINDAK LANJUT --}}
        <div class="col-lg-5 col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Status & Tindak Lanjut Admin</h3>
                </div>

                <form action="{{ route('admin.pengaduan.update', $pengaduan->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- STATUS --}}
                        <div class="form-group">
                            <label for="status">Status Pengaduan</label>
                            <select name="status" id="status" class="form-control">
                                <option value="baru" {{ $pengaduan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <small class="form-text text-muted">
                                Sesuaikan dengan progres penanganan (contoh: Baru → Diproses → Selesai).
                            </small>
                        </div>

                        {{-- CATATAN ADMIN --}}
                        <div class="form-group">
                            <label for="catatan_admin">Catatan untuk Warga / Tindak Lanjut RT</label>
                            <textarea
                                name="catatan_admin"
                                id="catatan_admin"
                                rows="4"
                                class="form-control"
                                placeholder="Contoh: Sudah dicek oleh pengurus RT, akan dilakukan pembersihan selokan hari Minggu pagi.">{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                            <small class="form-text text-muted">
                                Catatan ini akan ditampilkan di aplikasi warga sebagai tanggapan resmi dari RT.
                            </small>
                        </div>

                        {{-- FOTO PROSES --}}
                        <div class="form-group">
                            <label for="foto_proses">Foto Proses / Bukti Tindak Lanjut (opsional)</label>
                            <input type="file"
                                   name="foto_proses"
                                   id="foto_proses"
                                   class="form-control-file"
                                   accept="image/*">
                            <small class="form-text text-muted">
                                Format: jpg, jpeg, png, maks 2 MB. Misalnya foto petugas sedang memperbaiki / membersihkan.
                            </small>

                            @if($pengaduan->foto_proses)
                                <div class="mt-2 border rounded p-2 bg-light text-center">
                                    <p class="text-muted mb-2" style="font-size: 12px;">Foto proses saat ini:</p>
                                    <img src="{{ Storage::url($pengaduan->foto_proses) }}"
                                         alt="Foto proses penanganan"
                                         class="img-fluid rounded">
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-info mb-0" style="font-size: 13px;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Status, catatan, dan foto proses akan langsung terlihat oleh warga di aplikasi SWarga.
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
