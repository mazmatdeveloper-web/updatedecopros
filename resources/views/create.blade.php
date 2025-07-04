@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Set Cleaner Availability</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('availability.store') }}">
        @csrf

        <!-- Cleaner Selection -->
        <div class="mb-3">
            <label for="cleaner_id" class="form-label">Cleaner</label>
            <select name="cleaner_id" class="form-control" required>
                <option value="">Select Cleaner</option>
                @foreach($cleaners as $cleaner)
                    <option value="{{ $cleaner->id }}">{{ $cleaner->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Recurring Availability -->
        <div class="mb-3">
            <label class="form-label">Recurring Availability</label>
            <div id="recurring-container">
                <div class="d-flex gap-2 mb-2 recurring-row">
                    <select name="recurring[0][day]" class="form-control">
                        <option value="">Select Day</option>
                        @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                    <input type="time" name="recurring[0][start_time]" class="form-control" />
                    <input type="time" name="recurring[0][end_time]" class="form-control" />
                    <select name="recurring[0][interval]" class="form-control">
                        <option value="30">30 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="90">1.5 hours</option>
                        <option value="120" selected>2 hours</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addRecurringSlot()">+ Add Recurring Slot</button>
        </div>

        <!-- Specific Date Availability -->
        <div class="mb-3">
            <label class="form-label">Specific Date Availability</label>
            <div id="specific-container">
                <div class="specific-group border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label>Date</label>
                        <input type="date" name="specific[0][date]" class="form-control" />
                    </div>
                    <div class="specific-timeslots">
                        <div class="d-flex gap-2 mb-2">
                            <input type="time" name="specific[0][time_slots][0][start_time]" class="form-control" />
                            <input type="time" name="specific[0][time_slots][0][end_time]" class="form-control" />
                            <select name="specific[0][time_slots][0][interval]" class="form-control">
                                <option value="30">30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120" selected>2 hours</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpecificTimeSlot(this)">+ Add Time Slot</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addSpecificGroup()">+ Add Another Date</button>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    let recurringIndex = 1;
    let specificIndex = 1;

    function addRecurringSlot() {
        const container = document.getElementById('recurring-container');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'gap-2', 'mb-2', 'recurring-row');
        div.innerHTML = `
            <select name="recurring[${recurringIndex}][day]" class="form-control">
                <option value="">Select Day</option>
                @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                    <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                @endforeach
            </select>
            <input type="time" name="recurring[${recurringIndex}][start_time]" class="form-control" />
            <input type="time" name="recurring[${recurringIndex}][end_time]" class="form-control" />
            <select name="recurring[${recurringIndex}][interval]" class="form-control">
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120" selected>2 hours</option>
            </select>
        `;
        container.appendChild(div);
        recurringIndex++;
    }

    function addSpecificGroup() {
        const container = document.getElementById('specific-container');
        const group = document.createElement('div');
        group.classList.add('specific-group', 'border', 'rounded', 'p-3', 'mb-3');
        group.innerHTML = `
            <div class="mb-2">
                <label>Date</label>
                <input type="date" name="specific[${specificIndex}][date]" class="form-control" />
            </div>
            <div class="specific-timeslots">
                <div class="d-flex gap-2 mb-2">
                    <input type="time" name="specific[${specificIndex}][time_slots][0][start_time]" class="form-control" />
                    <input type="time" name="specific[${specificIndex}][time_slots][0][end_time]" class="form-control" />
                    <select name="specific[${specificIndex}][time_slots][0][interval]" class="form-control">
                        <option value="30">30 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="90">1.5 hours</option>
                        <option value="120" selected>2 hours</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpecificTimeSlot(this)">+ Add Time Slot</button>
        `;
        container.appendChild(group);
        specificIndex++;
    }

    function addSpecificTimeSlot(button) {
        const group = button.closest('.specific-group');
        const slotsContainer = group.querySelector('.specific-timeslots');
        const dateIndex = Array.from(document.querySelectorAll('.specific-group')).indexOf(group);
        const slotIndex = slotsContainer.children.length;

        const slotDiv = document.createElement('div');
        slotDiv.classList.add('d-flex', 'gap-2', 'mb-2');
        slotDiv.innerHTML = `
            <input type="time" name="specific[${dateIndex}][time_slots][${slotIndex}][start_time]" class="form-control" />
            <input type="time" name="specific[${dateIndex}][time_slots][${slotIndex}][end_time]" class="form-control" />
            <select name="specific[${dateIndex}][time_slots][${slotIndex}][interval]" class="form-control">
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120" selected>2 hours</option>
            </select>
        `;
        slotsContainer.appendChild(slotDiv);
    }
</script>
@endsection
