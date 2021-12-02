@extends('layouts.app-user')
@section('pageTitle', 'Booking')
@section('content')
{!! Form::open(['route' => 'car-checkout', 'method' => 'POST', 'files' => false]) !!}
<div class="card">
  <h5 class="card-header">Detil Pemesanan</h5>
  <div class="card-body">
    <input type="hidden" name="car_id" value="{{ $car->car_id }}">
    @include('booking._form-order-detail', ['isNewRecord' => true])
  </div>
</div>
<div class="card mt-4">
  <h5 class="card-header">Detil Sewa</h5>
  <div class="card-body">
    @include('booking._form-rent-detail', ['isNewRecord' => true])
  </div>
</div>
<button type="submit" class="btn btn-primary mt-4">Checkout</button>
{!! Form::close() !!}
@endsection