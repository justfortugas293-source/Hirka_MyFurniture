@extends('layouts.app')

@section('content')
<div class="container py-3" style="max-width:420px;">
  <div class="bg-warning text-white fw-bold d-flex align-items-center p-3 rounded-top-4 shadow-sm mb-3">
    @php
      $backUrl = auth()->check() && auth()->user()->is_admin ? route('admin.products.index') : route('home');
    @endphp
    <a href="{{ $backUrl }}" class="text-white text-decoration-none me-2">
      <i class="bi bi-arrow-left"></i>
    </a>
    <span>My Account</span>
  </div>

  <div class="bg-white rounded-4 p-4 shadow-sm text-center" style="border:3px solid #0ea5e9;">
    <div class="mx-auto mb-3" style="width:100px;height:100px;background:#F6C84A;border-radius:12px;display:flex;align-items:center;justify-content:center;">
      <i class="bi bi-person" style="font-size:2.25rem;color:white"></i>
    </div>

    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
    <p class="text-muted small mb-3">{{ $user->email }}</p>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="btn" style="background:#ef4444;color:#fff;border-radius:12px;padding:10px 28px;box-shadow:0 8px 18px rgba(239,68,68,0.25);">Logout</button>
    </form>
  </div>
</div>
@endsection
