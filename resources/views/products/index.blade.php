@extends('layouts.app')

@section('title', 'Product List')

@section('content')
    <div class="container">
        <h1>Reviews~</h1>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid"
                            alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->brand }}</p>
                            <p>Rating:
                                @if ($product->reviews_count > 0)
                                    @php
                                        $rating = $product->reviews_avg_rating;
                                        $fullStars = floor($rating);
                                        $halfStars = $rating - $fullStars >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStars;
                                    @endphp
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                    @if ($halfStars)
                                        <i class="bi bi-star-half"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor

                                    <span>({{ number_format($rating, 1) }})</span>
                                    ({{ $product->reviews_count }} rating)
                                @else
                                    <span class="text-muted">no rating yet</span>
                                @endif
                            </p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
