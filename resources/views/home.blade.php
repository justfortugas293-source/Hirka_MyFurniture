@extends('layouts.app')
@section('content')

<div class="container-fluid px-0 bg-white">
  <!-- Banner -->
  <div class="position-relative" style="overflow: hidden; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    <img src="{{ asset('img/banner.jpeg') }}" 
         alt="Banner"
         class="w-100"
         style="height: 260px; object-fit: cover;">
    <h3 class="position-absolute top-0 start-0 text-white fw-bold m-3" 
        style="font-size: 1.25rem;">
      MyFurniture
    </h3>
    <!-- Search bar overlay (transparent + blur) placed below the MyFurniture heading -->
    <form method="GET" action="{{ route('home') }}" class="position-absolute start-50 translate-middle-x" style="top:70px; left:50%; width:92%; max-width:760px;">
      <div class="input-group shadow-sm" style="background: rgba(255,255,255,0.28); backdrop-filter: blur(6px); border-radius: 999px;">
        <input type="search" name="q" value="{{ request('q') }}" class="form-control border-0 px-3" placeholder="Cari produk..." aria-label="Search products">
        <button class="btn btn-warning text-white rounded-pill ms-1 me-1" type="submit" style="border-radius:999px;"><i class="bi bi-search"></i></button>
      </div>
    </form>
  </div>
</div>

<!-- Ikon Keranjang & Akun -->
<div class="d-flex justify-content-center align-items-center gap-5 mt-4 mb-5">
  <a href="/cart" class="text-decoration-none text-dark text-center">
    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center shadow" 
         style="width:65px; height:65px;">
      <i class="bi bi-cart3 fs-3 text-white"></i>
    </div>
  </a>

  <a href="/account" class="text-decoration-none text-dark text-center">
    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center shadow" 
         style="width:65px; height:65px;">
      <i class="bi bi-person fs-3 text-white"></i>
    </div>
  </a>
</div>

<!-- Produk -->
<div class="px-3">
  <h5 class="fw-bold mb-3">Produk</h5>
  <div class="row">
    @foreach ($products as $product)
    <div class="col-6 col-sm-4 col-md-3 mb-3">
      <div class="card border-0 shadow-sm rounded-3 text-center p-2" style="min-height:170px;">
        @if($product->image)
          <div style="width:100%;height:100px;overflow:hidden;border-radius:8px;margin-bottom:8px;">
            <img loading="lazy" src="{{ asset('img/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;display:block;">
          </div>
        @endif
        <div>
          <div class="fw-semibold small mb-1 text-truncate">{{ $product->name }}</div>
          <div class="text-muted xsmall mb-2">Rp. {{ number_format($product->price, 0, ',', '.') }}</div>
          <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-warning text-white rounded-pill">More</a>
            <a href="{{ route('buy', $product->id) }}" class="btn btn-sm btn-outline-warning">Buy</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
  </div>
</div>

@endsection
