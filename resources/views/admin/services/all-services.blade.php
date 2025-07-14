@extends('admin.layouts.app')

@section('admin_content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Services</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cleaneraddModal">
        Add New Service
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

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                   <table class='table' border="1" cellpadding="10" cellspacing="0" style='width:100%;'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $index => $service)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td> 
                                        <div class='d-flex align-items-center gap-2'>
                                        @if ($service->service_image)
                                            <img style='width:50px;' src="{{ asset('storage/' . $service->service_image) }}" alt="Service Image" class="employee-table-profile-picture">
                                        @endif   
                                        {{ $service->service_name }}
                                        </div>
                                    </td>
                                    <td>${{ $service->price }}</td>
                                    <td>
                                       <form action="{{ route('delete.service', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class='text-center'>No Service found.</td>
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
<div class="modal fade" id="cleaneraddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Add New Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form action="{{ route('insert.service') }}" method='POST' enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Service Name</label>
            <input type="text" name="service_name" class="form-control" placeholder="Service Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" placeholder="$$$">
          </div>
          <div class="mb-3">
            <label class="form-label">Service Image</label>
            <input type="file" name="service_image" class="form-control">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection