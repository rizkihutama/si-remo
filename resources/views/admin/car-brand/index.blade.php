@extends('layouts.app-admin')
@section('pageTitle', 'Car Brands')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Car Brands</h1>
  <a href="{{ route('admin.car-brands.create') }}"
    class="tambah d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus"></i> Add Brands</a>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Car Brands</h6>
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