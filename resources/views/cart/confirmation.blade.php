@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center vh-100 bg-white">
  <div class="text-center px-4">
    <div class="d-flex align-items-center justify-content-center bg-warning rounded-circle mx-auto mb-4" style="width:120px;height:120px;">
      <i class="bi bi-check-lg text-white" style="font-size:2.5rem;"></i>
    </div>

    <h2 class="fw-bold mb-2">Checkout Successfully</h2>
    <p class="text-muted small mb-4">Thankyou very much!!!</p>

    <div class="d-flex justify-content-center gap-2">
      <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">View Invoice</a>
      <a href="{{ route('home') }}" class="btn rounded-pill px-4 py-2 shadow" style="background:#2563EB;color:#fff;border:none;box-shadow:0 8px 18px rgba(37,99,235,0.35);">&lt; Back</a>
    </div>
  </div>
</div>

@endsection
