@extends('admin.layouts.app')

@section('admin_content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div class='employee-display d-flex align-items-center gap-2'>
    @if ($employee->profile_picture)
        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" class='employee-profile-picture'>
    @endif    
    <h6 class="fw-semibold mb-0">{{ $employee->name }}</h6>
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
    <div>
        <button  
            data-bs-toggle="modal" 
            data-bs-target="#employeeaddModal"
            data-id="{{ $employee->id }}" 
            data-name="{{$employee->name}}" 
            data-email="{{$employee->email}}"
            data-phone="{{$employee->phone}}"
            data-bio="{{$employee->bio}}"
            data-price="{{$employee->price}}"
            class="btn btn-primary">Update Profile
        </button>
    </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Buttons to open modal -->

             <!-- Tabs -->
                    <ul class="nav nav-tabs mt-4" id="employeeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button"
                                role="tab" aria-controls="service" aria-selected="false">Services</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button"
                                role="tab" aria-controls="availability" aria-selected="false">Availability</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-4" id="employeeTabContent">
                         
                        <!-- Services Tab -->
                        <div class="tab-pane active show fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Services</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                Add Services
                                </button>

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
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @forelse ($employee->services as $index => $service)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $service->service_name }}</td>
                                                                <td>${{ number_format($service->price, 2) }}</td>
                                                                <td class="d-flex align-items-center gap-1">

                                                                    {{-- Detach form --}}
                                                                    <form action="{{ route('employee.delete.service', [$employee->id, $service->id]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to remove this service from employee?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                                class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium
                                                                                    w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                        </button>
                                                                    </form>

                                                                </td>
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

                         <!-- Availability Tab -->
                         <div class="tab-pane fade" id="availability" role="tabpanel" aria-labelledby="availability-tab">
                          
                            <h6 class='my-20'>Availability</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Specific Dates Availability</h6>
                                    <div class="card">
                                        <div class="card-body">
                                            <table class='table w-100'>
                                                @forelse($employee->availableDates as $date)
                                                    <tr>
                                                        <th>{{ \Carbon\Carbon::parse($date->dates)->format('F j, Y') }}</th>
                                                        <td class="list-group">
                                                            @foreach($date->timeSlots as $slot)
                                                                
                                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @empty
                                                <tr>
                                                    <td>No one-time availability.</td>
                                                </tr>
                                                @endforelse
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
    <h6>Weekly Recurring Availability</h6>

    <div class="card">
        <div class="card-body">
            <table class='table w-100'>

                @php
                    $groupedSlots = $employee->recurringAvailabilities->groupBy('day_of_week');
                @endphp

                @forelse($groupedSlots as $day => $slots)
                    <tr>
                        <th>{{ ucfirst($day) }}</th>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($slots as $slot)
                                    <li>
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - 
                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                        @if($slot->is_active === 0)
                                            <span class='badge bg-danger ms-2'>Inactive</span>
                                        @else
                                            <span class='badge bg-success ms-2'>Active</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="d-flex flex-wrap flex-column gap-1">
                            @foreach($slots as $slot)
                                <a 
                                    style="cursor:pointer;" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#timeslotmodal"
                                    data-id="{{ $slot->id }}"
                                    data-day="{{ $slot->day_of_week }}"
                                    data-start="{{ $slot->start_time }}"
                                    data-end="{{ $slot->end_time }}"
                                    data-interval="{{ $slot->interval }}"
                                    data-active="{{ $slot->is_active }}"
                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle open-timeslot-modal"
                                > 
                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                </a>    
                            @endforeach
                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No recurring availability.</td>
                    </tr>
                @endforelse

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

<!-- option Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" aria-labelledby="optionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="dynamicForm" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title" id="optionModalLabel">Edit Service</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="employee_id" value="{{ $employee->id ?? '' }}">

          <!-- Service Name -->
          <div class="mb-3" id="serviceGroup">
            <label>Service Name</label>
            <input type="text" name="service_name" id="edit_service_name" class="form-control" placeholder="e.g. Deep Cleaning">
          </div>

          <!-- Price -->
          <div class="mb-3" id="priceGroup">
            <label>Price</label>
            <input type="number" name="price" id="edit_price" class="form-control" step="0.01" placeholder="e.g. 50.00">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="employeeaddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Update employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="{{ route('employees.update') }}" method='POST' enctype="multipart/form-data">
            @csrf
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="firstname" value='{{ $employee->name }}'>
                        <input type="hidden" name="employee_id" class="form-control" id="employee_id" value='{{ $employee->id }}'>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value='{{$employee->email}}'>
                    </div>
                </div>
                <div class='row gy-3'>
                    <div class="col-12">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="employee_phone" value='{{$employee->phone}}'>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4" cols="50" id="employee_bio">{{$employee->bio}}</textarea>
                    </div>
                    <div class="col-12">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name='profile_picture' id='profile_picture' class='form-control'>
                        <img style='width:130px;' src="{{ asset('storage/' . $employee->profile_picture) }}" alt="">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary-600">Update</button>
                    </div>
                </div>
           </form>
      </div>

    </div>
  </div>
