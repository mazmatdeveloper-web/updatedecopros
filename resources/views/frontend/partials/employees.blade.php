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
                                        <h4 class='employeenames mb-0'>{{ $employee->name }} </h4>
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
                                    <span class='timeslotstext' 
                                        data-slot="{{ $slot }}" 
                                        data-employee-id="{{ $employee->id }}">
                                        {{ $slot }}
                                    </span>
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