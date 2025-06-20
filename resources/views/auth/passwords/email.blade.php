@extends('layouts.app')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="text-center text-uppercase font-weight-bold" style="color: #026839;">{{ __('Reset Password') }}</h2>
                    <p class="text-center text-muted mt-2">Enter your email to receive a reset link</p>
                </div>

                <div class="card-body px-5">
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert" style="border-radius: 8px;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 12px;">

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-lg text-white py-3 text-uppercase fw-bold" 
                                    style="background-color: #40D002; border-radius: 8px; border: none;">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>

                        <div class="text-center text-muted">
                            Remember your password? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #026839;">
                                {{ __('Login here') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 12px;
        border: none;
    }
    .form-control:focus {
        border-color: #40D002;
        box-shadow: 0 0 0 0.25rem rgba(64, 208, 2, 0.25);
    }
    .btn:hover {
        background-color: #026839 !important;
        transition: all 0.3s ease;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    a:hover {
        text-decoration: underline;
        color: #40D002 !important;
    }
</style>