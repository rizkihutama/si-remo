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
  <div class="col-md-5">
    @include('checkout._detail')
  </div>
  <div class="col-md-7 choose-bank">
    {!! Form::model($checkout, ['route' => ['car-checkout.update', $checkout->checkout_id], 'method' => 'PATCH','files'
    =>
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
<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<style>
  @media only screen and (max-width: 767px) {
    .choose-bank {
      margin-top: 2em;
    }
  }

</style>
@endpush

@push('script')
<script defer src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      theme: 'bootstrap4'
    });
  });
</script>
@endpush