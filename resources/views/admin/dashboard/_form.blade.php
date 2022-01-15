<div class="row">
  <div class="col-lg-6">
    <div class="form-group">
      {!! Form::label('status', 'Status') !!}
      {!! Form::select('status', $status, null, [
      'class' => $errors->has('status') ? 'form-control is-invalid select2' : 'form-control select2',
      'required' => 'required',
      ]) !!}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <a href="{{ route('admin.dashboard.index') }}" class="btn btn-submit btn btn-secondary mr-3">Back</a>
    <button type="submit" class="submit btn btn-primary">Save</button>
  </div>
</div>

@push('style')
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('script')
<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script>
  $('.select2').select2({
    width: '100%',
    theme: 'bootstrap4',
  });
</script>
@endpush