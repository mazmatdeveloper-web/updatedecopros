<div class="row d-flex justify-content-center">
                
                @foreach ($cleaners as $cleaner)
                
                <div class="col-md-5">
                <div class="card mb-2 border-0" data-cleaner-id="{{ $cleaner->id }}">
                            <div class="card-body mb-2">
                            <div class="cleaner-profile-box d-flex align-items-center justify-content-between">
                                <div class="cleaner-name d-flex align-items-center gap-2">
                                    @if ($cleaner->profile_picture)
                                        <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" width="150">
                                    @endif
                                    <p class='cleanerId' style='display:none;'>{{$cleaner->id}}</p>
                                    <div>
                                        <h4 class='cleanernames mb-0'>{{ $cleaner->name }} </h4>
                                    @if (!empty($cleaner->available_slots))    
                                        <span class='avialable-badge'>Available</span>
                                    @endif
                                    </div>
                                </div>
                            <div>
                                <span class='base_price'></span>
                                <span class="price-value"></span>
                            </div>
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
                </div>
                      
                
                @endforeach
                </div>