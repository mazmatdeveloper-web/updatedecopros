@extends('layouts.app')

@section('content')
<div class="container p-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="text-center text-uppercase font-weight-bold" style="color: #026839;">{{ __('Create Account') }}</h2>
                    <p class="text-center text-muted mt-2">Join us today and get started</p>
                </div>

                <div class="card-body px-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-2">
                            <label for="name" class="form-label text-muted">{{ __('Full Name') }}</label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">

                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="password-confirm" class="form-label text-muted">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">
                        </div>

                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-lg text-white py-3 text-uppercase fw-bold" 
                                    style="background-color: #40D002; border-radius: 8px; border: none;">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <div class="text-center text-muted">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #026839;">
                                {{ __('Login') }}
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
</style>