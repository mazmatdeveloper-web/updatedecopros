@extends('layouts.app')
@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::today();
    $startOfWeek = $today->copy()->startOfWeek(Carbon::SUNDAY);
    $selectedAddons = session('booking.addons', []);
    $selectedServices = session('booking.services', []);
@endphp
<div class="error-div" style='display:none;'>
    <p class='mb-0' id='serviceErrorMessage'></p>
</div>
<div class="main-content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 pt-4 pb-5">
                <a href="{{ route('booking') }}" class="btn btn-secondary">← Back</a>
                <form action="" class='filters-form'>
                    @csrf
                    <input type="hidden" name="address" id="address_hidden" value="{{ $quoteData['address'] ?? '' }}">
                    <div class="form-group-field">
                        <label class='field_group_label'>Select Additional Services</label><br>
                        <button type="button" id="toggleAddons" class='w-100'>Available Services</button>
                        <div class="addons-div" id="addonsDiv">
                            @foreach($addons as $addon)
                                <div class="more-options">
                                    <input type="checkbox" id="addon_{{ $addon->id }}" name="addons[]" value="{{ $addon->id }}" {{ in_array($addon->id, $selectedAddons) ? 'checked' : '' }}>
                                    <label for="addon_{{ $addon->id }}">{{ $addon->addon_name }}</label><br>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class='field_group_label'>Which service would you like?</label><br>
                        <button type="button" id="toggleServices" class="w-100 mb-0 border-0">Select Services</button>
                        <div class="services-div mb-3" id="servicesDiv" style="display: none;">
                            @foreach($services as $service)
                                <div class="more-options">
                                    <input type="checkbox" class="service-checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}" {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}>
                                    <label for="service_{{ $service->id }}">{{ $service->service_name }} - ${{ number_format($service->price, 2) }}</label><br>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
                <div class="date-div">
                    <div class="d-flex align-items-center my-3">
                        <button id="prevDay" class="btn btn-light me-2">←</button>
                        <div id="weekDates" class="d-flex gap-2 flex-grow-1 overflow-auto"></div>
                        <button id="nextDay" class="btn btn-light ms-2">→</button>
                    </div>
                    <h3 class="mx-3" id="selectedDateDisplay">{{ $today->format('F j') }}</h3>
                    <input type="hidden" id="weekStartDate" value="{{ $startOfWeek->toDateString() }}">
                    <input type="hidden" id="selectedDateInput" value="{{ $today->toDateString() }}">
                </div>
                <div id="employeesContainer">
                    <div class="row d-flex justify-content-center align-items-stretch">
                        @foreach ($employees as $employee)
                            <div class="col-md-5">
                                <div class="card mb-2 border-0 h-100" data-employee-id="{{ $employee->id }}">
                                    <div class="card-body mb-2">
                                        <div class="employee-profile-box d-flex align-items-center justify-content-between">
                                            <div class="employee-name d-flex align-items-center gap-2">
                                                @if ($employee->profile_picture)
                                                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" width="150">
                                                @endif
                                                <p class='employeeId' style='display:none;'>{{$employee->id}}</p>
                                                <div>
                                                    <h4 class='employeenames mb-0'>{{ $employee->name }}</h4>
                                                    @if (!empty($employee->available_slots))
                                                        <span class='avialable-badge'>Available</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <span class='base_price'></span>
                                                <span class="price-value"></span>
                                            </div>
                                        </div>
                                        @if (!empty($employee->available_slots))
                                            @foreach ($employee->available_slots as $slot)
                                                <span class='timeslotstext' data-slot="{{ $slot }}" data-employee-id="{{ $employee->id }}">{{ $slot }}</span>
                                            @endforeach
                                        @else
                                            <p class='notavailabletext'>Not available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3 cart-col" style='height:100vh;'>
                <h2 class='cart-col-title mb-4'>Summary</h2>
                <h3 class='summary-labels'>Address</h3>
                <div class="additional-services-div mb-4">
                    <table class='additional-services-table w-100'>
                        <tr>
                            <td class='text-start'>{{ $quoteData['address'] }}</td>
                        </tr>
                    </table>
                </div>
                <h3 class='summary-labels'>Services</h3>
                <div class="dimensions-div mb-4">
                    <table class='dimensions-table w-100'>
                        <tr>
                            <td class='text-start' id='service_summary'></td>
                        </tr>
                    </table>
                </div>
                <h3 class='summary-labels'>Additional Services</h3>
                <div class="additional-services-div mb-4">
                    <table class='additional-services-table w-100'>
                        <tr>
                            <td class='text-start' id='addon_name_summary'>Interior Refrigerator</td>
                            <td id='addon_price_summary'></td>
                        </tr>
                    </table>
                </div>
                <input type="hidden" name='selectedTimeSlot' id='selectedTimeSlot'>
                <input type="hidden" name='selectedemployeeId' id='selectedemployeeId'>
                <button style='display:none;' class='continuebtn'>Continue</button>
            </div>
        </div>
    </div>
