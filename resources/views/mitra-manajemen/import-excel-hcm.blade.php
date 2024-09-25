@extends('layouts.private')
@section('title', 'Telkom Akses - Import Excel')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-lg" style="background-color: #f5f5f5;">
            <div class="card-header text-white text-center py-3 rounded-top" style="background-color: #607d8b;">
                <h3 class="my-2">Upload File Excel</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('import.excel-hcm') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file" class="font-weight-bold text-dark">Choose Excel File</label>
                        <input type="file" class="form-control-file border rounded" id="file" name="file" required>
                        <small class="form-text text-muted">Supported file: .xls, .xlsx</small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3 px-4 py-2 rounded-pill" style="background-color: #607d8b; border: none;">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
