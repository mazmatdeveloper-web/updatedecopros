@foreach ($cleaners as $cleaner)
    <div class="card mb-2 border-0" data-cleaner-id="{{ $cleaner->id }}">
        <div class="card-body">
        <div class="cleaner-profile-box">
            @if ($cleaner->profile_picture)
                <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" width="150">
            @endif
            <p class='cleanerId' style='display:none;'>{{$cleaner->id}}</p>
            <h4 class='cleanernames'>{{ $cleaner->name }} <span class="price-value"></span></h4>
        </div>    
            @if (!empty($cleaner->available_slots))
                @foreach ($cleaner->available_slots as $slot)
                    <span class='timeslotstext'>{{ $slot }}</span>
                @endforeach
            @else
                <p class='notavailabletext'>Not available</p>
            @endif
        </div>
    </div>
@endforeach