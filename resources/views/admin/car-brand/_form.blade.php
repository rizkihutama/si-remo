<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('brand_name', 'Brand Name') !!}
      {!! Form::text('brand_name', null, [
      'class' => $errors->has('brand_name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Brand Name',
      'required' => true,
      ]) !!}
      @error('brand_name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.car-brands.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>

{{-- @push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
<link href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('script')
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'id',
    endDate: new Date(),
  });
  
  $('.select2').select2({
    width: '100%'
  });
</script>
@endpush --}}