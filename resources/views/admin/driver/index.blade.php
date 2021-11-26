@extends('layouts.app-admin')
@section('pageTitle', 'Drivers')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Drivers</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <ul class="nav nav-pills card-header-pills justify-content-between">
      <li class="nav-item">
        <h6 class="m-0 font-weight-bold text-primary nav-link">Drivers</h6>
      </li>
      <li class="nav-item">
        <A href="{{ route('admin.drivers.create') }}" class="btn btn-primary btn-sm nav-link">
          <i class="fas fa-plus"></i>&nbsp;&nbsp; Add Driver</a>
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
<script defer src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script defer src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script defer src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
{!! $dataTable->scripts() !!}
@endpush