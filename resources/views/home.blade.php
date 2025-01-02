@extends('layouts.app')

@section('title', 'Welcome to Beauteque')

@section('content')
<div class="container text-center">
    <h1>Welcome to Beauteque</h1>
    <p class="lead">Your go-to platform for discovering and reviewing the best beauty products!</p>

    <!-- Form Pencarian -->
    <form action="{{ route('search') }}" method="GET" class="mb-4">
        <input type="text" name="query" class="form-control d-inline-block w-50" placeholder="Search for products..." required>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<!-- Carousel for Advertisements -->
<div id="adCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ Vite::asset('resources/images/ad1.jpg') }}" class="d-block w-100 ad-image" alt="Ad 1">
        </div>
        <div class="carousel-item">
            <img src="{{ Vite::asset('resources/images/ad2.jpg') }}" class="d-block w-100 ad-image" alt="Ad 2">
        </div>
        <div class="carousel-item">
            <img src="{{ Vite::asset('resources/images/ad3.jpg') }}" class="d-block w-100 ad-image" alt="Ad 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#adCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#adCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="mt-5">
    <h2 class="text-center">Why Choose Beauteque?</h2>
    <div class="row mt-4">
        <div class="col-md-4 text-center">
            <img class="img-thumbnail" src="{{ Vite::asset('resources/images/quality-products.jpg') }}" alt="Quality Products" class="img-fluid rounded-circle mb-3">
            <br>
            <h5>Quality Products</h5>
            <p>We feature only the best-reviewed and high-quality skincare products.</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-thumbnail" src="{{ Vite::asset('resources/images/trusted-reviews.jpg') }}" alt="Trusted Reviews" class="img-fluid rounded-circle mb-3">
            <br>
            <h5>Trusted Reviews</h5>
            <p>Read honest and verified reviews from real customers.</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-thumbnail" src="{{ Vite::asset('resources/images/trend-ready.jpg') }}" alt="Trend Ready!" class="img-fluid rounded-circle mb-3">
            <br>
            <h5>Trend Ready!</h5>
            <p>Stay updated and make confident choices with the latest product trends.</p>
        </div>
    </div>
</div>
@endsection
