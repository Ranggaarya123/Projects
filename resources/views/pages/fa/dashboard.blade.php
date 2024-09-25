@extends('layouts.private')
@section('title', 'Telkom Akses - Dashboard')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h3 class="my-0 fw-bold text-accent-border">DASHBOARD</h3>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="my-2 fw-bold">Employee Management</h4>
            <div class="input-group search-input-small">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" id="search-input" class="form-control" placeholder="Cari berdasarkan NIK">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table-content">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Witel</th>
                        <th>Alokasi</th>
                        <th>Mitra</th>
                        <th>Craft</th>
                        <th>STO</th>
                        <th>WareHouse</th>
                        <th>Status NIK</th>
                        <th>Brevet</th>
                        <th>Tactical</th>
                        <th>Labor</th>
                        <th>MYI</th>
                        <th>SCMT</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($createMitraManajemen as $item)
                        <tr>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->user_id }}</td>
                            <td>{{ $item->witel }}</td>
                            <td>{{ $item->alokasi }}</td>
                            <td>{{ $item->mitra }}</td>
                            <td>{{ $item->craft }}</td>
                            <td>{{ $item->sto }}</td>
                            <td>{{ $item->wh }}</td>
                            <td>
                                @if ($item->status_aktivasi_nik === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_aktivasi_nik === 2)
                                    <span class="text-danger">NOK</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_brevet === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_brevet === 2)
                                    <span class="text-danger">NOK</span>
                                @elseif ($item->status_brevet === 3)
                                    <span class="text-warning">Approved</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_tactical === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_tactical === 2)
                                    <span class="text-danger">NOK</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_labor === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_labor === 2)
                                    <span class="text-danger">NOK</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_myi === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_myi === 2)
                                    <span class="text-danger">NOK</span>
                                @elseif ($item->status_myi === 3)
                                    <span class="text-warning">Done NDE</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_scmt === 1)
                                    <span class="text-success">OK</span>
                                @elseif ($item->status_scmt === 2)
                                    <span class="text-danger">NOK</span>
                                @elseif ($item->status_scmt === 3)
                                    <span class="text-warning">Done NDE</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tr id="no-data-message" style="display: none;">
                    <td colspan="16" class="text-center text-danger mt-3">- - - Data Yang Anda Cari Tidak Ditemukan! - - -</td>
                </tr>
            </table>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <label for="itemsPerPage">Show</label>
                    <select id="itemsPerPage" class="form-control d-inline-block" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                        <option value="all">All</option>
                    </select>
                    <label for="itemsPerPage">entries</label>
                </div>
                <div>
                    <button id="prevPage" class="btn btn-secondary">Previous</button>
                    <button id="nextPage" class="btn btn-secondary">Next</button>
                </div>
            </div>
            <div id="dataInfo" class="mb-3 text-center"></div>
            <button id="download-excel" class="btn btn-success mt-3">Download Excel</button>
        </div>
    </div><br><br>

    <!-- Tabel Statistik NIK -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="my-2 fw-bold text-center">STATISTIK  NIK</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th rowspan="2" class="align-middle">NAMA MITRA</th>
                        <th colspan="3" class="text-center">JUMLAH NIK</th>
                    </tr>
                    <tr>
                        <th>NIK AKTIF</th>
                        <th>NIK NOK</th>
                        <th>TOTAL NIK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statistikMitra as $stat)
                        <tr>
                            <td>{{ $stat->mitra }}</td>
                            <td>{{ $stat->nik_ok }}</td>
                            <td>{{ $stat->nik_nok }}</td>
                            <td>{{ $stat->total_nik }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-header">
            <h4 class="my-2 fw-bold text-center">STATISTIK  UNIT</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th rowspan="2" class="align-middle">NAMA MITRA</th>
                        <th colspan="{{ count($alokasiList) }}" class="text-center">UNIT</th>
                    </tr>
                    <tr>
                        @foreach($alokasiList as $alokasi)
                            <th>{{ $alokasi }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistikAlokasi as $data)
                        <tr>
                            <td>{{ $data['mitra'] }}</td>
                            @foreach($alokasiList as $alokasi)
                                <td>{{ $data['alokasi'][$alokasi] ?? 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div><br><br>

    <!-- Bar Chart for Aktivasi and Nonaktif NIK -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="my-2 fw-bold text-center">STATISTIK AKTIVASI dan NONAKTIF NIK</h4>
        </div>
        <div class="card-body">
        <h5 class="my-2">Filter Tanggal</h5>
            <form method="GET" action="{{ route('dashboardFA') }}">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="start_date">From :</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="end_date">To :</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Apply</button>
            </form>
            <canvas id="nikBarChart"></canvas>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.3/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const table = document.getElementById('table-content');
            const rows = Array.from(table.querySelector('tbody').querySelectorAll('tr'));
            const itemsPerPageSelect = document.getElementById('itemsPerPage');
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');
            const searchInput = document.getElementById('search-input');
            const noDataMessage = document.getElementById('no-data-message');
            const dataInfo = document.getElementById('dataInfo');

            let currentPage = 1;
            let itemsPerPage = parseInt(itemsPerPageSelect.value) || rows.length; // Set default to all rows if not specified
            let filteredRows = rows;

            function sortRows() {
                filteredRows.sort((a, b) => {
                    const aText = a.cells[0].innerText.trim().toLowerCase();
                    const bText = b.cells[0].innerText.trim().toLowerCase();
                    return aText.localeCompare(bText);
                });
            }

            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                filteredRows = rows.filter(row => row.cells[1].innerText.toLowerCase().includes(searchTerm));
                sortRows();
            }

            function updateDataInfo() {
                const totalEntries = filteredRows.length;
                const start = totalEntries === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
                const end = itemsPerPage === rows.length ? totalEntries : Math.min(currentPage * itemsPerPage, totalEntries);
                dataInfo.textContent = `Showing ${start} to ${end} of ${totalEntries} entries`;
            }

            function paginateTable() {
                filterRows();
                const totalEntries = filteredRows.length;
                let start = (currentPage - 1) * itemsPerPage;
                let end = itemsPerPage === rows.length ? totalEntries : start + itemsPerPage;
                table.querySelector('tbody').innerHTML = '';

                if (totalEntries === 0) {
                    noDataMessage.style.display = '';
                } else {
                    noDataMessage.style.display = 'none';
                    for (let i = 0; i < totalEntries; i++) {
                        if (itemsPerPage === rows.length || (i >= start && i < end)) {
                            table.querySelector('tbody').appendChild(filteredRows[i]);
                        }
                    }
                }
                updatePaginationButtons();
                updateDataInfo();
            }

            function updatePaginationButtons() {
                prevPageButton.disabled = currentPage === 1;
                nextPageButton.disabled = (currentPage * itemsPerPage >= filteredRows.length) || itemsPerPage === rows.length;
            }

            itemsPerPageSelect.addEventListener('change', function() {
                itemsPerPage = itemsPerPageSelect.value === 'all' ? rows.length : parseInt(itemsPerPageSelect.value);
                currentPage = 1;
                paginateTable();
            });

            prevPageButton.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    paginateTable();
                }
            });

            nextPageButton.addEventListener('click', function() {
                if ((currentPage * itemsPerPage < filteredRows.length) && itemsPerPage !== rows.length) {
                    currentPage++;
                    paginateTable();
                }
            });

            searchInput.addEventListener('input', function() {
                currentPage = 1;
                paginateTable();
            });

            // Initial sorting
            sortRows();
            paginateTable();
            
            var ctx = document.getElementById('nikBarChart').getContext('2d');
            var nikBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($aktivasiData)) !!}, // Mitra names as labels
                    datasets: [
                        {
                            label: 'Aktivasi NIK',
                            data: {!! json_encode(array_values($aktivasiData)) !!}, // Total activation counts
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Nonaktif NIK',
                            data: {!! json_encode(array_values($nonaktifData)) !!}, // Total non-activation counts
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                            
                        }
                    }
                }
            });
            // Function to sort the table by column
            function sortTableByColumn(columnIndex) {
                let table = document.getElementById('table-content');
                let tbody = table.querySelector('tbody');
                let rows = Array.from(tbody.querySelectorAll('tr'));

                // Sort rows based on the column text
                rows.sort((a, b) => {
                    const aText = a.getElementsByTagName('td')[columnIndex]?.textContent.trim() || '';
                    const bText = b.getElementsByTagName('td')[columnIndex]?.textContent.trim() || '';
                    return aText.localeCompare(bText);
                });

                // Append sorted rows back to the table body
                rows.forEach(row => tbody.appendChild(row));
            }

            // Sort the table by the 'Nama' column (index 0)
            sortTableByColumn(0);

            // Event listener for downloading the Excel file
            document.getElementById('download-excel').addEventListener('click', function() {
                const table = document.getElementById('table-content');

                // Clone table to remove action column temporarily
                let clonedTable = table.cloneNode(true);
                let headers = clonedTable.getElementsByTagName('th');
                let rows = Array.from(clonedTable.getElementsByTagName('tr'));
                let actionsHeader = null;

                // Find and remove the Actions column header
                for (let i = 0; i < headers.length; i++) {
                    if (headers[i].textContent === 'Actions') {
                        actionsHeader = headers[i];
                        break;
                    }
                }
                if (actionsHeader) {
                    actionsHeader.parentNode.removeChild(actionsHeader);
                }

                // Remove actions column from cloned table
                for (let i = 0; i < rows.length; i++) {
                    let actionsCell = rows[i].querySelectorAll('[data-export="false"]');
                    for (let j = 0; j < actionsCell.length; j++) {
                        actionsCell[j].parentNode.removeChild(actionsCell[j]);
                    }
                }

                // Convert modified cloned table to Excel
                const ws = XLSX.utils.table_to_sheet(clonedTable);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Dashboard');
                XLSX.writeFile(wb, 'dashboard.xlsx');
            });

            // Event listener for search input
            document.getElementById('search-input').addEventListener('input', function() {
                let filter = this.value.toUpperCase();
                let table = document.getElementById('table-content');
                let rows = table.getElementsByTagName('tr');
                let noMatch = true;

                for (let i = 0; i < rows.length; i++) {
                    let td = rows[i].getElementsByTagName('td')[1]; // Mengambil kolom ID (indeks 1)
                    if (td) {
                        let textValue = td.textContent || td.innerText;
                        if (textValue.toUpperCase().indexOf(filter) > -1) {
                            rows[i].style.display = '';
                            noMatch = false;
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }

                let tableBody = document.getElementById('table-body');
                let noDataMessage = document.getElementById('no-data-message');
                if (noMatch) {
                    if (!noDataMessage) {
                        noDataMessage = document.createElement('tr');
                        noDataMessage.id = 'no-data-message';
                        noDataMessage.innerHTML = '<td colspan="15" class="text-center">- - - Data Yang Anda Cari Tidak Ditemukan! - - -</td>';
                        tableBody.appendChild(noDataMessage);
                    }
                } else {
                    if (noDataMessage) {
                        tableBody.removeChild(noDataMessage);
                    }
                }
            });
        });
    </script>
    <style>
        body {
            background-color: #F8F8FF;
        }
        .thead-light th {
            background-color: 	#E6E6FA; /* Abu-abu Muda */
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
        .form-control::placeholder {
            color: #aaa;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255, 145, 77, 0.1);
            cursor: pointer;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .btn {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endsection
