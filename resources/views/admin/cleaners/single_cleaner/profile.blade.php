@extends('admin.layouts.app')

@section('admin_content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div>
    @if ($cleaner->profile_picture)
        <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" class='cleaner-profile-picture'>
    @endif    
    <h6 class="fw-semibold mb-0">{{ $cleaner->name }}</h6>
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
            data-bs-target="#cleaneraddModal"
            data-id="{{ $cleaner->id }}" 
            data-name="{{$cleaner->name}}" 
            data-email="{{$cleaner->email}}"
            data-phone="{{$cleaner->phone}}"
            data-bio="{{$cleaner->bio}}"
            data-price="{{$cleaner->price}}"
            class="btn btn-primary">Update Profile
        </button>
    </div>
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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button"
                                role="tab" aria-controls="availability" aria-selected="false">Availability</button>
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->bed_area_sqfts as $index => $area)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $area->no_of_sqft }}</td>
                                                            <td>{{ $area->beds }}</td>
                                                            <td>${{ number_format($area->price, 2) }}</td>
                                                            <td style="display:flex;gap:5px;">
                                                                <a 
                                                                    style="cursor:pointer;" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#AreaSqft"
                                                                    data-beds-id="{{ $area->id }}"
                                                                    data-beds="{{ $area->beds }}"
                                                                    data-no-of-sqft="{{ $area->no_of_sqft }}"
                                                                    data-bedsprice="{{ $area->price }}"
                                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                >
                                                                    <iconify-icon icon="lucide:edit" class="menu-icon editbeds"></iconify-icon>
                                                                </a>
                                                               <form action="{{ route('delete.beds', $area->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0">
                                                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            </td>
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
                                                        <th>Price</th>.
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->bath_area_sqfts as $index => $area)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $area->no_of_sqft }}</td>
                                                            <td>{{ $area->baths }}</td>
                                                            <td>${{ number_format($area->price, 2) }}</td>
                                                            <td style="display:flex;gap:5px;">
                                                                <a 
                                                                    style="cursor:pointer;" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#BathAreaSqft"
                                                                    data-bath-id="{{ $area->id }}"
                                                                    data-bath="{{ $area->baths }}"
                                                                    data-bat-no-of-sqft="{{ $area->no_of_sqft }}"
                                                                    data-bathprice="{{ $area->price }}"
                                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                >
                                                                    <iconify-icon icon="lucide:edit" class="menu-icon editbeds"></iconify-icon>
                                                                </a>
                                                               <form action="{{route ('delete.baths', $area->id) }}')}}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0">
                                                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            </td>
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
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($cleaner->service as $index => $service)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $service->service_name }}</td>
                                                            <td>${{ number_format($service->price, 2) }}</td>
                                                            <td style="display:flex;gap:5px;">
                                                                <a 
                                                                    style="cursor:pointer;" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#ServiceModal"
                                                                    data-service-id="{{ $service->id }}"
                                                                    data-service-name="{{ $service->service_name }}"
                                                                    data-service-price="{{ $service->price }}"
                                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                >
                                                                    <iconify-icon icon="lucide:edit" class="menu-icon editbeds"></iconify-icon>
                                                                </a>
                                                              <form action="{{ route('delete.service', $service->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0">
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
                                                @forelse($cleaner->availableDates as $date)
                                                    <tr>
                                                        <th>{{ \Carbon\Carbon::parse($date->dates)->format('F j, Y') }}</th>
                                                        <td class="list-group">
                                                            @foreach($date->timeSlots as $slot)
                                                                
                                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                                            @endforeach
                                                        </td>
                                                         <td>@if($date->is_disabled === 0)
                                                        <span class='badge bg-danger'>In-Active</span>
                                                        @else
                                                        <span class='badge bg-success'>Active</span>
                                                        @endif
                                                    </td>
                                                         <td style="display:flex;gap:5px;">
                                                        <a 
                                                            style="cursor:pointer;" 
                                                            data-bs-target="#availiblemodel" 
                                                            data-bs-toggle="modal" 
                                                            data-availible-id="{{ $date->id }}"
                                                            data-availible="{{ $date->dates }}"
                                                            data-availible-start="{{ $slot->start_time }}"
                                                            data-availible-end="{{ $slot->end_time }}"
                                                            data-availible-interval="{{ $slot->interval }}"
                                                            data-availible-active="{{ $date->is_disabled }}"
                                                            class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                        >
                                                            <iconify-icon icon="lucide:edit" class="menu-icon editbeds"></iconify-icon>
                                                        </a>
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

                                            @forelse($cleaner->recurringAvailabilities as $recurring)

                                            <tr>
                                                <th>{{ ucfirst($recurring->day_of_week) }}</th>
                                                <td>  {{ \Carbon\Carbon::parse($recurring->start_time)->format('g:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($recurring->end_time)->format('g:i A') }}
                                                </td>
                                                <td>@if($recurring->is_active === 0)
                                                    <span class='badge bg-danger'>In-Active</span>
                                                    @else
                                                    <span class='badge bg-success'>Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <a 
                                                    style="cursor:pointer;" 
                                                    data-bs-toggle="modal" 

                                                    data-bs-target="#timeslotmodal"
                                                    data-id="{{ $recurring->id }}"
                                                    data-day="{{ $recurring->day_of_week }}"
                                                    data-start="{{ $recurring->start_time }}"
                                                    data-end="{{ $recurring->end_time }}"
                                                    data-interval="{{ $recurring->interval }}"
                                                    data-active="{{ $recurring->is_active }}"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle open-timeslot-modal"
                                                > 
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>
                                                </td>
                                            </tr>

                                            @empty
                                            <tr>
                                                <td>No recurring availability.</td>
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

<!-- Bed Modal -->
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
            <label>From (Sqft)</label>
            <input type="text" name="from" class="form-control" placeholder="e.g. 1000">
        </div>

        <div class="mb-3" id="sqftGroup">
            <label>To (Sqft)</label>
            <input type="text" name="to" class="form-control" placeholder="e.g. 1000">
        </div>

        <!-- Beds -->
        <div class="mb-3" id="bedGroup">
            <label>No of Bedrooms</label>
            <!-- <input type="number" name="beds" class="form-control" placeholder="e.g. 2"> -->
            <select name="beds" class='form-control'>
                <option selected>Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
        </div>

        <!-- Baths -->
        <div class="mb-3" id="bathGroup">
            <label>No of Bathrooms</label>
            <select name="baths" class='form-control'>
                <option selected>Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
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


<div class="modal fade" id="cleaneraddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Update Cleaner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <!-- Modal Body with Form -->
    <div class="modal-body">
    <form action="{{ route('cleaners.update') }}" method='POST' enctype="multipart/form-data">
            @csrf
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="firstname" value='{{ $cleaner->name }}'>
                        <input type="hidden" name="cleaner_id" class="form-control" id="cleaner_id" value='{{ $cleaner->id }}'>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value='{{$cleaner->email}}'>
                    </div>
                </div>
                <div class='row gy-3'>
                    <div class="col-12">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="cleaner_phone" value='{{$cleaner->phone}}'>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4" cols="50" id="cleaner_bio">{{$cleaner->bio}}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value='{{$cleaner->price}}'>
                    </div>
                    <div class="col-12">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name='profile_picture' id='profile_picture' class='form-control'>
                        <img style='width:130px;' src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="*******">
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

<!-- Availible Modal -->
<div class="modal fade" id="availiblemodel" tabindex="-1" aria-labelledby="availiblemodel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="availibilityForm">
            @csrf
            <input type="hidden" name="id" id="modal_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_day" class="form-label">Date</label>
                        <input type="date" class="form-control" id="availible_date" name="availible_date">
                    </div>
                    <div class="mb-3">
                        <label for="modal_start" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="availible_start_time" name="availible_start_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_end" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="availible_end_time" name="availible_end_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_interval" class="form-label">Interval (minutes)</label>
                        <input type="number" class="form-control" id="availible_modal_interval" name="availible_interval">
                    </div>
                    <div class="mb-3">
                        <label for="modal_active" class="form-label">Status</label>
                        <select class="form-select" name="is_disabled" id="availible_active">
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

<!-- Bed Modal -->
<div class="modal fade" id="AreaSqft" tabindex="-1" aria-labelledby="AreaSqft" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <form id="bedsform" method="POST" action="">
        @csrf
        <input type="hidden" name="id" id="beds_id">
        <div class="modal-header">
        <h6 class="modal-title">Edit Bedroom Option</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <input type="hidden" name="cleaner_id" value="{{ $cleaner->id ?? '' }}">
        <input type="hidden" name="no_of_sqft" id="no_of_sqft"> <!-- Hidden field for combined value -->

        <!-- Sqft Range (split into from/to) -->
        <div class="row mb-3">
            <div class="col-md-6">
            <label>From (Sqft)</label>
            <input type="number" class="form-control" id="beds_from" min="0" required>
            </div>
            <div class="col-md-6">
            <label>To (Sqft)</label>
            <input type="number" class="form-control" id="beds_to" min="0" required>
            </div>
        </div>

        <!-- Bedrooms -->
        <div class="mb-3">
            <label>Number of Bedrooms</label>
            <select name="beds" class='form-control' id="bedsroom" required>
                <option value="">Select number of bedrooms</option>
                @for($i = 1; $i <= 7; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        
        <!-- Price -->
        <div class="mb-3">
            <label>Price ($)</label>
            <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" name="price" class="form-control" step="0.01" min="0" placeholder="e.g. 50.00" id="beds_price" required>
            </div>
        </div>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
    </div>
</div>
</div>  
</div>


<!-- Bath Modal -->
<div class="modal fade" id="BathAreaSqft" tabindex="-1" aria-labelledby="BathAreaSqft" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="bathform" method="POST" action="">
            @csrf
            <input type="hidden" name="id" id="bath_id">
            <div class="modal-header">
                <h6 class="modal-title">Edit Bathroom Option</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="cleaner_id" value="{{ $cleaner->id ?? '' }}">
                <input type="hidden" name="no_of_sqft" id="bath_no_of_sqft">

                <!-- Sqft Range (split into from/to) -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>From (Sqft)</label>
                        <input type="number" class="form-control" id="bath_from" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label>To (Sqft)</label>
                        <input type="number" class="form-control" id="bath_to" min="0" required>
                    </div>
                </div>

                <!-- Bathrooms -->
                <div class="mb-3">
                    <label>Number of Bathrooms</label>
                    <select name="baths" class='form-control' id="bathsroom" required>
                        <option value="">Select number of bathrooms</option>
                        @for($i = 1; $i <= 7; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <!-- Price -->
                <div class="mb-3">
                    <label>Price ($)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" placeholder="e.g. 50.00" id="bath_price" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Service Modal  -->

<div class="modal fade" id="ServiceModal" tabindex="-1" aria-labelledby="ServiceModal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="serviceform" method="POST" action="">
            @csrf
            <input type="hidden" name="id" id="service_id">
            <div class="modal-header">
                <h6 class="modal-title">Edit Services </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="cleaner_id" value="{{ $cleaner->id ?? '' }}">

                 <!-- Service Name -->
                <div class="mb-3" id="serviceGroup">
                    <label>Service Name</label>
                    <input type="text" name="service_name" class="form-control" placeholder="e.g. Deep Cleaning" id="service_name">
                </div>

                <!-- Price -->
                <div class="mb-3" id="priceGroup">
                    <label>Price</label>
                    <input type="number" name="service_price" class="form-control" step="0.01" placeholder="e.g. 50.00" id="service_price">
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
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
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button clicks
    document.querySelectorAll('[data-bs-target="#AreaSqft"]').forEach(button => {
        button.addEventListener('click', function() {
            // Extract data attributes
            const bedsId = this.getAttribute('data-beds-id');
            const beds = this.getAttribute('data-beds');
            const sqftRange = this.getAttribute('data-no-of-sqft'); // "0 - 1000"
            const price = this.getAttribute('data-bedsprice');
            
            // Parse sqft range (format "0 - 1000")
            const [from, to] = sqftRange.split(' - ').map(s => s.trim());
            
            document.getElementById('beds_id').value = bedsId;
            document.getElementById('beds_from').value = from;
            document.getElementById('beds_to').value = to;
            document.getElementById('bedsroom').value = beds;
            document.getElementById('beds_price').value = price;
            
            document.getElementById('bedsform').action = `/update-beds/${bedsId}`;
        });
    });

    document.getElementById('bedsform').addEventListener('submit', function(e) {
        const from = document.getElementById('beds_from').value;
        const to = document.getElementById('beds_to').value;
        document.getElementById('no_of_sqft').value = `${from} - ${to}`;
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
// Handle edit button clicks for bath
document.querySelectorAll('[data-bs-target="#BathAreaSqft"]').forEach(button => {
    button.addEventListener('click', function() {
        // Extract data attributes
        const bathId = this.getAttribute('data-bath-id');
        const baths = this.getAttribute('data-bath');
        const sqftRange = this.getAttribute('data-bat-no-of-sqft'); // "0 - 1000"
        const price = this.getAttribute('data-bathprice');
        
        const [from, to] = sqftRange.split(' - ').map(s => s.trim());
        
        document.getElementById('bath_id').value = bathId;
        document.getElementById('bath_from').value = from;
        document.getElementById('bath_to').value = to;
        document.getElementById('bathsroom').value = baths;
        document.getElementById('bath_price').value = price;
        
        document.getElementById('bathform').action = `/update-baths/${bathId}`;
    });
});

document.getElementById('bathform').addEventListener('submit', function(e) {
    const from = document.getElementById('bath_from').value;
    const to = document.getElementById('bath_to').value;
    document.getElementById('bath_no_of_sqft').value = `${from} - ${to}`;
});
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
// Handle edit button clicks for bath
document.querySelectorAll('[data-bs-target="#ServiceModal"]').forEach(button => {
    button.addEventListener('click', function() {
        // Extract data attributes
        const serviceId = this.getAttribute('data-service-id');
        const servicename = this.getAttribute('data-service-name');
        const servicprice = this.getAttribute('data-service-price');
                    
        document.getElementById('service_id').value = serviceId;
        document.getElementById('service_name').value = servicename;
        document.getElementById('service_price').value = servicprice;
        
        document.getElementById('serviceform').action = `/update-services/${serviceId}`;
    });
});

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
// Listen to all edit availability buttons
document.querySelectorAll('[data-bs-target="#availiblemodel"]').forEach(button => {
    button.addEventListener('click', function () {
        // Read attributes from clicked button
        const id = this.getAttribute('data-availible-id');
        const date = this.getAttribute('data-availible');
        const start = this.getAttribute('data-availible-start');
        const end = this.getAttribute('data-availible-end');
        const interval = this.getAttribute('data-availible-interval');
        const active = this.getAttribute('data-availible-active');
        

        // Set values in the modal form
        document.getElementById('modal_id').value = id;
        document.getElementById('availible_date').value = date;
        document.getElementById('availible_start_time').value = start;
        document.getElementById('availible_end_time').value = end;
        document.getElementById('availible_modal_interval').value = interval;
        document.getElementById('availible_active').value = active;

        // Optionally set form action dynamically
        document.querySelector('#availiblemodel form').action = `/update-availible/date/${id}`;
    });
});
});
</script>


@endsection
