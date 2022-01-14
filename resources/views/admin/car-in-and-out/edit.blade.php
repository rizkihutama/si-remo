@extends('layouts.app-admin')
@section('pageTitle', 'Edit Rent')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Rent</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Rent</h6>
  </div>
  <div class="card-body">
    {!! Form::model($checkout, ['route' => ['admin.car-in-and-out.update', $checkout], 'method' => 'PATCH', 'files' =>
    false]) !!}
    @include('admin.car-in-and-out._form', ['isNewRecord' => false])
    {!! Form::close() !!}
  </div>
</div>
@endsection