@extends('layouts.private')
@section('title', 'Add Mitra Manajemen')
@section('content')
    <h5 class="my-0 mb-4">Add Employee Mitra</h5>
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('mitra-manajemen.store-hcm') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Nama</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="user_id">NIK</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                        </div>
                        <div class="form-group">
                            <label for="witel">Witel</label>
                            <input type="text" class="form-control" id="witel" name="witel" required>
                        </div>
                        <div class="form-group">
                            <label for="alokasi">Alokasi</label>
                            <input type="text" class="form-control" id="alokasi" name="alokasi" required>
                        </div>
                        <div class="form-group">
                            <label for="mitra">Mitra</label>
                            <input type="text" class="form-control" id="mitra" name="mitra" required>
                        </div>
                        <div class="form-group">
                            <label for="craft">Craft</label>
                            <input type="text" class="form-control" id="craft" name="craft" required>
                        </div>
                        <div class="form-group">
                            <label for="sto">STO</label>
                            <input type="text" class="form-control" id="sto" name="sto" required>
                        </div>
                        <div class="form-group">
                            <label for="wh">WareHouse</label>
                            <input type="text" class="form-control" id="wh" name="wh" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_aktivasi_nik">Status NIK</label>
                            <select class="form-control" id="status_aktivasi_nik" name="status_aktivasi_nik" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_brevet">Brevet</label>
                            <select class="form-control" id="status_brevet" name="status_brevet" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                                <option value="3">Approved</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_tactical">Tactical</label>
                            <select class="form-control" id="status_tactical" name="status_tactical" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_labor">Labor</label>
                            <select class="form-control" id="status_labor" name="status_labor" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_myi">MYI</label>
                            <select class="form-control" id="status_myi" name="status_myi" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_scmt">SCMT</label>
                            <select class="form-control" id="status_scmt" name="status_scmt" required>
                                <option value="0"></option>
                                <option value="1">OK</option>
                                <option value="2">NOK</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
