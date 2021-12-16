<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('brand_id', 'Brand') !!}
      {!! Form::select('brand_id', $brands, null, [
      'class' => $errors->has('brand_id') ? 'form-control is-invalid select2 dropdown_brand' : 'form-control select2
      dropdown_brand',
      'placeholder' => '- Choose Brand -',
      'required' => true,
      ]) !!}
      @error('brand_id')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('model_id', 'Model') !!}
      {!! Form::select('model_id', $models, null, [
      'class' => $errors->has('model_id') ? 'form-control is-invalid select2 dropdown_model' : 'form-control select2
      dropdown_model',
      'placeholder' => '- Choose Model -',
      'required' => true,
      ]) !!}
      @error('model_id')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('year', 'Year') !!}
      {!! Form::number('year', null, [
      'class' => $errors->has('year') ? 'form-control is-invalid' : 'form-control',
      'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,
      this.maxLength);",
      'maxlength' => '4',
      'placeholder' => 'Car Year',
      'required' => true,
      ]) !!}
      @error('year')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('status', 'Status') !!}
      {!! Form::select('status', $status, null, [
      'class' => $errors->has('status') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => '- Choose Status -',
      'required' => true,
      ]) !!}
      @error('status')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('seats', 'Seats') !!}
      {!! Form::number('seats', null, [
      'class' => $errors->has('seats') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Car Seats',
      'required' => true,
      ]) !!}
      @error('seats')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>
  <div class="col-lg-6 col-md-6">
    <div class="form-group">
      {!! Form::label('luggage', 'Luggage') !!}
      {!! Form::number('luggage', null, [
      'class' => $errors->has('luggage') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Car Luggage',
      'required' => true,
      ]) !!}
      @error('luggage')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('cc', 'CC') !!}
      {!! Form::number('cc', null, [
      'class' => $errors->has('cc') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Car cc',
      'required' => true,
      ]) !!}
      @error('cc')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('number_plates', 'Number Plates') !!}
      {!! Form::text('number_plates', null, [
      'class' => $errors->has('number_plates') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Car Number Plates',
      'required' => true,
      ]) !!}
      @error('number_plates')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('price', 'Price') !!}
      {!! Form::number('price', null, [
      'class' => $errors->has('price') ? 'form-control is-invalid' : 'form-control',
      'placeholder' => 'Car Price',
      'required' => true,
      ]) !!}
      @error('price')
      <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <div class="form-group">
      {!! Form::label('image', 'Image') !!}
      <div class="input-group mb-4">
        {!! Form::file('image', ['onchange' => 'loadPreview(this);'], null,[
        'class' => $errors->has('image') ? 'custom-file-input is-invalid' : 'custom-file-input',
        'placeholder' => 'Car Image',
        'accept' => 'image/*',
        ]) !!}
        {!! Form::label('image', 'Upload Car Image', ['class' => 'custom-file-label']) !!}
      </div>
      @error('image')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
      @if (!$isNewRecord)
      <img id="preview_img" src="{{ url($path) }}" class="img-fluid"
        style="border: 1px solid #ccc; border-radius: 10px; margin-top: 5px">
      @else
      <img id="preview_img" class="img-fluid" style="border: 1px solid #ccc; margin-top: 5px;border-radius: 10px;">
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.cars.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
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
<script defer src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  // $('.datepicker').datepicker({
  //   format: 'dd/mm/yyyy',
  //   language: 'id',
  //   endDate: new Date(),
  // });

  $(document).ready(function() {
    bsCustomFileInput.init();
  });
  
  $('.select2').select2({
    width: '100%'
  });

  function loadPreview(input, id) {
    // console.log(input);
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

  $('.dropdown_brand').change(function () {
    var brandId = $(this).val();
    getBrand(brandId);
  });

  function getBrand(brandId) {
    $('.dropdown_model').html('');
    $.ajax({
      url: "{{ route('model.dropdown') }}",
      type: 'GET',
      data: { brand_id: brandId },
      success: function(result){
        result.forEach(function (data) {
          $('.dropdown_model').append('<option value="'+ data.model_id +'">'+ data.model_name +'</option>');
        })
      },
    });
  }
</script>
@endpush