@extends('layouts.app-admin')
@section('pageTitle', 'Car Models')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Car Models</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <ul class="nav nav-pills card-header-pills justify-content-between">
      <li class="nav-item">
        <h6 class="m-0 font-weight-bold text-primary nav-link">Car Models</h6>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.car-models.create') }}" class="btn btn-primary btn-sm nav-link">
          <i class="fas fa-plus"></i>&nbsp;&nbsp; Add Models</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      {!! $dataTable->table([
      'class'=>'table table-bordered dt-responsive',
      'id' => 'dataTable',
      'width' => '100%',
      'cellspacing' => '0'], false) !!}
    </div>
  </div>
</div>
@endsection

@push('style')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@push('script')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
{!! $dataTable->scripts() !!}
@endpush