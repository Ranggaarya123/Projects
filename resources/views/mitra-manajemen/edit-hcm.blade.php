@extends('layouts.private')
@section('title', 'Edit Mitra Manajemen')
@section('content')
    <h5 class="my-0 mb-4">Edit Employee Mitra</h5>
    <div class="card mt-4">

        <div class="card-body">
            <form action="{{ route('mitra-manajemen.update-hcm', $mitraManajemen->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Nama</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $mitraManajemen->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="user_id">NIK</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $mitraManajemen->user_id }}" required>
                        </div>
                        <div class="form-group">
                            <label for="witel">Witel</label>
                            <input type="text" class="form-control" id="witel" name="witel" value="{{ $mitraManajemen->witel }}">
                        </div>
                        <div class="form-group">
                            <label for="alokasi">Alokasi</label>
                            <input type="text" class="form-control" id="alokasi" name="alokasi" value="{{ $mitraManajemen->alokasi }}">
                        </div>
                        <div class="form-group">
                            <label for="mitra">Mitra</label>
                            <input type="text" class="form-control" id="mitra" name="mitra" value="{{ $mitraManajemen->mitra }}">
                        </div>
                        <div class="form-group">
                            <label for="craft">Craft</label>
                            <input type="text" class="form-control" id="craft" name="craft" value="{{ $mitraManajemen->craft }}">
                        </div>
                        <div class="form-group">
                            <label for="sto">STO</label>
                            <input type="text" class="form-control" id="sto" name="sto" value="{{ $mitraManajemen->sto }}">
                        </div>
                        <div class="form-group">
                            <label for="wh">WareHouse</label>
                            <input type="text" class="form-control" id="wh" name="wh" value="{{ $mitraManajemen->wh }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_aktivasi_nik">Status NIK</label>
                            <select class="form-control" id="status_aktivasi_nik" name="status_aktivasi_nik" required>
                                <option value="0" {{ $mitraManajemen->status_aktivasi_nik == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_aktivasi_nik == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_aktivasi_nik == 2 ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_brevet">Status Brevet</label>
                            <select class="form-control" id="status_brevet" name="status_brevet" required>
                                <option value="0" {{ $mitraManajemen->status_brevet == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_brevet == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_brevet == 2 ? 'selected' : '' }}>NOK</option>
                                <option value="3" {{ $mitraManajemen->status_brevet == 3 ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_tactical">Status Tactical</label>
                            <select class="form-control" id="status_tactical" name="status_tactical" required>
                                <option value="0" {{ $mitraManajemen->status_tactical == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_tactical == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_tactical == 2 ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_labor">Labor</label>
                            <select class="form-control" id="status_labor" name="status_labor" required>
                                <option value="0" {{ $mitraManajemen->status_labor == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_labor == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_labor == 2 ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_myi">MYI</label>
                            <select class="form-control" id="status_myi" name="status_myi" required>
                                <option value="0" {{ $mitraManajemen->status_myi == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_myi == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_myi == 2 ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_scmt">SCMT</label>
                            <select class="form-control" id="status_scmt" name="status_scmt" required>
                                <option value="0" {{ $mitraManajemen->status_scmt == 0 ? 'selected' : '' }}></option>
                                <option value="1" {{ $mitraManajemen->status_scmt == 1 ? 'selected' : '' }}>OK</option>
                                <option value="2" {{ $mitraManajemen->status_scmt == 2 ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" onclick="history.back();">Cancel</button>
            </form>
        </div>
    </div>
@endsection
