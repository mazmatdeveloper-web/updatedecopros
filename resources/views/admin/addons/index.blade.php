@extends('admin.layouts.app')

@section('admin_content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Addons</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addonaddModal">
        Add New Addon
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
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($addons as $index => $addon)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $addon->addon_name }}</td>
                                    <td>${{ $addon->price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No addons found.</td>
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
<div class="modal fade" id="addonaddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">New Addon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="{{ route('insert.addon') }}" method='POST'>
            @csrf
                <div class="row gy-3">
                    <div class="col-md-12">
                        <label class="form-label">Addon Name</label>
                        <input type="text" name="addon_name" class="form-control" placeholder="Interior Refrigerator">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="e.g 10.00">
                    </div>
                   <div class="col-md-12">
                   <button class='btn btn-primary' type='submit'>Save</button>
                   </div>
                </div>
           </form>
      </div>

    </div>
  </div>
</div>

@endsection