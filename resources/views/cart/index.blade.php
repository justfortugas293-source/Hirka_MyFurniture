@extends('layouts.app')

@section('content')
<div class="container py-3" style="max-width: 480px; background-color: #f2f2f2;">
  
  <!-- Header -->
  <div class="bg-warning text-white fw-bold d-flex align-items-center p-3 rounded-top-4 shadow-sm">
    <a href="{{ route('home') }}" class="text-white text-decoration-none me-2">
      <i class="bi bi-arrow-left"></i>
    </a>
    <span>My Cart</span>
  </div>

  <!-- Cart items -->
  <div class="mt-3">
    @if(session('cart') && count(session('cart')) > 0)
      @foreach(session('cart') as $id => $item)
        <div class="bg-white d-flex align-items-center justify-content-between p-3 mb-3 rounded-4 shadow-sm">
          <div class="d-flex align-items-center">
      <img loading="lazy" src="{{ asset('img/' . $item['image']) }}" 
        alt="{{ $item['name'] }}" 
        class="rounded-3 me-3" 
        style="width: 70px; height: 70px; object-fit: cover;">
            
            <div>
              <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
              <p class="text-danger mb-1">Rp. {{ number_format($item['price'], 0, ',', '.') }}</p>
              <p class="text-secondary mb-1">Qty: {{ $item['quantity'] ?? 1 }}</p>
              <p class="text-secondary small mb-0">Stock available: {{ $item['stock'] ?? 'N/A' }}</p>
            </div>
          </div>
          <div class="d-flex flex-column align-items-end gap-2">
            <a href="{{ route('product.show', $id) }}" 
               class="btn btn-warning btn-sm text-white px-3 py-1">
              More..
            </a>

            <!-- Tombol Hapus -->
            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item from cart?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-1">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </div>
        </div>
      @endforeach

      <!-- Tombol Proceed -->
      <div class="text-center mt-4 mb-3">
        <a href="{{ route('checkout') }}" class="btn btn-warning text-white fw-bold px-5 py-2 rounded-pill shadow">
          Proceed to Checkout
        </a>
      </div>
    @else
      <div class="text-center text-secondary mt-5">
        <p>Your cart is empty.</p>
      </div>
    @endif
  </div>

</div>
@endsection
