@extends('layouts.private')
@section('title', 'Telkom Akses - Approval Nonaktif NIK')
@section('content')
    <div class="card mt-4">
        <div class="card-body text-center bg-primary text-white">
            <h3 class="my-0 fw-bold text-accent-border">HCM Approval - Nonaktif NIK</h3>
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
                        <th>Surat Permohonan</th>
                        <th>Status</th>
                        <th>Komentar</th>
                        <th>Time Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nonaktifNik as $item)
                        <tr data-user-id="{{ $item->user_id }}">
                            <td>{{ $item->user_id }}</td>
                            <td>
                                @if ($item->surat_permohonan)
                                    <a href="javascript:void(0);" onclick="openPdfModal('{{ asset('storage/' . $item->surat_permohonan) }}', 'Surat Permohonan')" class="btn"><i class="fas fa-eye"></i></a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($item->status_aktivasi_nik === 2)
                                    <span class="text-danger">Reject</span>
                                @elseif ($item->status_aktivasi_nik === 1)
                                    <span class="text-success">Done Nok</span>
                                @else
                                    <form action="{{ url('/hcm/approval/nonaktif-nik/' . $item->id) }}" method="POST">
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
                                        <form action="{{ url('/hcm/approval/nonaktif-nik/' . $item->id) }}" method="POST">
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

        // Handle PDF modal display
        var pdfModal = document.getElementById('pdfModal');
        pdfModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var pdfUrl = button.getAttribute('data-pdf');
            var pdfViewer = document.getElementById('pdfViewer');
            pdfViewer.src = pdfUrl;
        });
        function openPdfModal(fileUrl, fieldName) {
            // Set the source of the embed to the file URL
            document.getElementById('pdfViewer').src = fileUrl;
            // Change the modal title based on the field name
            document.getElementById('pdfModalLabel').textContent = `${fieldName}`;
            // Show the modal
            var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
            pdfModal.show();
        }
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
        .modal-xl {
            max-width: 80%; /* Lebar modal 90% dari viewport */
        }
    </style>
@endsection
