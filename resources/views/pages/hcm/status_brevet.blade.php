@extends('layouts.private')
@section('title', 'Telkom Akses - Status Pengajuan Brevet Mitra')
@section('content')
        <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">Status Brevet Mitra</h3>
        </div>
    </div>
    <div class="card mt-4">
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
        <div class="card-body">
            @if($createBrevet->isEmpty())
                <div class="alert alert-info" role="alert">
                    - - Tidak Ada Data Yang Tersedia - -
                </div>
            @else
                <table class="table table-striped table-hover" id="table-content">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Brevet</th>
                            <th>Status Brevet</th>
                            <th>Keterangan</th>
                            <th>Time Created</th>
                            <th>Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($createBrevet as $item)
                            <tr data-user-id="{{ $item->user_id }}">
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->brevet }}</td>
                                <td>
                                    @if ($item->status_brevet === 1)
                                        <span class="text-success">Done</span>
                                    @elseif ($item->status_brevet === 2)
                                        <span class="text-danger">Reject</span>
                                    @elseif ($item->status_brevet === 3)
                                        <span class="text-warning">Approved</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if ($item->status_brevet === 1)
                                        @if ($item->upload_sertifikat)
                                            <a href="{{ Storage::url($item->upload_sertifikat) }}" target="_blank" class="btn btn-secondary">Lihat Sertifikat</a>
                                        @else
                                            <span class="text-danger">- Belum Diupload -</span>
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
                <div id="no-data-message" class="text-center text-danger mt-3" style="display: none;">
                    - - - Data yang anda cari tidak ada!!! - - -
                </div>
            @endif
        </div>
    </div>
    <!-- JavaScript for Search -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-content tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                const userId = row.getAttribute('data-user-id').toLowerCase();
                if (userId.includes(searchValue)) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });

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
