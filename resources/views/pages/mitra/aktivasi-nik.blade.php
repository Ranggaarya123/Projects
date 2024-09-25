@extends('layouts.private')

@section('title', 'Telkom Akses - Dashboard')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Aktivasi NIK</h3>
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
            <form action="{{ url('/mitra/upload/aktivasi-nik') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan BPJS</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="scan_bpjs" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="scan_ktp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sertifikat Brevet</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="sertifikat_brevet" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger mt-4">Submit</button>
            </form>
        </div>
    </div>
@endsection