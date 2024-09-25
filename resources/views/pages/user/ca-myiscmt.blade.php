@extends('layouts.private')

@section('title', 'Telkom Akses - Create/Aktivasi MYI-SCMT')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">Form Create/Aktivasi MYI-SCMT</h3>
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
            <form action="{{ url('/user/ca-myiscmt') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Pilih Request :</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="create-myi" name="myiscmt_types[]" value="create-myi">
                        <label class="form-check-label" for="create-myi">
                            Create MYI <strong>*( Naker Baru )</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aktivasi-myi" name="myiscmt_types[]" value="aktivasi-myi">
                        <label class="form-check-label" for="aktivasi-myi">
                            Aktivasi MYI <strong>*( Bagi yang sudah pernah "Create MYI" )</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="create-scmt" name="myiscmt_types[]" value="create-scmt">
                        <label class="form-check-label" for="create-scmt">
                            Create SCMT <strong>*( Naker Baru )</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="aktivasi-scmt" name="myiscmt_types[]" value="aktivasi-scmt">
                        <label class="form-check-label" for="aktivasi-scmt">
                            Aktivasi SCMT <strong>*( Bagi yang sudah pernah "Create SCMT" )</strong>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="myiscmt_type_combined" id="myiscmt_type_combined">
                <div id="form-fields" class="row mt-4">
                    <!-- Dynamic form fields will be injected here -->
                </div>
                <button type="submit" class="btn btn-danger mt-4">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="myiscmt_types[]"]').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                var selectedTypes = Array.from(document.querySelectorAll('input[name="myiscmt_types[]"]:checked')).map(cb => cb.value);
                var combinedType = selectedTypes.join('/');
                document.getElementById('myiscmt_type_combined').value = combinedType;

                var formFields = document.getElementById('form-fields');
                formFields.innerHTML = ''; // Clear previous fields

                if (selectedTypes.length > 0) {
                    formFields.innerHTML = `
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" name="user_id" placeholder="Masukkan NIK" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">Email Corporate</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">ID Telegram</label>
                            <input type="text" class="form-control" name="id_tele" placeholder="Masukkan ID Telegram" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">No. HP (Wajib Telkomsel)</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No. HP" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">STO</label>
                            <input type="text" class="form-control" name="sto" placeholder="Masukkan STO" required>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-1">
                            <label class="form-label">Kode WH</label>
                            <input type="text" class="form-control" name="kode_wh" placeholder="Masukkan Kode WH" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Capture HCMBOT</label>
                            <input type="file" class="form-control" name="capture_hcmbot" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Capture Tactical</label>
                            <input type="file" class="form-control" name="capture_tactical" required>
                        </div>
                    `;
                }
            });
        });
    </script>
@endsection
