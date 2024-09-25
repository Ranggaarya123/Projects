<div class="sidebar bg-light-gray p-4">
<div class="text-center mb-4">
    <div class="logo-container bg-white p-3 shadow-sm d-inline-block">
        <img src="https://seeklogo.com/images/T/telkom-akses-logo-7ECCB5449C-seeklogo.com.png" alt="Logo" class="img-fluid logo-animation">
    </div>
</div>
    <ul class="nav flex-column gap-3">
        @if (Auth::user()->role === 'HCM')
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/hcm') }}">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-check-square-o"></i>
                    Approval
                    @if (isset($totalPending) && $totalPending > 0)
                        <span class="badge bg-danger">{{ $totalPending }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/hcm/approval/aktivasi-nik') }}">
                            Aktivasi NIK
                            @if (isset($aktivasiNikPending) && $aktivasiNikPending > 0)
                                <span class="badge bg-danger">{{ $aktivasiNikPending }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/hcm/approval/nonaktif-nik') }}">
                            NonAktif NIK
                            @if (isset($nonaktifNikPending) && $nonaktifNikPending > 0)
                                <span class="badge bg-danger">{{ $nonaktifNikPending }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/hcm/approval/mutasi') }}">
                            Mutasi
                            @if (isset($mutasiNikPending) && $mutasiNikPending > 0)
                                <span class="badge bg-danger">{{ $mutasiNikPending }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/hcm/approval/create-mitra') }}">
                            Create NIK Baru
                            @if (isset($createMitraPending) && $createMitraPending > 0)
                                <span class="badge bg-danger">{{ $createMitraPending }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-info-circle"></i>
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/hcm/status/statushcm') }}">All Status</a></li>
                    <li><a class="dropdown-item" href="{{ url('/hcm/status/status_brevet') }}">Brevet Mitra</a></li>
                </ul>
            </li>
        @elseif (Auth::user()->role === 'USER')
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/user') }}">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-upload"></i>
                    Upload
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/user/validasi-tactical') }}">Validasi Tactical</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-hand"></i>
                    Request
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/user/ca-myiscmt') }}">MYI-SCMT</a></li>
                    <li><a class="dropdown-item" href="{{ url('/user/duplicate-wh') }}">Duplicate WH</a></li>
                    <li><a class="dropdown-item" href="{{ url('/user/pindah-wh') }}">Pindah WH</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-info-circle"></i>
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/user/status/status') }}">All Status</a></li>
                </ul>
            </li>
        @elseif (Auth::user()->role === 'PERFORMANCE')
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/performance') }}">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-check-square-o"></i>
                    Approval
                    @if (isset($totalPending) && $totalPending > 0)
                        <span class="badge bg-danger">{{ $totalPending }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/performance/validasi-tactical') }}">
                            Validasi Tactical
                            @if (isset($validasitacticalPending) && $validasitacticalPending > 0)
                                <span class="badge bg-danger">{{ $validasitacticalPending }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/performance/ca-myiscmt') }}">
                            MYI-SCMT
                            @if (isset($createaktivasiMyiSCMTPending) && $createaktivasiMyiSCMTPending > 0)
                                <span class="badge bg-danger">{{ $createaktivasiMyiSCMTPending }}</span>
                            @endif
                        </a></li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/performance/duplicate-wh') }}">
                            Duplicate WH
                            @if (isset($duplicatePending) && $duplicatePending > 0)
                                <span class="badge bg-danger">{{ $duplicatePending }}</span>
                            @endif
                        </a></li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/performance/pindah-wh') }}">
                            Pindah WH
                            @if (isset($pindahPending) && $pindahPending > 0)
                                <span class="badge bg-danger">{{ $pindahPending }}</span>
                            @endif
                        </a></li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-info-circle"></i>
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/performance/status/statusperformance') }}">All Status</a></li>
                    <li><a class="dropdown-item" href="{{ url('/performance/status/status_brevet') }}">Brevet Mitra</a></li>
                </ul>
            </li>
        @elseif (Auth::user()->role === 'MITRA')
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/mitra') }}">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-upload"></i>
                    Upload
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/mitra/upload/create-mitra') }}">Create NIK Baru</a></li>
                    <li><a class="dropdown-item" href="{{ url('/mitra/upload/aktivasi-nik') }}">Aktivasi NIK</a></li>
                    <li><a class="dropdown-item" href="{{ url('/mitra/upload/nonaktif-nik') }}">Non-Aktif NIK</a></li>
                    <li><a class="dropdown-item" href="{{ url('/mitra/upload/mutasi') }}">Mutasi</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-hand-paper"></i>
                    Request
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/mitra/brevet') }}">Brevet</a></li>
                    <li><a class="dropdown-item" href="{{ url('/user/ca-myiscmt') }}">MYI-SCMT</a></li>
                    <li><a class="dropdown-item" href="{{ url('/user/duplicate-wh') }}">Duplicate WH</a></li>
                    <li><a class="dropdown-item" href="{{ url('/user/pindah-wh') }}">Pindah WH</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-info-circle"></i>
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('/mitra/status/status') }}">All Status</a></li>
                    <li><a class="dropdown-item" href="{{ url('/mitra/status/status_brevet') }}">Upload Sertifikat Brevet</a></li>
                    <li><a class="dropdown-item" href="{{ url('/mitra/status/status_createmitra') }}">Create NIK Baru</a></li>
                </ul>
            </li>
        @elseif (Auth::user()->role === 'FA')
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/fa') }}">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="dropdown">
                <button class="nav-link text-light d-flex align-items-center gap-3 p-2 btn btn-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa fa-check-square-o"></i>
                    Approval
                    @if (isset($totalPending) && $totalPending > 0)
                        <span class="badge bg-danger">{{ $totalPending }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/fa/approval/brevet') }}">
                        Brevet
                        @if (isset($brevetPending) && $brevetPending > 0)
                                <span class="badge bg-danger">{{ $brevetPending }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="{{ url('/fa/status/status_brevet') }}">
                    <i class="fa-solid fa-info-circle"></i>
                    Status Brevet
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link text-light d-flex align-items-center gap-3 p-2" href="/auth/logout">
                <i class="fa-solid fa fa-sign-out-alt"></i>
                Logout
            </a>
        </li>
    </ul>
</div>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<style>
    .bg-light-gray {
        background-color: #778899;
    }
    .sidebar {
        position: fixed;
        width: 250px;
        height: 100vh;
        top: 0;
        left: 0;
        overflow-y: auto;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }
    .nav-link {
        color: #ddd;
        transition: background-color 0.3s, color 0.3s;
    }
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .dropdown-toggle::after {
        margin-left: auto;
    }
    .btn-transparent {
        background: transparent;
        border: none;
        padding: 0;
        margin: 0;
        box-shadow: none;
    }
    .dropdown-menu {
        width: 100%;
        border-radius: 0;
        box-shadow: none;
        border: none;
        background-color: rgba(255, 255, 255, 0.85);
    }
    .dropdown-item {
        color: #333;
        transition: background-color 0.3s, color 0.3s;
    }
    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #000;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    /* Custom styling for the dropdown button */
    .dropdown button {
        background-color: #778899; /* Green background */
        border: none; /* Remove borders */
        color: white; /* White text */
        padding: 10px 20px; /* Some padding */
        font-size: 16px; /* Set a font size */
        cursor: pointer; /* Pointer/hand icon */
        transition: background-color 0.3s; /* Smooth transition for background color */
    }

    .dropdown button:hover {
        background-color: silver; /* Darker green on hover */
    }

    /* Custom styling for the dropdown menu */
    .dropdown-menu {
        background-color: White; /* Light grey background */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); /* Add a shadow */
        border-radius: 8px; /* Rounded corners */
        margin-top: 10px; /* Some space from the button */
        transition: all 0.3s ease-in-out; /* Smooth transition for dropdown */
    }

    /* Custom styling for the dropdown items */
    .dropdown-item {
        padding: 12px 16px; /* Add some padding */
        text-decoration: none; /* Remove underline */
        display: block; /* Make it a block element */
        color: #333; /* Dark text color */
        transition: background-color 0.3s, color 0.3s; /* Smooth transition for background and text color */
    }

    .dropdown-item:hover {
        background-color: #ddd; /* Light grey background on hover */
        color: #000; /* Black text on hover */
    }


    /* Add keyframes for the floating animation */
    @keyframes float {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0);
        }
    }

    /* Apply the floating animation to the logo */
    .logo-animation {
        animation: float 3s ease-in-out infinite;
    }

    /* Optional: Add some hover effects */
    .logo-animation:hover {
        animation-play-state: paused; /* Pause the animation on hover */
        transform: scale(1.1); /* Slightly enlarge the logo on hover */
        transition: transform 0.3s ease-in-out;
    }

    /* Styling for the logo container */
    .logo-container {
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
        display: inline-block; /* Make the container inline-block */
    }
</style>
