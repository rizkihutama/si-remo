@extends('layouts.app-user')
@section('pageTitle', 'Checkout')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Booking</li>
    <li class="breadcrumb-item active text-primary" aria-current="page">Bayar</li>
    <li class="breadcrumb-item">Selesai</li>
  </ol>
</nav>

<div class="row">
  <div class="col-lg-5">
    <div class="card">
      <h4 class="card-header">{{ $checkout->cars->name }}</h4>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <img src="{{ $image }}" alt="{{ $checkout->cars->name }}" class="img-fluid"
              style="border: 1px solid #ccc; padding: 5px; border-radius: 10px;">
            <hr />
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Kode Booking
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $booking_code }}</p>
              </li>
            </ul>
            <hr />
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Tanggal Mulai
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $start_date }}</p>
              </li>
            </ul>
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Tanggal Selesai
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $end_date }}</p>
              </li>
            </ul>
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Durasi
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $days }} Hari</p>
              </li>
            </ul>
            <hr />
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Pajak
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $tax }}%</p>
              </li>
            </ul>
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Subtotal
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $sub_total }}/hari</p>
              </li>
            </ul>
            <ul class="nav nav-pills card-header-pills justify-content-between">
              <li class="nav-item">
                <p class="card-text text-dark nav-link">
                  Total
                </p>
              </li>
              <li class="nav-item">
                <p class="card-text text-dark nav-link">{{ $total }}</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    {!! Form::model($checkout, ['route' => ['car-checkout.update', $checkout], 'method' => 'PATCH','files' =>
    false]) !!}
    <div class="card">
      <h4 class="card-header">Checkout</h4>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              {!! Form::label('bank_id', 'Metode Pembayaran - Transfer Bank') !!}
              {!! Form::select('bank_id', $banks, null, [
              'class' => $errors->has('bank_id') ? 'form-control is-invalid select2' : 'form-control select2',
              'placeholder' => '- Pilih Bank -'
              ]) !!}
            </div>
            @error('bank_id')
            <div class="text-danger">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Pilih</button>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" />
@endpush

@push('script')
<script defer src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      widht: '100%'
    });
  });
</script>
@endpush