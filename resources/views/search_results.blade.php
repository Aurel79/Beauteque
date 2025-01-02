@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="container">
        <h1 class="text-center">Search Results for "{{ $query }}"</h1>

        @if ($products->isEmpty())
            <p>No products found.</p>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <a href="/products/{{ $product->id }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
