<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #778899;">
    <div class="container-fluid px-4 py-1">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- Additional navigation items can be added here if needed -->
        </div>
        <div class="d-flex align-items-center gap-3 ml-auto">
            <p class="my-0 text-white">{{ Auth::user()->username }}</p>
            <div class="profile-img fw-semibold text-white d-flex justify-content-center align-items-center rounded-circle shadow" style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.3);">
                {{ strtoupper(Auth::user()->username[0]) }}
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .profile-img {
        font-size: 1.2rem;
        font-weight: bold;
    }
    footer.navbar {
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }
</style>
