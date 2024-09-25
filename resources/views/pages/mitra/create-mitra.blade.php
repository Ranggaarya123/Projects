@extends('layouts.private')

@section('title', 'Telkom Akses - Dashboard')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Create NIK Baru</h3>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
        @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi Kesalahan!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ url('/mitra/upload/create-mitra') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">KHS Mitra (MYTA) <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="khs_mitra" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan BPJS (Jika tdk ada lampirkan BA KESEPAKATAN BPJSTK) <strong>(.pdf)</strong> Sesuai format berikut: </label>
                        <a href="https://docs.google.com/spreadsheets/d/1WhmCPY65dd2LRa--UVnqjvdOLeLKZwoN/edit?usp=drive_link&ouid=107555758714883261984&rtpof=true&sd=true" target="_blank" class="ms-2">Lihat Contoh</a>
                        <input type="file" class="form-control" name="scan_bpjs" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="scan_ktp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto Mitra <strong>(.jpg/.jpeg/.png)</strong> (contoh:)</label>
                        <a href="{{ asset('contoh/fotomitra.jpg') }}" target="_blank" class="ms-2">Lihat Foto</a>
                        <input type="file" class="form-control" name="foto_mitra" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Created NIK Mitra <strong>(.xls/.xlsx)</strong> (format sebagai berikut:)</label>
                        <a href="https://docs.google.com/spreadsheets/d/1iiR6rdJmDU8FAR2JfYICGXPxcEdP9s7z4zu178obSUE/edit?usp=sharing" target="_blank" class="ms-2">Lihat Contoh</a>
                        <input type="file" class="form-control" name="excelcreate_nikmitra" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger mt-4">Submit</button>
            </form>
        </div>
    </div>
@endsection
