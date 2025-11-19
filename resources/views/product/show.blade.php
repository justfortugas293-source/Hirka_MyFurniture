@extends('layouts.app')

@section('content')
<div class="container my-4">

  <!-- Gambar produk -->
  <div class="text-center mb-3">
    {{-- Product images are stored in public/img as filenames in the seeder --}}
  <img loading="lazy" src="{{ asset('img/' . $product->image) }}" 
         alt="{{ $product->name }}" 
         class="img-fluid rounded-4 shadow-sm" 
         style="width: 100%; max-height: 280px; object-fit: cover;">
  </div>

  <!-- Nama & Harga -->
  <div class="px-3 mb-3">
    <h4 class="fw-bold">{{ $product->name }}</h4>
    <h5 class="text-danger fw-semibold">
      Rp. {{ number_format($product->price, 0, ',', '.') }}
    </h5>
  </div>

  <!-- Deskripsi -->
  <div class="bg-white rounded-4 shadow-sm p-3 mb-3">
    <p class="text-secondary mb-0" style="font-size: 0.95rem;">
      {{ $product->description }}
    </p>
  </div>

  <!-- Info tambahan -->
  <div class="bg-light rounded-4 shadow-sm p-3 mb-4">
    <p class="mb-2 fw-semibold">
      Ready stock : <span class="badge bg-primary">150</span>
    </p>
    <p class="mb-2 fw-semibold">
      Payment method : <span class="text-dark">Pay on delivery</span>
    </p>
    <p class="mb-0 fw-semibold">
      Shipping fee : <span class="text-warning fw-bold">Rp. 20.000</span>
    </p>
  </div>

  <!-- Tombol aksi -->
  <div class="d-flex gap-1 mb-4 align-items-stretch">
    <!-- Tombol Add to Cart (match Buy Now size) -->
    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex flex-fill me-1">
      @csrf
      <button type="submit" class="btn btn-warning text-white w-100 h-100 d-flex align-items-center justify-content-center py-3 fw-bold rounded-4 shadow-sm">
        <i class="bi bi-cart3 me-2"></i>
        <span>Add to Cart</span>
      </button>
    </form>

    <!-- Tombol Buy Now -->
    <a href="{{ route('buy', $product->id) }}" class="btn btn-warning text-white d-flex flex-fill h-100 align-items-center justify-content-center py-3 fw-bold rounded-4 shadow-sm ms-1">
      <div class="d-flex flex-column align-items-center">
        <div>Buy Now</div>
        <div class="small fw-normal mt-1">Rp. {{ number_format($product->price + 20000, 0, ',', '.') }}</div>
      </div>
    </a>
  </div>

<!-- Tombol Cancel -->
<a href="{{ route('home') }}" class="btn btn-primary w-100 py-3 fw-semibold rounded-4 shadow-sm">
  Cancel
</a>

</div>
@endsection
