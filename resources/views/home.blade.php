@extends('layouts.app')

@section('content')

<section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-4">Professional Home Cleaning Services</h1>
                    <p class="leads ">We bring sparkle to your home with our trusted cleaning professionals
                        <i class="fas fa-leaf leaf-icon"></i>
                        eco-friendly products
                        <i class="fas fa-leaf leaf-icon"></i>
                        and satisfaction guarantee
                    </p>
                    <a href="/quote" class="instant-btn">INSTANTLY BOOK A HOME CLEANER</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2 class="text-center section-title">Our Cleaning Services</h2>

            <div class="row g-4">
                <!-- Standard Cleaning -->
                <div class="col-md-4">
                    <div class="card service-card h-100 p-3">
                        <img src="{{asset('service-img-1-1.jpg')}}" class="card-img-top" alt="Standard Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">Standard Cleaning</h5>
                            <ul class="list-unstyled">
                                <li><span class="leaf-icon">🍃</span> Dusting & Vacuuming</li>
                                <li><span class="leaf-icon">🍃</span> Mopping</li>
                                <li><span class="leaf-icon">🍃</span> Trash Removal</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Deep Cleaning -->
                <div class="col-md-4">
                    <div class="card service-card h-100 p-3 shadow">
                        <img src="{{ asset('/service-img-1-2.jpg') }}" class="card-img-top" alt="Deep Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">Deep Cleaning</h5>
                            <ul class="list-unstyled">
                                <li><span class="leaf-icon">🍃</span> All Standard Services</li>
                                <li><span class="leaf-icon">🍃</span> Appliance Detailing</li>
                                <li><span class="leaf-icon">🍃</span> Tile Scrubbing</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Move-in/out Cleaning -->
                <div class="col-md-4">
                    <div class="card service-card h-100 p-3">
                        <img src="{{asset('/service-img-1-5.jpg')}}" class="card-img-top" alt="Move-in/out Cleaning">
                        <div class="card-body">
                            <h5 class="card-title">Move-in/out Cleaning</h5>
                            <ul class="list-unstyled">
                                <li><span class="leaf-icon">🍃</span> Cabinets & Appliances</li>
                                <li><span class="leaf-icon">🍃</span> Wall Cleaning</li>
                                <li><span class="leaf-icon">🍃</span> Full Property Deep Clean</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-light-green py-5 position-relative">
        <i class="fas fa-leaf leaf-decoration" style="top: 20px; left: 10%;"></i>
        <i class="fas fa-leaf leaf-decoration" style="bottom: 20px; right: 10%; transform: rotate(45deg);"></i>
        <div class="container text-center py-5">
            <h2 class="mb-4">Ready for a Spotless Home?</h2>
            <p class="lead mb-5">Our professional cleaners are just a click away</p>
            <a href="#" class="btn btn-primary btn-lg">INSTANTLY BOOK A HOME CLEANER</a>
        </div>
    </section>

@endsection
