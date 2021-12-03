<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('name', 'Nama Bank') !!}
      {!! Form::text('name', null, [
      'class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Nama Bank',
      'required' => true,
      ]) !!}
      @error('name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('account_number', 'No. Rekening') !!}
      {!! Form::number('account_number', null, [
      'class' => $errors->has('account_number') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'No. Rekening',
      'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
      this.maxLength);',
      'maxlength' => '16',
      'required' => true,
      ]) !!}
      @error('account_number')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('account_name', 'Pemilik Rekening') !!}
      {!! Form::text('account_name', null, [
      'class' => $errors->has('account_name') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Pemilik Rekening',
      'required' => true,
      ]) !!}
      @error('account_name')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.banks.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>