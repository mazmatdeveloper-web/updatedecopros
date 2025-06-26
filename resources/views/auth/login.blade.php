@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="text-center text-uppercase font-weight-bold" style="color: #026839;">{{ __('Sign In') }}</h2>
                </div>

                <div class="card-body px-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 8px;">

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: #026839;">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-lg text-white py-3 text-uppercase fw-bold" 
                                    style="background-color: #40D002; border-radius: 8px; border: none;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        @if (Route::has('register'))
                            <div class="text-center text-muted">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #026839;">
                                    {{ __('Register') }}
                                </a>
                            </div>
                        @endif
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