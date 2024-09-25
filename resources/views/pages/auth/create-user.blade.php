<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telkom Akses - Tambah Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ff4d4d, #ff914d);
        }
        main {
            background-image: url('{{ asset('storage/images/PPTA.jpg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .container {
            z-index: 1;
        }
        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            background-color: rgba(255, 255, 255, 0.3);
        }
        .card-body {
            padding: 2rem;
        }
        .form-label {
            color: #fff;
        }
        .form-control {
            border-radius: 10px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #ff914d;
            box-shadow: 0 0 10px rgba(255, 145, 77, 0.7);
        }
        .btn-danger {
            background-image: linear-gradient(to right, #ff4d4d, #ff914d);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem; /* Sama dengan tombol login */
            font-weight: 600;
            color: #fff;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-danger:hover {
            background-image: linear-gradient(to right, #ff914d, #ff4d4d);
            transform: scale(1.08);
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <main class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <section class="container">
            <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                <div class="card w-50">
                    <div class="card-body py-4">
                        <div class="d-flex flex-column gap-4">
                            <h2 class="text-center mb-4 text-white">Tambah Pengguna Baru</h2>
                            
                            <!-- Alert sukses -->
                            <div id="success-message" class="alert alert-success d-none">
                                Pengguna berhasil ditambahkan.
                            </div>

                            <!-- Alert error -->
                            <div id="error-message" class="alert alert-danger d-none">
                                Terjadi kesalahan. Silakan coba lagi.
                            </div>

                            <form id="user-form" action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">NIK Pengguna</label>
                                        <input type="text" class="form-control" id="id" name="id" placeholder="Masukkan NIK pengguna">
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Telegram ID</label>
                                        <input type="text" class="form-control" id="telegram_id" name="telegram_id" placeholder="Masukkan Telegram ID">
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Pilih Role</option>
                                            <option value="HCM">HCM</option>
                                            <option value="USER">USER</option>
                                            <option value="MITRA">MITRA</option>
                                            <option value="PERFORMANCE">PERFORMANCE</option>
                                            <option value="FA">FA</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger w-100">Tambah Pengguna</button>
                                    </div>
                                    <div class="card-footer text-center  border-top-0">
                                        <a href="{{ route('login') }}" class="btn-link">Back to Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Kode Verifikasi -->
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Kode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="verification-form" action="{{ route('user.verify.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="verification_code" class="form-label">Masukkan Kode Verifikasi</label>
                            <input type="text" class="form-control" id="verification_code" name="verification_code" required>
                        </div>
                        <div id="verification-error" class="alert alert-danger d-none">
                            Kode verifikasi salah atau telah kadaluarsa.
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#user-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.status === 'verification_sent') {
                            // Tampilkan modal verifikasi
                            $('#verificationModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                        $('#error-message').html(errorMessage).removeClass('d-none');
                    }
                });
            });

            // Handle verification form submission
            $('#verification-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#verificationModal').modal('hide');
                            $('#success-message').removeClass('d-none');
                            // Reset form
                            $('#user-form')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        $('#verification-error').removeClass('d-none');
                    }
                });
            });

            // Hide error messages when modal is closed
            $('#verificationModal').on('hidden.bs.modal', function () {
                $('#verification-error').addClass('d-none');
            });
        });
    </script>
</body>
</html>
