@extends('layouts.private')
@section('title', 'Telkom Akses - Status Create New NIK')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">Status Create NIK Baru</h3>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <!-- Search Input -->
            <div class="form-group mb-3">
                <label for="search" class="my-0 fw-bold">Search by Name:</label>
                <input type="text" class="form-control" id="search" placeholder="Masukkan Nama">
                <div id="no-data-message" class="mt-2 text-danger" style="display: none;">
                    Tidak ada data yang cocok.
                </div>
            </div>

            <!-- Data Table -->
            <table class="table table-striped table-hover" id="table-content">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Status Create</th>
                        <th>Keterangan</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($createMitra as $item)
                        <tr data-username="{{ $item->username }}">
                            <td>{{ $item->username }}</td>
                            <td>
                                @if ($item->status_aktivasi === 1)
                                    <span class="text-success">Done</span>
                                @elseif ($item->status_aktivasi === 2)
                                    <span class="text-danger">Reject</span>
                                @else
                                    <span class="text-warning">Review</span>
                                @endif
                            </td>
                            <td>{{ $item->komentar }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for Search -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-content tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                const username = row.getAttribute('data-username').toLowerCase();
                if (username.includes(searchValue)) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Display the "No data" message if no rows are visible
            const noDataMessage = document.getElementById('no-data-message');
            noDataMessage.style.display = hasVisibleRows ? 'none' : 'block';
        });
    </script>

    <style>
        #search {
            width: 300px; /* Sesuaikan lebar sesuai kebutuhan */
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
        .bg-primary {
            background-color: #343a40 !important;
        }
        .text-white {
            color: #fff !important;
        }
    </style>
@endsection
