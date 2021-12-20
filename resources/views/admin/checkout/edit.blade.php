@extends('layouts.app-admin')
@section('pageTitle', 'Edit Checkout')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Checkout</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Checkout</h6>
  </div>
  <div class="card-body">
    {!! Form::model($checkout, ['route' => ['admin.checkouts.update', $checkout], 'method' => 'PATCH', 'files' =>
    false]) !!}
    @include('admin.checkout._form', ['isNewRecord' => false])
    {!! Form::close() !!}
  </div>
</div>
@endsection