</div>


<script>

function updatePrices() {
        let filters = {
            service_type: $('input[name="services[]"]:checked').map(function() {
                return $(this).val();
            }).get(),
            addons: $('input[name="addons[]"]:checked').map(function() {
            return $(this).val();
            }).get(),
            _token: '{{ csrf_token() }}'
        };
    
        $.ajax({
            url: "{{ route('calculate.prices') }}",
            method: 'POST',
            data: filters,
            success: function(response) {

                response.forEach(function(item, index) {
                    const card = $('.card[data-employee-id="' + item.employee_id + '"]');
                                 
    
                    let addonNames = '';
                    let addonPrices = '';

                    if (Array.isArray(item.addons) && item.addons.length > 0) {
                        item.addons.forEach(function(addon) {
                            addonNames += addon.addon_name + '<br>';
                            // addonPrices += `$${addon.price}<br>`;
                        });

                        $('#addon_name_summary').html(addonNames);
                        $('#addon_price_summary').html(addonPrices);
                       
                    } else {
                        $('#addon_name_summary').text('No Additional Services');
                        // $('#addon_price_summary').text('$0');
                    }

                    let allServices = [];

                    response.forEach(function(emp) {
                        allServices = allServices.concat(emp.service_names);
                    });

                    // Remove duplicates and empty strings
                    let uniqueServices = [...new Set(allServices.filter(s => s !== ''))];

                    if (uniqueServices.length > 0) {
                        $('#service_summary').html(uniqueServices.join('<br>'));
                    } else {
                        $('#service_summary').html('No services selected');
                    }
                    

                });

            },
            error: function(xhr) {
                console.error('Error fetching prices:', xhr.responseText);
            }
        });
    }

    function generateWeekButtons(startDateStr) {
        const startDate = new Date(startDateStr);
        const todayStr = new Date().toISOString().split('T')[0];
        const selectedDate = $('#selectedDateInput').val();
        let weekHtml = '';

        for (let i = 0; i < 7; i++) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + i);
            const dateStr = date.toISOString().split('T')[0];

            const isSelected = dateStr === selectedDate;
            const isToday = dateStr === todayStr;
            const isPast = dateStr < todayStr;

            weekHtml += `
                <button type="button"
                        class="date-button ${isSelected ? 'btn-selected' : 'btn-not-selected'} ${isToday ? 'today-button' : ''} ${isPast ? 'disabled' : ''}"
                        data-date="${dateStr}"
                        ${isPast ? 'disabled' : ''}>
                    ${date.toLocaleDateString('en-US', { weekday: 'short' })}<br>
                    ${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}
                </button>`;
        }

        $('#weekDates').html(weekHtml);
    }

    function updateSelectedDateDisplay(dateStr) {
        const displayDate = new Date(dateStr);
        const formatted = displayDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
        $('#selectedDateDisplay').text(formatted);
    }

    function updateDateByOffset(offset) {
        const current = new Date($('#selectedDateInput').val());
        current.setDate(current.getDate() + offset);

        const newDateStr = current.toISOString().split('T')[0];
        const todayStr = new Date().toISOString().split('T')[0];

        if (newDateStr < todayStr) return; // prevent past selection

        $('#selectedDateInput').val(newDateStr);
        updateSelectedDateDisplay(newDateStr);

        const currentWeekStart = new Date($('#weekStartDate').val());
        const currentWeekEnd = new Date(currentWeekStart);
        currentWeekEnd.setDate(currentWeekStart.getDate() + 6);

        if (current < currentWeekStart || current > currentWeekEnd) {
            const newWeekStart = new Date(current);
            newWeekStart.setDate(newWeekStart.getDate() - newWeekStart.getDay()); // Sunday
            const newStartStr = newWeekStart.toISOString().split('T')[0];
            $('#weekStartDate').val(newStartStr);
            generateWeekButtons(newStartStr);
        } else {
            generateWeekButtons($('#weekStartDate').val());
        }

        fetchData(newDateStr);
    }

    function fetchData(date) {
        console.log('first called function');
        var address = $('#address_hidden').val(); 
        var services = $('input[name="services[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        $.ajax({
            url: $('#dateForm')?.attr('action') ?? '',
            type: 'POST',
            data: {
                    date: date,
                    address: address,
                    service_type: services,
                    _token: '{{ csrf_token() }}'
                },
            success: function (response) {
                $('#employeesContainer').html(response.html);
                updatePrices();
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        const today = new Date();
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() - today.getDay()); // Set to Sunday
        const weekStartStr = weekStart.toISOString().split('T')[0];

        $('#weekStartDate').val(weekStartStr);
        $('#selectedDateInput').val(today.toISOString().split('T')[0]);

        generateWeekButtons(weekStartStr);
        updateSelectedDateDisplay($('#selectedDateInput').val());
        fetchData($('#selectedDateInput').val());

        $(document).on('click', '.date-button', function () {
            const selectedDate = $(this).data('date');
            if (new Date(selectedDate) < new Date().setHours(0, 0, 0, 0)) return;

            $('#selectedDateInput').val(selectedDate);
            updateSelectedDateDisplay(selectedDate);
            generateWeekButtons($('#weekStartDate').val());
            fetchData(selectedDate);
        });

        $('#prevDay').on('click', () => updateDateByOffset(-1));
        $('#nextDay').on('click', () => updateDateByOffset(1));
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const addonsBtn = document.getElementById('toggleAddons');
    const addonsDiv = document.getElementById('addonsDiv');
    const servicesBtn = document.getElementById('toggleServices');
    const servicesDiv = document.getElementById('servicesDiv');

    addonsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        addonsDiv.style.display = addonsDiv.style.display === 'block' ? 'none' : 'block';
        servicesDiv.style.display = 'none';
    });

    servicesBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        servicesDiv.style.display = servicesDiv.style.display === 'block' ? 'none' : 'block';
        addonsDiv.style.display = 'none';
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#addonsDiv') && !e.target.closest('#toggleAddons')) {
            addonsDiv.style.display = 'none';
        }
        if (!e.target.closest('#servicesDiv') && !e.target.closest('#toggleServices')) {
            servicesDiv.style.display = 'none';
        }
    });
});
</script>


<script>
   $(document).on('click', '.timeslotstext', function() {
        $('.timeslotstext').removeClass('selected');
        $(this).addClass('selected');
        
        let card = $(this).closest('.card');
        let selectedTimeslot = $(this).text();
        let employeeId = card.find('.employeeId').text();
        let selectedService = $('input[name="services[]"]:checked').map(function() {
                return $(this).val();
            }).get();

        console.log(selectedService);

        $.ajax({
        url: "{{ route('check.employee.service') }}",
        method: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            employee_id: employeeId,
            service_type: selectedService,
        },
        success: function(response) {
            if (response.exists) {
                $('.continuebtn').show();
            } else {
                let msg = "This employee doesn't meet your requirements.";
                if (response.reason === 'service') msg = "employee doesn't offer " + selectedService;
                $('#serviceErrorMessage').text(msg);
                $('.error-div').show();
                $('.continuebtn').hide();
                setTimeout(() => $('.error-div').fadeOut(), 2000);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
        });

        // store data globally or in hidden inputs
        $('input[name="selectedTimeSlot"]').val(selectedTimeslot);
        $('input[name="selectedemployeeId"]').val(employeeId);
});

    $(document).ready(function () {
        // $('#dateInput').on('change', function () {
        //     console.log('first called function');
        //     var selectedDate = $(this).val();
        //     var address = $('input[name="address"]').val(); 
        //     var services = $('input[name="services[]"]:checked').map(function () {
        //         return $(this).val();
        //     }).get();
        //     var url = $('#dateForm').attr('action');

        //     $.ajax({
        //         url: url,
        //         type: 'POST',
        //         data: {
        //             date: selectedDate,
        //             address: address,
        //             service_type: services,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function (response) {
        //             $('#employeesContainer').html(response.html);
        //             updatePrices(); 
        //         },
        //         error: function (xhr) {
        //             console.error('An error occurred:', xhr.responseText);
        //         }
        //     });
        // });

    // Trigger price update on filter change
    $('input[name="services[]"], input[name="addons[]"]').on('change', updatePrices);

    // Initial price load
    updatePrices();

    // $('#employeesContainer').on('click', '.continuebtn', function() {
     $('.continuebtn').on('click', function() {

        let dateInput = $('#selectedDateInput').val();
        let employeeId = $('#selectedemployeeId').val();
        let selectedslot = $('#selectedTimeSlot').val();
        let service = $('input[name="services[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let selectedAddons = $('input[name="addons[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let params = new URLSearchParams({
            employee: employeeId,
            slot: selectedslot,
            selecteddate: dateInput,
            
        });

         // Append each addon[] manually
        selectedAddons.forEach(id => {
            params.append('addons[]', id);
        });

        service.forEach(id => {
            params.append('services[]', id);
        });

        window.location.href = '/checkout/?' + params.toString();

    });
});

</script>

@endsection