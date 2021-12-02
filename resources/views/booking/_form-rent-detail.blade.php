<div class="row">
  <div class="col-lg-6">
    {!! Form::label('pick_up_location', 'Lokasi Jemput') !!}
    {!! Form::textarea('pick_up_location', null, [
    'class' => $errors->has('pick_up_location') ? 'form-control is-invalid datepicker' : 'form-control',
    'placeholder' => 'Lokasi Jemput',
    'rows' => 3,
    'required' => true,
    ]) !!}
  </div>
  <div class="col-lg-6">
    {!! Form::label('pick_up_time', 'Waktu Jemput') !!}
    {!! Form::text('pick_up_time', null, [
    'class' => $errors->has('pick_up_time') ? 'form-control is-invalid datepicker bs-timepicker' : 'form-control
    bs-timepicker',
    'placeholder' => 'Waktu Jemput',
    'required' => true,
    ]) !!}
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