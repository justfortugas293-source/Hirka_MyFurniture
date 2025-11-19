@extends('layouts.app')

@section('content')
<div class="container px-3">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h4 class="fw-bold">Edit Product</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    @if($product->image)
                        <div class="mb-2"><img src="{{ asset('img/' . $product->image) }}" alt="" width="120" loading="lazy"></div>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <button class="btn btn-warning text-white rounded-pill">Save</button>
            </form>
        </div>
    </div>
</div>

@endsection
