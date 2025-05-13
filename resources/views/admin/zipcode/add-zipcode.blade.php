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
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($zipcodes as $index => $zipcode)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $zipcode->codes }}</td>
                                    <td>{{ $zipcode->created_at->format('Y-m-d H:i') }}</td>
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
        <h5 class="modal-title" id="zipcodeModalLabel">Add New Zipcode</h5>
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

@endsection