</div>


<!-- Timeslots Modal -->
<div class="modal fade" id="timeslotmodal" tabindex="-1" aria-labelledby="timeslotmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('recurring-availability.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="modal_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_day" class="form-label">Day of Week</label>
                        <input type="text" class="form-control" id="modal_day" name="day_of_week" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modal_start" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="modal_start" name="start_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_end" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="modal_end" name="end_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_interval" class="form-label">Interval (minutes)</label>
                        <input type="number" class="form-control" id="modal_interval" name="interval">
                    </div>
                    <div class="mb-3">
                        <label for="modal_active" class="form-label">Status</label>
                        <select class="form-select" name="is_active" id="modal_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Availability</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Edit Option Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1" aria-labelledby="editOptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm" method="POST" action="">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title" id="editOptionModalLabel">Edit Option</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="employee_id" value="{{ $employee->id ?? '' }}">
          <input type="hidden" name="id" id="edit_id">

          <!-- Sqft -->
          <div class="mb-3" id="editSqftGroup">
            <label>Sqft Range</label>
            <select name="edit_no_of_sqft" id="edit_no_of_sqft" class="form-control">
                @php
                    $start = 0;
                    $end = 1000;
                    while ($end <= 6500) {
                        $label = ($end === 6500) ? "{$start} - {$end}+" : "{$start} - {$end}";
                        echo "<option value=\"{$label}\">{$label}</option>";
                        $start = $end;
                        $end += 500;
                    }
                @endphp
            </select>
        </div>

          <!-- Beds -->
          <div class="mb-3" id="editBedGroup">
            <label>No of Bedrooms</label>
            <select name="beds" id="edit_beds" class='form-control'>
                <option selected>Select</option>
                @for ($i = 1; $i <= 7; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
          </div>

          <!-- Service Name -->
          <div class="mb-3" id="editServiceGroup">
            <label>Service Name</label>
            <input type="text" name="service_name" id="edit_service_name" class="form-control" placeholder="e.g. Deep Cleaning">
          </div>

          <!-- Price -->
          <div class="mb-3" id="editPriceGroup">
            <label>Price</label>
            <input type="number" name="price" id="edit_price" class="form-control" step="0.01" placeholder="e.g. 50.00">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Add Services Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('employee.attach.services') }}" method="POST">
      @csrf
      <input type="hidden" name="employee_id" value="{{ $employee->id }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceModalLabel">Add Services</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          @forelse ($services as $service)
            <div class="form-check service-checkbox-field mb-2" for="service_{{ $service->id }}">
              <input 
                class="form-check-input"
                type="checkbox"
                name="services[]"
                value="{{ $service->id }}"
                id="service_{{ $service->id }}"
                {{ $employee->services->contains($service->id) ? 'checked' : '' }}
              >
              <label class="form-check-label" for="service_{{ $service->id }}">
                {{ $service->service_name }} (${{ number_format($service->price, 2) }})
              </label>
            </div>
          @empty
            <p>No services available.</p>
          @endforelse
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Services</button>
        </div>
      </div>
    </form>
  </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-timeslot-modal').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modal_id').value = this.dataset.id;
            document.getElementById('modal_day').value = this.dataset.day;
            document.getElementById('modal_start').value = this.dataset.start;
            document.getElementById('modal_end').value = this.dataset.end;
            document.getElementById('modal_interval').value = this.dataset.interval;
            document.getElementById('modal_active').value = this.dataset.active;
        });
    });
});


$(document).on('click', '.edit-option-btn', function () {
  const type = $(this).data('type'); // should be "service"
  const id = $(this).data('id');
  const data = $(this).data('record');

  // Set form action dynamically
  $('#dynamicForm').attr('action', '/services/update/' + id); // adjust route if needed

  // Populate service fields
  $('#edit_service_name').val(data.service_name ?? '');
  $('#edit_price').val(data.price ?? '');

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('optionModal'));
  modal.show();
});


</script>

@endsection
