@extends('layouts.private')

@section('title', 'Telkom Akses - Status Semua Pengajuan')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">Semua Pengajuan</h3>
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
            <!-- Data Table -->
            <table class="table table-striped table-hover table-bordered" id="table-content">
                <thead class="thead-dark">
                    <tr>
                        <th>NIK</th>
                        <th>
                            Type
                            <i class="fa fa-caret-down ml-2" style="cursor: pointer;" id="filterTypeToggle"></i>
                            <div id="filterTypeDropdown" class="dropdown-menu" style="display: none;">
                                @foreach ($types as $type)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input filter-checkbox" name="type[]" value="{{ $type }}" id="type_{{ $type }}" {{ in_array($type, request()->query('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_{{ $type }}">{{ $type }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Time Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $status)
                        <tr data-user-id="{{ $status['nik'] }}" class="{{ $status['status'] === 'Done' ? 'table-success' : ($status['status'] === 'Reject' ? 'table-danger' : ($status['status'] === 'Done NDE' ? 'table-primary' : 'table-warning')) }}">
                            <td>{{ $status['nik'] }}</td>
                            <td>{{ $status['type'] }}</td>
                            <td>
                                @if ($status['status'] === 'Done')
                                    <span class="text-success">{{ $status['status'] }}</span>
                                @elseif ($status['status'] === 'Reject')
                                    <span class="text-danger">{{ $status['status'] }}</span>
                                @elseif ($status['status'] === 'Done NDE')
                                    <span class="text-success">{{ $status['status'] }}</span>
                                @else
                                    <span class="text-warning">{{ $status['status'] }}</span>
                                @endif
                            </td>
                            <td>{{ $status['keterangan'] }}</td>
                            <td>{{ $status['created_at']->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- No Data Message -->
            <div id="no-data-message" class="text-center text-danger mt-3" style="display: none;">
                - - - Data yang anda cari tidak ada!!! - - -
            </div>
        </div>
    </div>
    <!-- JavaScript for Filter and Search -->
    <script>
        document.getElementById('filterTypeToggle').addEventListener('click', function() {
            var dropdown = document.getElementById('filterTypeDropdown');
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        });

        document.querySelectorAll('.filter-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const selectedTypes = [];
            document.querySelectorAll('.filter-checkbox:checked').forEach(function(checkbox) {
                selectedTypes.push(checkbox.value);
            });

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('type[]');
            selectedTypes.forEach(function(type) {
                urlParams.append('type[]', type);
            });

            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState(null, null, newUrl);
            window.location.reload();
        }
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

        .thead-dark th {
            background-color: #343a40;
            color: white;
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
        /* Dropdown Styles */
        #filterTypeDropdown {
            position: absolute;
            width: 300px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            z-index: 1000;
            padding: 10px 5px;
            max-height: 200px;
            overflow-y: auto;
        }

        #filterTypeToggle {
            display: inline-block;
            margin-left: 5px;
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            width: 200px;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-check {
            margin-bottom: 5px;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .dropdown-header {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }
    </style>
@endsection
