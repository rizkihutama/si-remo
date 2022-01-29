<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('model_name', 'Model Name') !!}
      {!! Form::text('model_name', null, [
      'class' => $errors->has('model_name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Model Name',
      'required' => true,
      ]) !!}
      @error('model_name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('brand_id', 'Brand') !!}
      {!! Form::select('brand_id', App\Models\CarBrand::pluck('brand_name', 'brand_id'), null, [
      'class' => $errors->has('brand_id') ? 'form-control is-invalid select2' : 'form-control select2',
      'placeholder' => '- Choose Brand -',
      'required' => true,
      ]) !!}
      @error('brand_id')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.car-models.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>

@push('style')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}"> --}}
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endpush

@push('script')
{{-- <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script> --}}
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  // $('.datepicker').datepicker({
  //   format: 'dd/mm/yyyy',
  //   language: 'id',
  //   endDate: new Date(),
  // });
  
  $('.select2').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
</script>
@endpush