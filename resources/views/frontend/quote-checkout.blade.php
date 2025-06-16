@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class='my-3 text-center'>Confirm Service</h4>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-7">
           <div class="row py-5 d-flex justify-content-center">
                <div class="col-md-10 checkout-box">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="cleaner-profile-selected">
                        <div class="profile-picturebox">
                                @if ($cleaner->profile_picture)
                                    <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" width="150">
                                @endif
                        </div>
                        <div class="cleaner-name-box">
                            <h4>{{$cleaner->name}}</h4>
                            <p>House Cleaning</p>
                        </div>
                    </div>

                    <div class="selected-items-container mt-3">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>Dimensions</th>
                                <td class='text-end'><span class='selected-beds'>{{ $beds }}</span> BD / <span class='selected-baths'>{{$baths}}</span> BA / <span class='selected-area'>{{$area_sqft}}</span> sqft</td>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                @php
                                    use Carbon\Carbon;
                                    $formattedDate = Carbon::parse($selectedDate)->format('D, M d');
                                @endphp

                                <td class='text-end'>
                                    {{ $formattedDate }} at {{ $slot }}
                                </td>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                @if($frequency === 'one_time')
                                <td class='text-end'>One Time</td>
                                @elseif($frequency === 'weekly')
                                <td class='text-end'>Every Week</td>
                                @elseif($frequency === 'biweekly')
                                <td class='text-end'>Biweekly</td>
                                @elseif($frequency === 'monthly')
                                <td class='text-end'>Every Month</td>
                                @endif
                            </tr>
                            <tr>
                                @if($selectedAddons->isNotEmpty())
                                <th class='d-flex'>Additional Services</th>
                                <td class='text-end'> 
                                    
                                        <ul class='addon-list' style='list-style:none;'>
                                            @foreach($selectedAddons as $addon)
                                                <li>{{ $addon->addon_name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="selected-items-container mt-2">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>One-time Price</th>
                                <td class='text-end'>${{number_format($oneTimePrice, 2)}}</td>
                            </tr>
                            @if(isset($discountAmounts[$frequency]))
                              
                                    @if($frequency === 'weekly')
                                         <tr>  
                                        <th>Weekly Discount (20% off)</th>
                                        <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                        </tr>
                                        @elseif($frequency === 'biweekly')
                                        <tr>
                                        <th>Biweekly Discount (10% off)</th>
                                        <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                        </tr>
                                        @elseif($frequency === 'monthly')
                                        <tr>
                                        <th>Monthly Discount (10% off)</th>
                                    <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                    </tr>
                                    @endif
                            
                            @endif
                        </table>
                    </div>

                    <div class="selected-items-container mt-2">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>Total</th>
                                <td class='text-end'>${{number_format($discountedPrices[$frequency], 2)}}</td>
                            </tr>
                            
                        </table>
                    </div>

                    @auth
                        @if(Auth::user()->role !== 'admin')
                        <form action="{{ route('book.appointment') }}" method='POST'>
                            @csrf
                            <input type="hidden" name='cleaner_id' value='{{ $cleaner->id }}'>
                            <input type="hidden" name='customer_id' value='{{ Auth::user()->id }}'>
                            <input type="hidden" name='beds_area_sqft_id' value='{{ $bedPriceModel->id ?? "" }}'>
                            <input type="hidden" name='baths_area_sqft_id' value='{{ $bathPriceModel->id ?? "" }}'>
                            <input type="hidden" name='service_id' value='{{ $servicePriceModel->id ?? "" }}'>
                            <input type="hidden" name='discount_label' value='{{ $frequency }}'>
                            <input type="hidden" name='discount_price' value='{{ number_format($discountAmounts[$frequency], 2) }}'>
                            <input type="hidden" name='total_price' value='{{ number_format($discountedPrices[$frequency], 2) }}'>
                            <input type="hidden" name='appointment_date' value='{{ $selectedDate }}'>
                            @php
                                $parts = explode(' - ', $slot);
                                $start_time = $parts[0] . ':00';
                                $end_time = $parts[1] . ':00';
                            @endphp

                            <input type="hidden" name="start_time" value="{{ $start_time }}">
                            <input type="hidden" name="end_time" value="{{ $end_time }}">
                            @php
                                $addonIds = collect(json_decode($selectedAddons, true))->pluck('id')->toJson();
                            @endphp

                            <input type="hidden" name="addon_ids" value='{{ $addonIds }}'>
                            <label class='mt-3' for="address">Address</label>
                            <input name="address" class='form-control bg-white text-dark' placeholder='Enter Your Address' id="address">
                            <label class='mt-2' for="additional_notes">Additional Notes</label>
                            <textarea name="additional_notes" class='form-control bg-white text-dark' placeholder='Enter Notes for cleaner' id="additional_notes" cols="30" rows="5"></textarea>
                           
                            <button class='continuebtn' type='submit'>Continue</button>
                        </form>
                            
                        @endif
                    @else
                        <div class="login-btns-div">
                        <button type='button' class='loginbtn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                            Login & Confirm
                        </button>
                        </div>
                    @endauth
                    
                </div>
           </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="pill-modal" tabindex="-1" aria-labelledby="pillModalLabel" aria-hidden="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered pillmodal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pillModalLabel">Log In</h5>
            </div>
            <div class="modal-body">

                {{-- Login Form --}}
                <form action="{{ route('manual.login') }}" class="login-form auth-form" method='POST'>
                    @csrf
                    <div class='form-group'>
                        <label>Email</label>
                        <input type="email" name='email' placeholder='Email Address' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Password</label>
                        <input type="password" name='password' placeholder='******' class='w-100'>
                    </div>
                    <button class='loginbtn mt-3 w-100' type='submit'>Login</button>
                    <p class="mt-3 text-center">
                        Don't have an account? <a href="#" onclick="toggleAuthForm('register')">Create one</a>
                    </p>
                </form>

                {{-- Register Form --}}
                <form action="{{ route('manual.register') }}" class="register-form auth-form d-none" method='POST'>
                    @csrf
                    <div class='form-group'>
                        <label>Name</label>
                        <input type="text" name='name' placeholder='Full Name' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Email</label>
                        <input type="email" name='email' placeholder='Email Address' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Password</label>
                        <input type="password" name='password' placeholder='******' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Confirm Password</label>
                        <input type="password" name='password_confirmation' placeholder='******' class='w-100'>
                    </div>
                    <button class='loginbtn mt-3 w-100' type='submit'>Register</button>
                    <p class="mt-3 text-center">
                        Already have an account? <a href="#" onclick="toggleAuthForm('login')">Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Toggle Script -->
<script>
    function toggleAuthForm(type) {
        const loginForm = document.querySelector('.login-form');
        const registerForm = document.querySelector('.register-form');
        const modalTitle = document.getElementById('pillModalLabel');

        if (type === 'register') {
            loginForm.classList.add('d-none');
            registerForm.classList.remove('d-none');
            modalTitle.innerText = 'Register';
        } else {
            registerForm.classList.add('d-none');
            loginForm.classList.remove('d-none');
            modalTitle.innerText = 'Log In';
        }
    }
</script>
@endsection