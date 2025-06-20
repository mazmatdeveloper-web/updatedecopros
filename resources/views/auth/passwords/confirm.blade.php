@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="text-center text-uppercase font-weight-bold" style="color: #026839;">{{ __('Confirm Password') }}</h2>
                    <p class="text-center text-muted mt-2">{{ __('Please confirm your password before continuing.') }}</p>
                </div>

                <div class="card-body px-5">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 12px;">

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button type="submit" class="btn btn-lg text-white py-3 text-uppercase fw-bold" 
                                    style="background-color: #40D002; border-radius: 8px; border: none; min-width: 200px;">
                                {{ __('Confirm Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: #026839;">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
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
    a:hover {
        text-decoration: underline;
        color: #40D002 !important;
    }
</style>