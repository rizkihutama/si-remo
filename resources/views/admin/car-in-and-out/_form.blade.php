<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('rent_status', 'Rent Status') !!}
      {!! Form::select('rent_status', $rent_status, null, [
      'class' => $errors->has('rent_status') ? 'form-control is-invalid select2' : 'form-control select2',
      'required' => 'required',
      ]) !!}
    </div>

    <div class="form-group">
      {!! Form::label('fine', 'Denda') !!}
      {!! Form::number('fine', null, [
      'class' => $errors->has('fine') ? 'form-control is-invalid' : 'form-control',
      ]) !!}
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <div class="form-group">
        {!! Form::label('start_date', 'Start Date') !!}
        {!! Form::text('start_date', $start_date, [
        'class' => $errors->has('start_date') ? 'form-control is-invalid start_date' : 'form-control start_date',
        'required' => 'required',
        ]) !!}
      </div>

      <div class="form-group">
        {!! Form::label('end_date', 'End Date') !!}
        {!! Form::text('end_date', $end_date, [
        'class' => $errors->has('end_date') ? 'form-control is-invalid end_date' : 'form-control end_date',
        'required' => 'required',
        ]) !!}
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.car-in-and-out.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>

@push('style')
<link rel="stylesheet" href="{{ asset('vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endpush

@push('script')
<script defer src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script defer src="{{ asset('vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      theme: 'bootstrap4',
    });
  
    $('.start_date').datepicker({
      format: 'dd/mm/yyyy',
      language: 'id',
      startDate: new Date(),
    });

    $('.end_date').datepicker({
      format: 'dd/mm/yyyy',
      language: 'id',
      startDate: new Date(),
    });
  });
</script>
@endpush