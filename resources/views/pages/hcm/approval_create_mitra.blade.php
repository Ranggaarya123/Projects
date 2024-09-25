@extends('layouts.private')
@section('title', 'Telkom Akses - Approval Create New NIK')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">HCM Approval - Create New NIK</h3>
        </div>
    </div>
    <div class="card mt-4">
        <!-- Search Input -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="input-group search-input-small">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="search" placeholder="Masukkan Nama">
            </div>
            <div id="no-data-message" class="mt-2 text-danger" style="display: none;">
                Tidak ada data Nama yang cocok.
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
                        <th>Nama</th>
                        <th>KHS Mitra</th>
                        <th>Surat Keterangan Aktif Mitra</th>
                        <th>Scan BPJS</th>
                        <th>Scan KTP</th>
                        <th>Foto Mitra</th>
                        <th>Excel Create NIK Mitra</th>
                        <th>Status</th>
                        <th>Komentar</th>
                        <th>Time Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($createMitra as $item)
                        <tr data-username="{{ $item->user->username }}">
                            <td>{{ $item->user->username }}</td>

                            <!-- Button for showing PDF in modal -->
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->khs_mitra) }}', 'KHS Mitra')" class="btn"><i class="fas fa-eye"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->surat_keterangan_aktif) }}', 'Surat Keterangan Aktif Mitra')" class="btn"><i class="fas fa-eye"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->scan_bpjs) }}', 'Scan BPJS')" class="btn"><i class="fas fa-eye"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->scan_ktp) }}', 'Scan KTP')" class="btn"><i class="fas fa-eye"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->foto_mitra) }}', 'Foto Mitra')" class="btn"><i class="fas fa-eye"></i></a></td>
                            <td><a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->excelcreate_nikmitra) }}', 'Excel Create NIK Mitra')" class="btn"><i class="fas fa-eye"></i></a></td>

                            <td>
                                @if ($item->status_aktivasi === 1)
                                    <span class="text-success">Disetujui</span>
                                @elseif ($item->status_aktivasi === 2)
                                    <span class="text-danger">Ditolak</span>
                                @else
                                    <form action="{{ url('/hcm/approval/create-mitra/' . $item->id) }}" method="POST">
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
                                        <form action="{{ url('/hcm/approval/create-mitra/' . $item->id) }}" method="POST">
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

    <!-- Modal for PDF Viewer -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <embed id="pdfViewer" src="" width="100%" height="700px" type="application/pdf">
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search and PDF viewer -->
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

            const noDataMessage = document.getElementById('no-data-message');
            noDataMessage.style.display = hasVisibleRows ? 'none' : 'block';
        });

        // Handle PDF modal display
        function openPdfModal(fileUrl, fieldName) {
            document.getElementById('pdfViewer').src = fileUrl;
            document.getElementById('pdfModalLabel').textContent = `${fieldName}`;
            var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
            pdfModal.show();
        }
    </script>

    <style>
        #search {
            width: 300px;
        }
        .thead-light th {
            background-color: grey;
            color: white;
        }
        .search-input-small {
            width: 300px;
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
        .modal-xl {
            max-width: 80%; /* Lebar modal 90% dari viewport */
        }
    </style>
@endsection
