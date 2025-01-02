@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    <div class="container">
        <h2 class="text-center">{{ $product->name }}</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h4>Brand: {{ $product->brand }}</h4>
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
                <p>Price : {{ $product->price }}</p>
                <p>{{ $product->description }}</p>
                <a href="{{ url('/products') }}" class="btn btn-secondary mt-3">Back to Products</a>
            </div>
        </div>
        <!-- Formulir untuk menambahkan review -->
        @auth
            @if (auth()->user()->role === 'user')
                <h4 class="mt-4">Add a Review</h4>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" id="rating" class="form-control" required>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label">
                            Image (optional)
                        </label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Submit Review</button>
                </form>
            @endif
        @endauth
        <h4 class="mt-4">Reviews ({{ $product->reviews_count }})</h4>
        @if (count($reviews) == 0)
            <p>No review yet</p>
        @else
            @foreach ($reviews as $review)
                @if ($review->status == 'valid' || $review->user_id == auth()->id())
                    <div class="review card my-2 p-3">
                        <p>
                            @if ($review->status == 'on review')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    has not been validated yet <span class="text-muted fst-italic">(only you can see this
                                        comment)</span>
                                </span>
                            @endif
                            @if ($review->status == 'invalid')
                                <span class="badge bg-danger text-light">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    your review is rejected by admin
                                    <span class="text-muted fst-italic"></span>
                                </span>
                            @endif
                        </p>
                        <p>
                            <strong>{{ $review->user->name }}</strong>
                            <span class="ms-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                            <span class="float-end text-muted">
                                {{ $review->created_at->format('d M Y - H:m:s') }}
                            </span>
                        </p>
                        @if ($review->image)
                            <div class="mb-2">
                                <img src="/storage/reviews/{{ $review->image }}" class="img-thumbnail img-comment">
                            </div>
                        @endif
                        <p>{{ $review->comment }}</p>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
