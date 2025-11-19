@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:640px;">
  <h4 class="mb-3">Checkout</h4>

  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="card p-3 mb-3">
    @if(empty($cart))
      <p>Your cart is empty.</p>
    @else
      @php $total = 0; $shippingFee = (int) env('SHIPPING_FEE', 20000); @endphp
      <form method="POST" action="{{ route('checkout.process') }}" class="mt-3">
        @csrf
        <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
        @foreach($cart as $id => $item)
          @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div style="flex:1">
              <strong>{{ $item['name'] }}</strong>
              <div class="small text-muted">Price: Rp. {{ number_format($item['price'], 0, ',', '.') }}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?? 9999 }}" class="form-control form-control-sm qty-input" style="width:80px;" data-price="{{ $item['price'] }}" data-id="{{ $id }}">
              <div class="fw-semibold">Rp. <span id="subtotal-{{ $id }}">{{ number_format($subtotal, 0, ',', '.') }}</span></div>
            </div>
          </div>
        @endforeach

        <hr>
        <div class="d-flex justify-content-between">
          <div class="text-muted small">Shipping fee</div>
          <div class="text-muted">Rp. <span id="shipping-fee">{{ number_format($shippingFee,0,',','.') }}</span></div>
        </div>
        <div class="d-flex justify-content-between fw-bold mb-3 mt-2">
          <div>Total (inc. shipping)</div>
          <div>Rp. <span id="order-total">{{ number_format($total + $shippingFee, 0, ',', '.') }}</span></div>
        </div>

        <div class="mb-3">
          <label class="form-label small">Shipping address</label>
          <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
        </div>
        <button class="btn btn-warning w-100 text-white">Place Order</button>
      </form>

      <script>
        (function(){
          function toNumber(str){ return Number(String(str).replace(/[^0-9\-\.]+/g,'') || 0); }
          function formatIDR(n){ return new Intl.NumberFormat('id-ID').format(n); }

          function recalc(){
            let total = 0;
            document.querySelectorAll('.qty-input').forEach(function(inp){
              const price = Number(inp.dataset.price || 0);
              let qty = Number(inp.value || 0);
              if (qty < Number(inp.min)) qty = Number(inp.min);
              if (Number(inp.max) && qty > Number(inp.max)) qty = Number(inp.max);
              const id = inp.dataset.id;
              const subtotal = price * qty;
                const el = document.getElementById('subtotal-' + id);
                if (el) el.textContent = formatIDR(subtotal);
                total += subtotal;
            });
              // add shipping fee
              const shippingFeeEl = document.getElementById('shipping-fee');
              const shippingFee = shippingFeeEl ? Number(shippingFeeEl.textContent.replace(/[^0-9]/g, '')) : 0;
              const grand = total + (isNaN(shippingFee) ? 0 : shippingFee);
              const totalEl = document.getElementById('order-total');
              if (totalEl) totalEl.textContent = formatIDR(grand);
          }

          document.addEventListener('input', function(e){
            if (e.target && e.target.classList && e.target.classList.contains('qty-input')){
              recalc();
            }
          });

          // initial calc
          document.addEventListener('DOMContentLoaded', recalc);
        })();
      </script>
    @endif
  </div>
</div>
@endsection
