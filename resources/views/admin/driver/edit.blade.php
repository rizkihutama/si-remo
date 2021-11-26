@extends('layouts.app-admin')
@section('pageTitle', 'Edit Driver')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Driver</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Driver</h6>
  </div>
  <div class="card-body">
    {!! Form::model($driver, ['route' => ['admin.drivers.update', $driver], 'method' => 'PATCH', 'files' =>
    false]) !!}
    @include('admin.driver._form', ['isNewRecord' => false])
    {!! Form::close() !!}
  </div>
</div>
@endsection