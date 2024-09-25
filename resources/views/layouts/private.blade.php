<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <script src="https://kit.fontawesome.com/255fd51aa4.js" crossorigin="anonymous"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3; /* Adjust the opacity as needed */
            background-image: url('https://i.ytimg.com/vi/MvP-gEcYP7k/maxresdefault.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(5px); /* Slight blur for a more aesthetic effect */
        }
        .content {
            margin-left: 250px; /* Same as sidebar width */
            padding: 0px;
            margin-bottom: 50px; /* Make space for the bottom navbar */
        }
        .main-content {
            margin-top: 56px; /* Adjust if navbar height changes */
        }
        .navbar.fixed-top {
            position: fixed;
            top: 0;
            left: 250px; /* Same as sidebar width */
            width: calc(100% - 250px);
            z-index: 1000;
        }
        .navbar-container {
            margin-top: 56px; /* Adjust based on navbar height */
        }
        .navbar-bottom {
            position: fixed;
            bottom: 0;
            left: 250px; /* Same as sidebar width */
            width: calc(100% - 250px);
            background-color: #778899; /* Same color as the top navbar for consistency */
            color: white;
            text-align: left;
            padding: 10px 20px; /* Padding to give space from the edges */
            z-index: 1000;
        }

        /* Add keyframes for the color-changing animation */
        @keyframes colorChange {
            0% {
                color: white; /* Red */
            }
            50% {
                color: grey; /* Blue */
            }
        }

        /* Apply the color-changing animation to the footer */
        .animated-footer {
            position: fixed;
            animation: colorChange 5s linear infinite;
            padding: 10px 0; /* Some padding for spacing */
            bottom: 0;
            left: 250px; /* Same as sidebar width */
            width: calc(100% - 250px);
            font-size: 1.2rem; /* Increase the font size */
            background-color: #778899; /* Light grey background */
            text-align: left;
            padding: 10px 20px; /* Padding to give space from the edges */
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    @include('components/sidebar')
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #778899;">
            <div class="container-fluid px-4 py-1">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <!-- Additional navigation items can be added here if needed -->
                </div>
                <div class="d-flex align-items-center gap-3 ml-auto">
                    <p class="my-0 text-white">{{ Auth::user()->username }} - ({{ Auth::user()->role }})</p>
                    <div class="profile-img fw-semibold text-white d-flex justify-content-center align-items-center rounded-circle shadow" style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.3);">
                        {{ strtoupper(Auth::user()->username[0]) }}
                    </div>
                </div>
            </div>
        </nav>
        <div class="px-5 py-4 navbar-container">
            <div class="p-4 rounded shadow-sm" style="background-color: ;">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="navbar-bottom animated-footer">
        © Copyright 2024. All Rights Reserved By Telkom Akses Yogyakarta
    </footer>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
