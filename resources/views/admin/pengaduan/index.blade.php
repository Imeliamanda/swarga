@extends('layouts.admin')

@section('page-header')
    <h1 class="m-0 text-dark">Data Pengaduan Warga</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Data Pengaduan</li>
    </ol>
@endsection

@section('content')
    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Pengaduan</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Warga</th>
                        <th>Isi Pengaduan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Prioritas</th> <!-- Kolom Prioritas -->
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pengaduans as $pengaduan)
                    <tr>
                        <td>#{{ $pengaduan->id }}</td>

                        <td>{{ $pengaduan->user->name ?? '-' }}</td>

                        <td>{{ \Illuminate\Support\Str::limit($pengaduan->isi, 40) }}</td>

                        {{-- 📍 Lokasi --}}
                        <td>
                            @if($pengaduan->lokasi_text)
                                <div class="text-xs">
                                    {{ \Illuminate\Support\Str::limit($pengaduan->lokasi_text, 40) }}
                                </div>
                            @endif

                            @if($pengaduan->lokasi_maps)
                                <a href="{{ $pengaduan->lokasi_maps }}"
                                   target="_blank"
                                   class="d-inline-block text-xs text-primary">
                                    Maps ↗
                                </a>
                            @endif
                        </td>

                        {{-- 🔄 Status (bisa diubah) --}}
                        <td>
                            <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        class="custom-select custom-select-sm"
                                        onchange="this.form.submit()">
                                    <option value="baru" {{ $pengaduan->status === 'baru' ? 'selected' : '' }}>
                                        Baru
                                    </option>
                                    <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                </select>
                            </form>
                        </td>

                        {{-- Prioritas --}}
                        {{-- Prioritas --}}
<td>
    <form action="{{ route('admin.pengaduan.updatePrioritas', $pengaduan->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')

        <select name="prioritas" class="custom-select custom-select-sm" onchange="this.form.submit()">
            <option value="darurat" {{ $pengaduan->prioritas === 'darurat' ? 'selected' : '' }}>🟥 Darurat</option>
            <option value="tinggi" {{ $pengaduan->prioritas === 'tinggi' ? 'selected' : '' }}>🟧 Tinggi</option>
            <option value="sedang" {{ $pengaduan->prioritas === 'sedang' ? 'selected' : '' }}>🟨 Sedang</option>
            <option value="rendah" {{ $pengaduan->prioritas === 'rendah' ? 'selected' : '' }}>🟩 Rendah</option>
        </select>
    </form>
</td>


                        <td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td>

                        {{-- ✏️ Aksi --}}
                        <td>
                            <a href="{{ route('admin.pengaduan.edit', $pengaduan->id) }}"
                               class="btn btn-xs btn-outline-primary">
                                <i class="fas fa-edit"></i> Ubah Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada pengaduan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $pengaduans->links() }}
        </div>
    </div>
@endsection
