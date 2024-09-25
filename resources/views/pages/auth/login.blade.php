<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telkom Akses - Login</title>
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
            padding: 0.75rem 2rem; /* Larger button with more padding */
            font-weight: 600;
            color: #fff;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-danger:hover {
            background-image: linear-gradient(to right, #ff914d, #ff4d4d);
            transform: scale(1.08); /* Increased scale on hover */
        }
        .form-check-label {
            color: red;
        }
        .logo {
            width: 300px; /* Larger logo */
            transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
            cursor: pointer; /* Show pointer cursor to indicate it's clickable */
        }
        .logo:hover {
            transform: scale(1.1); /* Slightly enlarge logo on hover */
            filter: brightness(2.0); /* Brighten logo on hover */
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-body {
            animation: fadeIn 1s ease-in-out;
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
                            <img src="https://seeklogo.com/images/T/telkom-akses-logo-7ECCB5449C-seeklogo.com.png" alt="Logo" class="logo mx-auto">
                            <div id="error-message" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                                <strong>Terjadi Kesalahan!</strong> <span id="error-text"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <form id="login-form" action="{{ url('/auth/login') }}" method="POST">
                                @csrf
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">NIK atau Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Masukkan NIK/username" required>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required id="password">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="showPassword">
                                        <label class="form-check-label" for="showPassword">Show password</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger">Login</button>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="btn btn-link text-white">Forgot Your Password?</a>
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
                    <h5 class="modal-title" id="verificationModalLabel">Kode Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="verification-form" action="{{ url('/auth/verify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="verification_code" class="form-label">Masukkan Kode Verifikasi</label>
                            <input type="text" class="form-control" id="verification_code" name="verification_code" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Verifikasi</button>
                        </div>
                    </form>
                    <div id="verification-error" class="alert alert-danger mt-3 d-none" role="alert">
                        Kode verifikasi yang anda masukkan salah atau telah kadaluarsa.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var clickCount = 0;
            
            // Handle logo clicks
            $('.logo').on('click', function() {
                clickCount++;
                if (clickCount === 4) {
                    window.location.href = '/auth/create-user';
                    clickCount = 0; // Reset click count after redirect
                }
            });

            // Handle login form submission
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        if (response.status === 'verification_required') {
                            $('#verificationModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        $('#error-text').text(response.message);
                        $('#error-message').removeClass('d-none');
                    }
                });
            });

            // Handle verification form submission
            $('#verification-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        $('#verification-error').removeClass('d-none');
                    }
                });
            });

            // Toggle password visibility
            $('#showPassword').on('change', function() {
                var passwordField = $('#password');
                if ($(this).is(':checked')) {
                    passwordField.attr('type', 'text');
                } else {
                    passwordField.attr('type', 'password');
                }
            });
        });
    </script>
</body>
</html>
