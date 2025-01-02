@extends('layouts.dashboard')

@section('title', 'Admin - Manage Products')

@section('content')
    <div class="container mt-4">
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h4 class="mb-3">{{ $pageTitle }}</h4>
            </div>
        </div>
        <hr>
        
        <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                        id="name" value="{{ $errors->any() ? old('name') : $product->name }}"
                        placeholder="Enter Product Name">
                    @error('name')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input class="form-control @error('brand') is-invalid @enderror" type="text" name="brand"
                        id="brand" value="{{ $errors->any() ? old('brand') : $product->brand }}"
                        placeholder="Enter Last Name">
                    @error('brand')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" type="text" name="description"
                        id="description" value="" placeholder="Enter Description" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input class="form-control @error('price') is-invalid @enderror" type="number" name="price"
                        id="price" value="{{ old('price', $product->price) }}" placeholder="Enter Price" required>
                    @error('price')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="image" class="form-label">Image</label>
                    @if ($product->image)
                        <div class="mb-2">
                            <img src="/storage/products/{{ $product->image }}" class="img-fluid img-thumbnail" style="height:200px!important;"></img>
                        </div>
                    @else
                        <p class="text-muted">No CV uploaded</p>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                        accept=".jpg,.jpeg,.png">
                    @error('image')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
            </div>

            <hr>
            <div class="row">
                <!-- Cancel Button -->
                <div class="col-md-6 d-grid">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger btn-lg mt-3">
                        <i class="bi-arrow-left-circle me-2"></i> Cancel
                    </a>
                </div>

                <!-- Update Button -->
                <div class="col-md-6 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg mt-3 btn-pink">
                        <i class="bi-check-circle me-2"></i> Edit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
