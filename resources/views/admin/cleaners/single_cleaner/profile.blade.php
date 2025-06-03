@extends('admin.layouts.app')

@section('admin_content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24">
    @if ($cleaner->profile_picture)
        <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" class='cleaner-profile-picture'>
    @endif    
    <h6 class="fw-semibold mb-0">{{ $cleaner->name }}</h6>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Buttons to open modal -->

             <!-- Tabs -->
                    <ul class="nav nav-tabs mt-4" id="cleanerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="bed-area-tab" data-bs-toggle="tab" data-bs-target="#bedarea" type="button"
                                role="tab" aria-controls="bed-area" aria-selected="false">Bedrooms Area Sqft</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bath-area-tab" data-bs-toggle="tab" data-bs-target="#batharea" type="button"
                                role="tab" aria-controls="bath-area" aria-selected="false">Bathrooms Area Sqft</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button"
                                role="tab" aria-controls="service" aria-selected="false">Services</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-4" id="cleanerTabContent">
                        <!-- Bedroom Area Sqft Tab -->
                        <div class="tab-pane fade active show" id="bedarea" role="tabpanel" aria-labelledby="bed-area-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Area Sqft with Bedroom Options</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="bedroom">Add Bedrooms Sqft Option</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sqft Range</th>
                                                        <th>Bedrooms</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->bed_area_sqfts as $index => $area)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $area->no_of_sqft }}</td>
                                                            <td>{{ $area->beds }}</td>
                                                            <td>${{ number_format($area->price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No area sqft options available.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bathroom Area Sqft Tab -->
                        <div class="tab-pane fade" id="batharea" role="tabpanel" aria-labelledby="bath-area-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Area Sqft with Bathroom Options</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="bathroom">Add Bathroom Sqft Option</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sqft Range</th>
                                                        <th>Bathrooms</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->bath_area_sqfts as $index => $area)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $area->no_of_sqft }}</td>
                                                            <td>{{ $area->baths }}</td>
                                                            <td>${{ number_format($area->price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No area sqft options available.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Services</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="service">Add Service</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->service as $index => $service)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $service->service_name }}</td>
                                                            <td>${{ number_format($service->price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No services available.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" aria-labelledby="optionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="dynamicForm" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title" id="optionModalLabel">Add Option</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="cleaner_id" value="{{ $cleaner->id ?? '' }}">

          <!-- Sqft -->
          <div class="mb-3" id="sqftGroup">
            <label>No of Sqft</label>
            <input type="text" name="no_of_sqft" class="form-control" placeholder="e.g. 1000">
          </div>

          <!-- Beds -->
          <div class="mb-3" id="bedGroup">
            <label>No of Bedrooms</label>
            <input type="number" name="beds" class="form-control" placeholder="e.g. 2">
          </div>

          <!-- Baths -->
          <div class="mb-3" id="bathGroup">
            <label>No of Bathrooms</label>
            <input type="number" name="baths" class="form-control" placeholder="e.g. 1">
          </div>

          <!-- Service Name -->
          <div class="mb-3" id="serviceGroup">
            <label>Service Name</label>
            <input type="text" name="service_name" class="form-control" placeholder="e.g. Deep Cleaning">
          </div>

          <!-- Price -->
          <div class="mb-3" id="priceGroup">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" placeholder="e.g. 50.00">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
const forms = {
  bedroom: {
    action: '{{ route("insert.bed.areasqft.options") }}'
  },
  bathroom: {
    action: '{{ route("insert.bath.areasqft.options") }}'
  },
  service: {
    action: '{{ route("insert.service") }}'
  }
};

$(document).on('click', '.open-modal', function () {
  const type = $(this).data('type');
  const formInfo = forms[type];

  // Set form action
  $('#dynamicForm').attr('action', formInfo.action);

  // Reset all fields
  $('#sqftGroup, #bedGroup, #bathGroup, #serviceGroup, #priceGroup').hide();

  // Show relevant fields
  if (type === 'bedroom') {
    $('#sqftGroup, #bedGroup, #priceGroup').show();
  } else if (type === 'bathroom') {
    $('#sqftGroup, #bathGroup, #priceGroup').show();
  } else if (type === 'service') {
    $('#serviceGroup, #priceGroup').show();
  }

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('optionModal'));
  modal.show();
});
</script>


@endsection
