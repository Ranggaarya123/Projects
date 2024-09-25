@extends('layouts.private')

@section('title', 'Telkom Akses - MYI')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Pindah WH</h3>
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
            <form action="{{ url('/user/pindah-wh') }}" method="POST">
                @csrf
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">STO Sebelumnya</label>
                        <input type="text" class="form-control" name="sto_sebelum" placeholder="Masukkan STO Sebelumnya" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Kode WH Sebelumnya</label>
                        <input type="text" class="form-control" name="kode_wh_sebelum" placeholder="Masukkan Kode WH Sebelumnya" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">STO Tujuan</label>
                        <input type="text" class="form-control" name="sto_tujuan" placeholder="Masukkan STO Tujuan" required>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">Kode WH Tujuan</label>
                        <input type="text" class="form-control" name="kode_wh_tujuan" placeholder="Masukkan Kode WH Tujuan" required>
                    </div>
                </div>
                <button class="btn btn-danger mt-4" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection