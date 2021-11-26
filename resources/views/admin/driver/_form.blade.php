<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, [
      'class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver Name',
      'required' => true,
      ]) !!}
      @error('name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('email', 'Email') !!}
      {!! Form::email('email', null, [
      'class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver Email',
      'required' => true,
      ]) !!}
      @error('email')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('phone', 'Phone') !!}
      {!! Form::number('phone', null, [
      'class' => $errors->has('phone') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver Phone',
      'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
      this.maxLength);',
      'maxlength' => '13',
      'required' => true,
      ]) !!}
      @error('phone')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('nik', 'Nik') !!}
      {!! Form::number('nik', null, [
      'class' => $errors->has('nik') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver Nik',
      'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
      this.maxLength);',
      'maxlength' => '16',
      'required' => true,
      ]) !!}
      @error('nik')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('license', 'SIM') !!}
      {!! Form::number('license', null, [
      'class' => $errors->has('license') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver SIM',
      'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
      this.maxLength);',
      'maxlength' => '15',
      'required' => true,
      ]) !!}
      @error('license')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('status', 'Status') !!}
      {!! Form::select('status', $statusLabels, null, [
      'class' => $errors->has('status') ? 'form-control is-invalid select2' : 'form-control select2',
      'placeholder' => '- Driver Status -',
      'required' => true,
      ]) !!}
      @error('status')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('address', 'Address') !!}
      {!! Form::textarea('address', null, [
      'class' => $errors->has('address') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Driver Address',
      'rows' => '5',
      'required' => true,
      ]) !!}
      @error('address')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.drivers.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>

@push('style')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}"> --}}
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('script')
{{-- <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script> --}}
<script defer src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: '- Driver Status -',
      allowClear: true,
    });
  });
  // $('.datepicker').datepicker({
  //   format: 'dd/mm/yyyy',
  //   language: 'id',
  //   endDate: new Date(),
  // });
</script>
@endpush