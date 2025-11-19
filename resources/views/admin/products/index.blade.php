@extends('layouts.app')

@section('content')

<div class="container-fluid px-0 bg-white">
  <!-- Banner (same style as user home) -->
  <div class="position-relative" style="overflow: hidden; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    <img src="{{ asset('img/banner.jpeg') }}" 
         alt="Banner"
         class="w-100"
         style="height: 180px; object-fit: cover;">
    <h3 class="position-absolute top-0 start-0 text-white fw-bold m-3" 
        style="font-size: 1.25rem;">
      MyFurniture — Admin
    </h3>
  </div>
</div>

<div class="d-flex justify-content-center align-items-center gap-4 mt-4 mb-4">
  <a href="/" class="text-decoration-none text-dark text-center">
    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center shadow" 
         style="width:55px; height:55px;">
      <i class="bi bi-arrow-left fs-4 text-white"></i>
    </div>
    <div class="small text-muted mt-1">Back</div>
  </a>

  <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark text-center">
    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center shadow" 
         style="width:65px; height:65px;">
      <i class="bi bi-bar-chart fs-4 text-white"></i>
    </div>
    <div class="small text-muted mt-1">Stats</div>
  </a>

  <a href="/account" class="text-decoration-none text-dark text-center">
    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center shadow" 
         style="width:55px; height:55px;">
      <i class="bi bi-person fs-4 text-white"></i>
    </div>
    <div class="small text-muted mt-1">Account</div>
  </a>
</div>

<div class="container px-3">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
    <h4 class="fw-bold">Products</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-warning text-white rounded-pill">Add Product</a>
  </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="row mt-3">
        @foreach($products as $p)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                @if($p->image)
                <img loading="lazy" src="{{ asset('img/' . $p->image) }}" class="card-img-top rounded-top-4" alt="{{ $p->name }}">
                @endif
                <div class="card-body text-center">
                    <h6 class="card-title mb-1">{{ $p->name }}</h6>
                    <p class="text-muted small mb-2">Rp. {{ number_format($p->price, 0, ',', '.') }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
