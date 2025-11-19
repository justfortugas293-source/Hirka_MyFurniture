@extends('layouts.app')
@section('title', 'Katalog Produk')
@section('content')
<div class="container py-4">
  <h4 class="text-center fw-bold text-warning mb-4">Katalog Produk</h4>
  <div class="row justify-content-center">
    @for ($i = 0; $i < 6; $i++)
    <div class="col-6 mb-4">
      <div class="card border-0 shadow-sm rounded-4">
        <img src="{{ asset('img/produk'.($i+1).'.png') }}" class="card-img-top rounded-top-4" alt="Produk {{$i+1}}">
        <div class="card-body text-center">
          <h6 class="card-title mb-1">Produk {{$i+1}}</h6>
          <p class="text-muted small mb-2">Rp{{rand(50,200)}}.000</p>
          <button class="btn btn-warning text-white w-100 rounded-pill">Beli Sekarang</button>
        </div>
      </div>
    </div>
    @endfor
  </div>
</div>
@endsection
