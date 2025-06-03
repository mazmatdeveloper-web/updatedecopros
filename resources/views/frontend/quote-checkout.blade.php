@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class='my-3 text-center'>Confirm Service</h4>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-7">
           <div class="row py-5">
                <div class="col-md-7">
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
                            <tr>     
                                    @if($frequency === 'weekly')
                                        <th>Weekly Discount (20% off)</th>
                                        <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                    @elseif($frequency === 'biweekly')
                                        <th>Biweekly Discount (10% off)</th>
                                        <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                    @elseif($frequency === 'one_time')
                                        <th></th>
                                        <td class="text-end text-success"></td>
                                    @elseif($frequency === 'monthly')
                                    <th>Monthly Discount (10% off)</th>
                                    <td class="text-end text-success">- ${{ number_format($discountAmounts[$frequency], 2) }}</td>
                                    @endif
                            </tr>
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
                </div>
           </div>
        </div>
    </div>
</div>


@endsection