@extends('layouts.app-admin')
@section('pageTitle', 'Add Driver')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Add Driver</h1>
</div>

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add Driver</h6>
  </div>
  <div class="card-body">
    {!! Form::open(['route' => 'admin.drivers.store', 'method' => 'POST', 'files' => false]) !!}
    @include('admin.driver._form', ['isNewRecord' => true])
    {!! Form::close() !!}
  </div>
</div>
@endsection