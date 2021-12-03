<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('pickup_location', 'Lokasi Jemput') !!}
      {!! Form::textarea('pickup_location', null, [
      'class' => $errors->has('pickup_location') ? 'form-control is-invalid datepicker' : 'form-control',
      'placeholder' => 'Lokasi Jemput',
      'rows' => 3,
      'required' => true,
      ]) !!}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('pickup_time', 'Waktu Jemput') !!}
      {!! Form::text('pickup_time', null, [
      'class' => $errors->has('pickup_time') ? 'form-control is-invalid datepicker bs-timepicker' : 'form-control
      bs-timepicker',
      'placeholder' => 'Waktu Jemput',
      'required' => true,
      ]) !!}
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('dropoff_location', 'Lokasi Antar') !!}
      {!! Form::textarea('dropoff_location', null, [
      'class' => $errors->has('dropoff_location') ? 'form-control is-invalid datepicker' : 'form-control',
      'placeholder' => 'Lokasi Antar',
      'rows' => 3,
      'required' => true,
      ]) !!}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('dropoff_time', 'Waktu Antar') !!}
      {!! Form::text('dropoff_time', null, [
      'class' => $errors->has('dropoff_time') ? 'form-control is-invalid datepicker bs-timepicker' : 'form-control
      bs-timepicker',
      'placeholder' => 'Waktu Antar',
      'required' => true,
      ]) !!}
    </div>
  </div>
</div>

@push('style')
<link rel="stylesheet" href="{{ asset('vendor/timepicker/css/timepicker.css') }}">
@endpush

@push('script')
<script src="{{ asset('vendor/timepicker/js/timepicker.min.js') }}"></script>
<script>
  $('.bs-timepicker').timepicker();
</script>
@endpush