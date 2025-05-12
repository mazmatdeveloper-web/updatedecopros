@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $cleaner->name }}'s Availability</h2>

    <!-- Cleaner Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>{{ $cleaner->name }}</h5>
            <p>{{ $cleaner->email }}</p>
        </div>
    </div>

    <!-- Date Picker -->
    <div class="mb-4">
        <label for="date-picker" class="form-label">Select Available Date:</label>
        <input type="text" id="date-picker" class="form-control" placeholder="Click to select a date">
    </div>

    <!-- Time Slots -->
    <h5>Time Slots for <span id="selected-date"></span></h5>
    <div id="time-slots" class="row"></div>

    <!-- Hidden Booking Form -->
    <form id="booking-form" action="{{ route('book.appointment') }}" method="POST">
        @csrf
        <input type="hidden" name="cleaner_id" value="{{ $cleaner->id }}">
        <input type="hidden" name="appointment_date" id="selected-appointment-date">
        <input type="hidden" name="start_time" id="start-time">
        <input type="hidden" name="end_time" id="end-time">
        <button type="submit" id="book-now" class="btn btn-success mt-4" style="display: none;">Book Now</button>
    </form>
</div>

<!-- Scripts & Styles -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
     const availableDates = @json($cleaner->availableDates->pluck('dates'));
    const slotData = @json($availableSlotData);
    const recurringAvailability = @json($recurringByDay);
    const bookedSlots = @json($appointments);

    const availableSet = new Set(availableDates);

    function formatTimeToHHMMSS(date) {
        return date.toTimeString().split(' ')[0];
    }

    function generateDynamicSlots(start, end, intervalMinutes) {
        const result = [];
        const startTime = new Date(`1970-01-01T${start}`);
        const endTime = new Date(`1970-01-01T${end}`);
        const intervalMs = intervalMinutes * 60 * 1000;

        while (startTime.getTime() + intervalMs <= endTime.getTime()) {
            const endSlot = new Date(startTime.getTime() + intervalMs);
            result.push({
                start: formatTimeToHHMMSS(startTime),
                end: formatTimeToHHMMSS(endSlot)
            });
            startTime.setTime(startTime.getTime() + intervalMs);
        }
        return result;
    }

    function isSlotBooked(date, start, end) {
        return bookedSlots.some(slot => {
            return slot.date === date && start < slot.end_time && end > slot.start_time;
        });
    }

    $('#date-picker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(date) {
            const formatted = $.datepicker.formatDate('yy-mm-dd', date);
            const dayName = date.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
            if (availableSet.has(formatted)) {
                return [true, 'available-date', 'Available'];
            } else if (recurringAvailability[dayName]) {
                return [true, 'recurring-date', 'Recurring'];
            }
            return [false, '', 'Unavailable'];
        },
        onSelect: function(dateText) {
            $('#selected-date').text(dateText);
            $('#selected-appointment-date').val(dateText);

            const selectedDate = new Date(dateText);
            const weekday = selectedDate.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();

            let slots = slotData[dateText]?.time_slots;
            let interval = slotData[dateText]?.interval ?? 60;

            if (!slots || !slots.length) {
                slots = recurringAvailability[weekday] || [];
                interval = recurringAvailability[weekday]?.[0]?.interval ?? 60;
            }

            let html = '';
            slots.forEach(slot => {
                const segments = generateDynamicSlots(slot.start_time, slot.end_time, slot.interval ?? interval);
                if (segments.length) {
                    segments.forEach(seg => {
                        const booked = isSlotBooked(dateText, seg.start, seg.end);
                        html += `
                            <div class="col-md-3 mb-2">
                                <div class="card ${booked ? 'bg-light' : ''}">
                                    <div class="card-body text-center">
                                        ${seg.start} - ${seg.end}
                                        ${booked 
                                            ? '<span class="badge bg-secondary mt-2">Booked</span>' 
                                            : `<button type="button" class="btn btn-primary btn-sm mt-2 book-slot" 
                                                        data-date="${dateText}" 
                                                        data-start="${seg.start}" 
                                                        data-end="${seg.end}">
                                                Book
                                            </button>`}
                                    </div>
                                </div>
                            </div>`;
                    });
                }
            });

            if (!html) {
                html = '<p class="text-muted">No time slots available</p>';
            }

            $('#time-slots').html(html);
        }
    });

    $(document).on('click', '.book-slot', function() {
        const date = $(this).data('date');
        const startTime = $(this).data('start');
        const endTime = $(this).data('end');

        $('#selected-appointment-date').val(date);
        $('#start-time').val(formatToHMM(startTime));
        $('#end-time').val(formatToHMM(endTime));
        $('#book-now').show();
    });

    function formatToHMM(time) {
        const parts = time.split(':');
        return parts[0] + ':' + parts[1];
    }
</script>

<style>
    .available-date a {
        background-color: #28a745 !important;
        color: white !important;
        font-weight: bold;
    }
    .recurring-date a {
        background-color: #17a2b8 !important;
        color: white !important;
        font-weight: bold;
    }
</style>
@endsection
