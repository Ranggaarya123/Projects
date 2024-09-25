@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 shadow-sm border-0 rounded">
                <div class="card-header bg-white text-center border-bottom-0">
                    <h3>{{ __('Reset Password') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center bg-white border-top-0">
                    <a href="{{ route('login') }}" class="btn btn-link">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: silver;
        font-family: 'Poppins', sans-serif;
    }
    .card {
        background-color: #ffffff;
    }
    .card-header {
        background-color: #ffffff;
    }
    .card-body {
        padding: 2rem;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .btn-link {
        color: #007bff;
    }
    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>
@endsection
