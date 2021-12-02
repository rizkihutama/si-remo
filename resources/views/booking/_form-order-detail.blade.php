<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('name', 'Nama') !!}
      {!! Form::text('name', $user->name, [
      'class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Nama',
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
      {!! Form::email('email', $user->email, [
      'class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control',
      'disabled' => true,
      'required' => true,
      ]) !!}
      @error('email')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('phone', 'No. Hp') !!}
      {!! Form::number('phone', $user->phone, [
      'class' => $errors->has('phone') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'No. Hp',
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
    <div class="form-group expired_at">
      {!! Form::label('start_date', 'Tanggal Mulai dan Tanggal Selesai') !!}
      <div class="input-daterange input-group" id="datepicker">
        {!! Form::text('start_date', null, [
        'class' => $errors->has('start_date') ? 'form-control is-invalid datepicker' : 'form-control',
        'placeholder' => 'Tanggal Mulai',
        'required' => true,
        ]) !!}
        {!! Form::text('expired_at', null, [
        'class' => $errors->has('expired_at') ? 'form-control is-invalid datepicker' : 'form-control',
        'placeholder' => 'Tanggal Selesai',
        'required' => true,
        ]) !!}
      </div>
    </div>
  </div>
</div>

@push('style')
<link rel="stylesheet" href="{{ asset('vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('script')
<script defer src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script defer src="{{ asset('vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
<script>
  $(document).ready(function() {
    const today = new Date()
    const tomorrow = new Date(today)
    tomorrow.setDate(tomorrow.getDate() + 1)

    $('.input-daterange').datepicker({
      format: 'dd/mm/yyyy',
      language: 'id',
      startDate: tomorrow,
    });
  });
</script>
@endpush