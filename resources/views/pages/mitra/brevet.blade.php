@extends('layouts.private')

@section('title', 'Telkom Akses - Dashboard')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Brevet</h3>
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
            <form action="{{ url('/mitra/brevet') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Mitra</label>
                        <input type="text" class="form-control" name="mitra" placeholder="Masukkan mitra" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Brevet</label>
                        <input type="text" class="form-control" name="brevet" placeholder="Masukkan brevet" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan BPJS/BA KESEPAKATAN BPJSTK <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="bpjs" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Sertifikat Brevet Expired <strong>(.pdf)</strong></label>
                        <input type="file" class="form-control" name="sertifikat_brevet" required>
                    </div>
                </div>
                <button class="btn btn-danger mt-4" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
