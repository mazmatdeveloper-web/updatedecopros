@extends('admin.layouts.app')

@section('admin_content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Cleaners</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Cleaners
                </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add Cleaner</li>
            </ul>
    </div>

    @if ($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Something went wrong...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            position: 'top-end',
            toast: true,
            timer: 500000,
            showCloseButton: true,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    </script>
@endif

    <div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Add New Cleaner</h5>
          </div>
          <div class="card-body"> 
           <form action="{{ route('insert.cleaner') }}" method='POST'>
            @csrf
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="#0" class="form-control" rows="4" cols="50" placeholder="Enter cleaner's bio..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" placeholder="$$$">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="*******">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary-600">Submit</button>
                    </div>
                </div>
           </form>
          </div>
        </div>
      </div>
    </div>
</div>

  @endsection