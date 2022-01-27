<div class="row">
  <div class="col-lg-4">
    <div class="form-group">
      {!! Form::label('start_date', 'Start Date') !!}
      {!! Form::text('start_date', $start_date, [
      'class' => $errors->has('start_date') ? 'form-control-plaintext is-invalid start_date' : 'form-control-plaintext
      start_date',
      'readonly' => true,
      ]) !!}
      @error('start_date')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>

    <div class="form-group">
      {!! Form::label('car_out', 'Car Out') !!}
      {!! Form::text('car_out', $car_out, [
      'class' => $errors->has('car_out') ? 'form-control is-invalid datepicker car_out' : 'form-control datepicker
      car_out',
      'placeholder' => 'Car Out',
      'required' => true,
      ]) !!}
      @error('car_out')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>

    <div class="form-group">
      {!! Form::label('rent_status', 'Rent Status') !!}
      {!! Form::select('rent_status', $rent_status, null, [
      'class' => $errors->has('rent_status') ? 'form-control is-invalid select2' : 'form-control select2',
      'required' => 'required',
      ]) !!}
      @error('rent_status')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      {!! Form::label('end_date', 'End Date') !!}
      {!! Form::text('end_date', $end_date, [
      'class' => $errors->has('end_date') ? 'form-control-plaintext is-invalid end_date' : 'form-control-plaintext
      end_date',
      'readonly' => true,
      ]) !!}
      @error('end_date')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>

    <div class="form-group">
      {!! Form::label('car_in', 'Car In') !!}
      {!! Form::text('car_in', $car_in, [
      'class' => $errors->has('car_in') ? 'form-control is-invalid datepicker car_in' : 'form-control datepicker
      car_in',
      'placeholder' => 'Car In',
      ]) !!}
      @error('car_in')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>

    <div class="form-group">
      {!! Form::label('fine_text', 'Fine') !!}
      {!! Form::text('fine_text', $fine, [
      'class' => 'form-control-plaintext fine_text',
      'readonly' => true,
      ]) !!}
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      {!! Form::label('days', 'Days') !!}
      {!! Form::text('days', "{$days} Hari", [
      'class' => $errors->has('days') ? 'form-control-plaintext is-invalid days' : 'form-control-plaintext days',
      'readonly' => true,
      ]) !!}
      @error('days')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>

    <div class="form-group">
      {!! Form::label('days_rent', 'Rent Days') !!}
      {!! Form::text('days_rent', "{$days_rent} Hari", [
      'class' => 'form-control-plaintext days_rent',
      'readonly' => true,
      ]) !!}
    </div>

    <div class="form-group">
      {!! Form::label('fine_status', 'Fine Status') !!}
      {!! Form::select('fine_status', $fine_status, null, [
      'class' => $errors->has('fine_status') ? 'form-control is-invalid fine_status select2' : 'form-control
      fine_status select2',
      'placeholder' => '- Choose Fine Status -',
      'required' => true,
      ]) !!}
      @error('fine_status')
      <div class="text-danger">
        <strong>{{ $message }}</strong>
      </div>
      @enderror
    </div>
    <input type="hidden" value="{{ $sub_total }}" class="sub_total">
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
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"
  integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script defer src="{{ asset('vendor/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      theme: 'bootstrap4',
    });

    const startDate = $('.start_date');
    const endDate = $('.end_date');
    const carOut = $('.car_out');
    const carIn = $('.car_in');

    carIn.change(function() {
      const startDateVal = startDate.val();
      const endDateVal = endDate.val();
      const carOutVal = carOut.val();
      const carInVal = $(this).val();

      if (carOutVal && carInVal) {
        const daysOrder = $('.days').val().split('')[0];
        const daysRent = moment(carInVal, 'DD/MM/YYYY').diff(moment(startDateVal, 'DD/MM/YYYY'), 'days') + 1;
        const daysRentVal = $('.days_rent').val(daysRent + ' Hari');
        
        if(daysRent > daysOrder) {
          const subTotal = $('.sub_total').val();
          const countFine = subTotal * (daysRent - daysOrder) + 50000;
          const fineText = $('.fine_text').val(formatRupiah(countFine));
        } else {
          const fineText = $('.fine_text').val(formatRupiah(0));
        }
      }
    });

    $('.car_out').datepicker({
      format: 'dd/mm/yyyy',
      language: 'id',
      startDate: startDate.val(),
    });

    $('.car_in').datepicker({
      format: 'dd/mm/yyyy',
      language: 'id',
      startDate: endDate.val(),
    });

    function formatRupiah(angka, prefix) {
      //   var number_string = angka.replace(/[^,\d]/g, '').toString();

      var number_string = angka.toString(),
      split = number_string.split(','),
      sisa = split[0].length % 2,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? (rupiah ? 'Rp.' + rupiah : '') : rupiah;
    }

  });
</script>
@endpush