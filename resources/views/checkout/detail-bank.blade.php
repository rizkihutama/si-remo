@extends('layouts.app-user')
@section('pageTitle', 'Checkout Detail')
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
    @include('checkout._detail')
  </div>
  <div class="col-lg-7">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <h4 class="card-header">Detil Bank</h4>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">{{ $checkout->banks->name }}</li>
            <li class="list-group-item">No. Rek : {{ $checkout->banks->account_number }}</li>
            <li class="list-group-item">a/n {{ $checkout->banks->account_name }}</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-12 mt-4">
        <div class="card">
          <h4 class="card-header">Upload Bukti</h4>
          <div class="card-body">
            {!! Form::model($checkout, ['route' => ['upload-proof', $checkout], 'method' => 'PATCH', 'files' => true])
            !!}
            <div class="form-group">
              {!! Form::label('payment_proof', 'Bukti Pembayaran') !!}
              {!! Form::file('payment_proof', ['onchange' => 'loadPreview(this);'], null, $checkout->payment_proof, [
              'class' => $errors->has('payment_proof') ? 'form-control is-invalid' : 'form-control',
              'placeholder' => 'Bukti Pembayaran',
              'accept' => 'image/*',
              'required' => 'required',
              ]) !!}
              @error('payment_proof')
              <div class="text-danger">
                <strong>{{ $message }}</strong>
              </div>
              @enderror
              @if (!empty($checkout->payment_proof))
              <img id="preview_img" src="{{ url($path) }}" class="img-fluid"
                style="border: 1px solid #ccc; border-radius: 10px; margin-top: 5px" width="200" height="150">
              @endif
            </div>
            <div class="form-group">
              {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  function loadPreview(input, id) {
    console.log(input);
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $(id)
          .attr('src', e.target.result)
          .width(200)
          .height(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush