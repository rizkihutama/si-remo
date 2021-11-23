@extends('layouts.app-admin')
@section('pageTitle', 'Edit Car')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Car</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Car</h6>
  </div>
  <div class="card-body">
    {!! Form::model($car, ['route' => ['admin.cars.update', $car], 'method' => 'PATCH', 'files' =>
    true]) !!}
    @include('admin.car._form', ['isNewRecord' => false])
    {!! Form::close() !!}
  </div>
</div>
@endsection