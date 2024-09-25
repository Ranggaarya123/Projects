@extends('layouts.private')
@section('title', 'Telkom Akses - Status Pengajuan Brevet')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">Status Pengajuan Brevet</h3>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <!-- Search Input -->
            <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="my-2">List Status:</h5>
                <div class="input-group search-input-small">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" id="search" class="form-control" placeholder="Search By NIK">
                </div>
            </div>
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
            <!-- Data Table -->
            <table class="table table-striped table-hover" id="table-content">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Brevet</th>
                        <th>Status Brevet</th>
                        <th>Keterangan</th>
                        <th>Created At</th>
                        <th>Upload Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($createBrevet as $item)
                        <tr data-nik="{{ $item->user_id }}">
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->user_id }}</td>
                            <td>{{ $item->brevet }}</td>
                            <td>
                                @if ($item->status_brevet === 1)
                                    <span class="text-success">Done</span>
                                @elseif ($item->status_brevet === 2)
                                    <span class="text-danger">Reject</span>
                                @elseif ($item->status_brevet === 3)
                                    <span class="text-success">(Approved)</span>
                                @else
                                    <span class="text-warning">Review</span>
                                @endif
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @if ($item->status_brevet === 1)
                                    @if ($item->upload_sertifikat)
                                        <a href="{{ Storage::url($item->upload_sertifikat) }}" target="_blank" class="btn btn-secondary">Lihat Sertifikat</a>
                                    @else
                                        <form action="{{ route('brevet.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="upload_sertifikat" required>
                                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-danger">- Belum Done -</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- No Data Message -->
            <div id="no-data-message"  class="text-center text-danger mt-3" style="display: none; color: red;">
                - - - Data yang anda cari tidak ada!!! - - -
            </div>
        </div>
    </div>

    <!-- JavaScript for Search -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-content tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                const nik = row.getAttribute('data-nik').toLowerCase();
                if (nik.includes(searchValue)) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Display "No data" message if no rows are visible
            const noDataMessage = document.getElementById('no-data-message');
            noDataMessage.style.display = hasVisibleRows ? 'none' : 'block';
        });
    </script>

    <!-- Inline CSS -->
    <style>
        #search {
            width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
        }

        .thead-dark th {
            background-color: #343a40;
            color: white;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-warning {
            color: #ffc107;
        }

        .table-success {
            background-color: #d4edda;
        }

        .table-danger {
            background-color: #f8d7da;
        }

        .table-warning {
            background-color: #fff3cd;
        }

        #no-data-message {
            display: none;
            color: red;
        }
        .search-input-small {
            width: 300px; /* Adjust the width as needed */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .input-group-prepend .input-group-text {
            background-color: #fff;
            border-right: none;
        }
        .form-control {
            border-left: none;
            border-radius: 0 5px 5px 0;
        }
        .input-group-prepend .input-group-text .fa {
            color: #333;
        }
        .input-group-prepend {
            display: flex;
            align-items: center;
        }
        .input-group-text {
            height: 100%;
            border-radius: 5px 0 0 5px;
        }
        .bg-primary {
            background-color: #343a40 !important;
        }
        .text-white {
            color: #fff !important;
        }
    </style>
@endsection
