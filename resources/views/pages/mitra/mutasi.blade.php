@extends('layouts.private')

@section('title', 'Telkom Akses - Mutasi')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Mutasi</h3>
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
            <form action="{{ url('/mitra/upload/mutasi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Pilih Mutasi</label>
                    <select class="form-control" id="mutasi-type" name="mutasi_type" required>
                        <option value="">Pilih Mutasi</option>
                        <option value="mutasi-area">Mutasi Area</option>
                        <option value="mutasi-unit">Mutasi Unit</option>
                        <option value="mutasi-mitra">Mutasi Mitra</option>
                    </select>
                </div>
                <div id="form-fields" class="d-flex flex-column gap-4 mt-4">
                    <!-- Dynamic form fields will be injected here -->
                </div>
                <button type="submit" class="btn btn-danger mt-4">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('mutasi-type').addEventListener('change', function() {
            var formFields = document.getElementById('form-fields');
            formFields.innerHTML = ''; // Clear previous fields

            var selectedType = this.value;
            if (selectedType === 'mutasi-area') {
                formFields.innerHTML += `
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra di Area Baru</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="scan_ktp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sertifikat Brevet</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="brevet" required>
                    </div>
                `;
            } else if (selectedType === 'mutasi-unit') {
                formFields.innerHTML += `
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra di Unit Baru</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="scan_ktp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sertifikat Brevet</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="brevet" required>
                    </div>
                `;
            }else if (selectedType === 'mutasi-mitra') {
                formFields.innerHTML += `
                    <div class="d-flex flex-column gap-1">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Keterangan Aktif Mitra Baru</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="surat_keterangan_aktif" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="scan_ktp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sertifikat Brevet</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="brevet" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Surat Pakelaring</label><strong>(.pdf)</strong>
                        <input type="file" class="form-control" name="surat_pakelaring" required>
                    </div>
                `;
            }
        });
    </script>
@endsection
