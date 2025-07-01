@extends('admin.layouts.app')

@section('admin_content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Update Customer</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('update.customer', $customer->id) }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{ $customer->email }}">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Phone</label>
                    <input type="tel" name="phone" class="form-control" required value="{{ $customer->phone }}">
                </div>


                <button type="submit" class="btn btn-primary w-100">Update User</button>
            </form>
        </div>
    </div>
</div>
@endsection
