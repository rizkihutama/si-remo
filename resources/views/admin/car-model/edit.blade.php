@extends('layouts.app-admin')
@section('pageTitle', 'Edit Model')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Model</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Model</h6>
  </div>
  <div class="card-body">
    {!! Form::model($carModel, ['route' => ['admin.car-models.update', $carModel], 'method' => 'PATCH', 'files' =>
    false]) !!}
    @include('admin.car-model._form', ['isNewRecord' => false])
    {!! Form::close() !!}
  </div>
</div>
@endsection