@extends('layouts.private')
@section('title', 'Telkom Akses - Approval Pindah WH')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white"">
            <h3 class="my-0 fw-bold text-accent-border">Performance Approval - Pindah WH</h3>
        </div>
    </div>
    <div class="card mt-4">
        <!-- Search Input -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="input-group search-input-small">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" id="search" class="form-control" placeholder="Search By NIK">
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-striped table-hover" id="table-content">
                <thead class="thead-light">
                    <tr>
                        <th>NIK</th>
                        <th>STO Sebelum</th>
                        <th>Kode WH Sebelum</th>
                        <th>STO Tujuan</th>
                        <th>Kode WH Tujuan</th>
                        <th>Status Pindah</th>
                        <th>Komentar</th>
                        <th>Time Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pindahWH as $item)
                        <tr data-user-id="{{ $item->user_id }}">
                            <td>{{ $item->user_id }}</td>
                            <td>{{ $item->sto_sebelum }}</td>
                            <td>{{ $item->kode_wh_sebelum }}</td>
                            <td>{{ $item->sto_tujuan }}</td>
                            <td>{{ $item->kode_wh_tujuan }}</td>
                            <td>
                                @if ($item->status_pindah_wh === 1)
                                    <span class="text-success">Disetujui</span>
                                @elseif ($item->status_pindah_wh === 2)
                                    <span class="text-danger">Ditolak</span>
                                @else
                                    <form action="{{ url('/performance/pindah-wh/' . $item->id) }}" method="POST">
                                        @csrf
                                    
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>{{ $item->komentar }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
 
                        <!-- Modal for rejection reason -->
                        <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel{{ $item->id }}">Berikan Komentar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/performance/pindah-wh/' . $item->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                                            <button type="submit" name="action" value="approve" class="btn btn-success">Setujui</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <!-- No Data Message -->
            <div id="no-data-message" class="text-center text-danger mt-3" style="display: none;">
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

    <style>
        #search {
            width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
        }
        .thead-light th {
            background-color: grey;
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
        .input-group-text {
            height: 100%;
            border-radius: 5px 0 0 5px;
        }
        .input-group-prepend {
            display: flex;
            align-items: center;
        }
        .btn {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: greenyellow;
            color: #fff;
        }
        .bg-primary {
            background-color: dimgray !important;
        }
        .text-white {
            color: #fff !important;
        }
    </style>
@endsection
