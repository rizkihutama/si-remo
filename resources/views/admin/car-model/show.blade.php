@extends('layouts.app-admin')
@section('pageTitle', 'Detail Model')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail Model</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Detail Model</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Brand Name</th>
          <td>{{ $carModel->carBrand->brand_name }}</td>
        </tr>
        <tr>
          <th>Model Name</th>
          <td>{{ $carModel->model_name }}</td>
        </tr>
        <tr>
          <th>Tgl Dibuat</th>
          <td>{{ with(new Carbon\Carbon($carModel->created_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Tgl Diedit</th>
          <td>{{ with(new Carbon\Carbon($carModel->updated_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $carModel->createdBy->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diedit Oleh</th>
          <td>{{ $carModel->udatedBy->name ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <a href="{{ route('admin.car-models.index') }}" class="btn btn-secondary mr-3">Back</a>
    <a href="{{ route('admin.car-models.edit', $carModel) }}" class="btn btn-primary">Edit</a>
  </div>
</div>
@endsection