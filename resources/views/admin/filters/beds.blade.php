@extends('admin.layouts.app')

@section('admin_content')

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Cleaners</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cleaneraddModal">
        Add New Cleaner
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
                                <th>Options</th>
                                <th>Price</th>
                                <th>Cleaner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($beds as $index => $bed)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bed->bed_option }} BD</td>
                                    <td>${{ $bed->price }}</td>
                                    <td>{{ $bed->cleaner->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class='text-center'>No bed option available.</td>
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
        <h5 class="modal-title" id="zipcodeModalLabel">Add Bed Option</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="{{ route('insert.bed.options') }}" method='POST'>
            @csrf
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label">Select Cleaner</label> 
                        <select name="cleaner_id" class='form-control'>
                            <option>Select Cleaner</option>
                            @foreach($cleaners as $cleaner)
                            <option value="{{ $cleaner->id }}">{{$cleaner->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bed Option</label>
                        <input type="number" name="bed_option" class="form-control" placeholder="2 BD">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" placeholder="$$">
                    </div>
                    <div class="col-12">
                        <button type='submit' class='btn btn-primary w-100'>Save</button>
                    </div>
                </div>
           </form>
      </div>

    </div>
  </div>
</div>

@endsection