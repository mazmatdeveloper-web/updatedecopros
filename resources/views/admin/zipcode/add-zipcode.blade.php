@extends('admin.layouts.app')

@section('admin_content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Zipcodes</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#zipcodeModal">
        Add New Zipcode
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                   <table class='table' border="1" cellpadding="10" cellspacing="0" style='width:100%;'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ZIP Code</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($zipcodes as $index => $zipcode)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $zipcode->codes }}</td>
                                    <td style="display:flex;gap:10px;"><button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon class="editZipBtn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editzipcodeModal" 
                                        data-id="{{ $zipcode->id }}" 
                                        data-code="{{ $zipcode->codes }}" icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                        <form>  
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $zipcode->id }}">
                                            <button type="submit" formaction="{{ route('delete.zipcode', ['id' => $zipcode->id]) }}" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                        </form>
                                      </td>
                                       
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No ZIP codes found.</td>
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
<div class="modal fade" id="zipcodeModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Edit Zipcode</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form action="{{ route('insert.zipcode') }}" method='POST'>
          @csrf
          <div class="mb-3">
            <label class="form-label">Add Zipcode</label>
            <input type="text" name="codes" class="form-control" placeholder="33004">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Edit Zipcode Modal -->
<div class="modal fade" id="editzipcodeModal" tabindex="-1" aria-labelledby="editzipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Add New Zipcode</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form method="POST" id="editZipForm" action="{{ route('update.zipcode', 0) }}">
          @csrf
          <input type="hidden" name="id" id="editzipcode_id">
          <div class="mb-3">
            <label class="form-label">Zipcode</label>
            <input type="text" name="codes" class="form-control" id="editzipcode_code">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editZipBtn');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const zipId = this.getAttribute('data-id');
                const zipCode = this.getAttribute('data-code');

                // Set values in modal
                document.getElementById('editzipcode_id').value = zipId;
                document.getElementById('editzipcode_code').value = zipCode;

                // Dynamically update form action
                const form = document.getElementById('editZipForm');
                form.action = `/update-zipcode/${zipId}`; 
            });
        });
    });
</script>



@endsection