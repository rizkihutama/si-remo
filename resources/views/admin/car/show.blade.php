@extends('layouts.app-admin')
@section('pageTitle', 'Detail Car')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail Car</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Detail Car</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Image</th>
          <td>
            <img src="{{ url($path) }}" class="img-fluid"
              style="border: 1px solid #ccc; padding: 5px; border-radius: 10px;">
          </td>
        </tr>
        <tr>
          <th>Car Name</th>
          <td>{{ $car->name }}</td>
        </tr>
        <tr>
          <th>Brand</th>
          <td>{{ $car->carBrand->brand_name }}</td>
        </tr>
        <tr>
          <th>Model</th>
          <td>{{ $car->carModel->model_name }}</td>
        </tr>
        <tr>
          <th>Year</th>
          <td>{{ $car->year }}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>{!! $car->getStatusBadgeLabelAttribute() !!}</td>
        </tr>
        <tr>
          <th>Seats</th>
          <td>{{ $car->seats }}</td>
        </tr>
        <tr>
          <th>Luggage</th>
          <td>{{ $car->luggage }}</td>
        </tr>
        <tr>
          <th>CC</th>
          <td>{{ $car->cc }}</td>
        </tr>
        <tr>
          <th>Number Plates</th>
          <td>{{ $car->number_plates }}</td>
        </tr>
        <tr>
          <th>Price</th>
          <td>{{ $price }}</td>
        </tr>
        <tr>
          <th>Tgl Dibuat</th>
          <td>{{ with(new Carbon\Carbon($car->created_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Tgl Diedit</th>
          <td>{{ with(new Carbon\Carbon($car->updated_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $car->createdBy->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diedit Oleh</th>
          <td>{{ $car->udatedBy->name ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary mr-3">Back</a>
    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary">Edit</a>
  </div>
</div>
@endsection