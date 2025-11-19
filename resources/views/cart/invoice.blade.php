@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:900px;">
  @if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
  @endif
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0">Invoice</h4>
      <div class="text-muted small">Order #{{ $order->id }} • {{ $order->created_at->format('d M Y H:i') }}</div>
    </div>
    <div class="text-end">
      <h5 class="fw-bold">MyFurniture</h5>
      <div class="small text-muted">Jl. Merdeka, Semarang </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-12 col-md-6">
      <div class="card p-3">
        <div class="small text-muted">Billed to</div>
        <div class="fw-semibold">{{ $order->user?->name ?? 'Customer' }}</div>
        <div class="small text-muted">{{ $order->user?->email ?? '' }}</div>
      </div>
    </div>
    <div class="col-12 col-md-6 mt-2 mt-md-0">
      <div class="card p-3">
        <div class="small text-muted">Shipping address</div>
        <div class="fw-semibold">{{ $order->shipping_address ?? '-' }}</div>
        <div class="small text-muted mt-2">Order time: {{ $order->created_at->format('d M Y H:i') }}</div>
      </div>
    </div>
    <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
      <a href="#" onclick="window.print();return false;" class="btn btn-outline-secondary btn-sm me-2">Print</a>
      <a href="{{ route('home') }}" class="btn btn-warning btn-sm text-white">Back to shop</a>
    </div>
  </div>

  <div class="card p-3 mb-3">
    <div class="table-responsive">
      <table class="table table-borderless">
        <thead>
          <tr class="small text-muted">
            <th>Product</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Price</th>
            <th class="text-end">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->items as $it)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  @if($it->product && $it->product->image)
                    <img src="{{ asset('img/'.$it->product->image) }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                  @endif
                  <div>
                    <div class="fw-semibold">{{ $it->product?->name ?? 'Product #' . $it->product_id }}</div>
                    <div class="small text-muted">{{ $it->product?->name ? '' : '' }}</div>
                  </div>
                </div>
              </td>
              <td class="text-center">{{ $it->quantity }}</td>
              <td class="text-end">Rp. {{ number_format($it->price,0,',','.') }}</td>
              <td class="text-end">Rp. {{ number_format($it->price * $it->quantity,0,',','.') }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td class="text-end small text-muted">Shipping</td>
            <td class="text-end">Rp. {{ number_format($order->shipping_fee ?? 0,0,',','.') }}</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td class="text-end small text-muted">Total</td>
            <td class="text-end fw-bold">Rp. {{ number_format($order->total,0,',','.') }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="text-muted small">Thank you for your purchase!</div>
</div>

@endsection
