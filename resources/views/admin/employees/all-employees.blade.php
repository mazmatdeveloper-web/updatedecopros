@extends('admin.layouts.app')

@section('admin_content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">employees</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeaddModal">
        Add New employee
        </button>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   <table class='table' border="1" cellpadding="10" cellspacing="0" style='width:100%;'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Bio</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td> 
                                        <div class='d-flex align-items-center gap-2'>
                                        @if ($employee->profile_picture)
                                            <img style='width:50px;' src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" class="employee-table-profile-picture">
                                        @endif   
                                        {{ $employee->name }}
                                        </div>
                                    </td>
                                    <td>{{ $employee->email }} <br> {{ $employee->phone }}</td>
                                    <td>
                                        @if($employee->bio == null)
                                        No Bio
                                        @else
                                        {{ $employee->bio }}
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class='d-flex align-items-center gap-1'>
                                            <a href="{{ route('employees.profile',$employee->id) }}">
                                            <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                                <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                            </button>
                                            </a>
                                            <form>  
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $employee->id }}">
                                            <button type="submit" formaction="{{ route('employees.delete', ['id' => $employee ->id]) }}" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                            </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="employeeaddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Add New employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="{{ route('insert.employee') }}" method='POST' enctype="multipart/form-data">
            @csrf
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                </div>
                <div class='row gy-3'>
                    <div class="col-12">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="#0" class="form-control" rows="4" cols="50" placeholder="Enter employee's bio..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Select Services</label>
                        @foreach($services as $service)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}">
                                <label class="form-check-label" for="service_{{ $service->id }}">
                                    {{ $service->service_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name='profile_picture' id='profile_picture' class='form-control'>
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

@endsection