@extends('layouts.app')

@section('content')

<div class="container-fluid px-0 bg-white">
  <div class="position-relative" style="overflow: hidden; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    <img src="{{ asset('img/banner.jpeg') }}" alt="Banner" class="w-100" style="height: 160px; object-fit: cover;">
    <h3 class="position-absolute top-0 start-0 text-white fw-bold m-3">MyFurniture — Admin</h3>
  </div>
</div>

<div class="container px-3 mt-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
        <h4 class="fw-bold">Dashboard</h4>
        <div class="d-flex gap-2 align-items-start align-items-sm-center w-100 w-sm-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Products</a>
            <a href="/" class="btn btn-warning text-white btn-sm">View Shop</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-md-4 mb-3">
            <div class="card shadow-sm p-3 text-center text-md-start">
                <div class="text-muted small">Total Revenue</div>
                <div class="h5 h-md4 fw-bold">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <div class="card shadow-sm p-3 text-center text-md-start">
                <div class="text-muted small">Orders</div>
                <div class="h5 h-md4 fw-bold">{{ $ordersCount }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 mb-3">
            <div class="card shadow-sm p-3 text-center text-md-start">
                <div class="text-muted small">Products Sold</div>
                <div class="h5 h-md4 fw-bold">{{ $productsSold }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 mb-3">
            <div class="card shadow-sm p-3">
                <h6>Top Products</h6>
                <ul class="list-group list-group-flush">
                    @forelse($topProducts as $tp)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $tp['product'] }}
                            <span class="badge bg-warning text-dark">{{ $tp['qty'] }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No sales yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- No additional scripts - sales chart and export removed --}}
