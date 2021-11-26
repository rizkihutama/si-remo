@extends('layouts.app-admin')
@section('pageTitle', 'Driver Detail')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Driver Detail</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Driver Detail</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Driver Name</th>
          <td>{{ $driver->name }}</td>
        </tr>
        <tr>
          <th>Tgl Dibuat</th>
          <td>{{ with(new Carbon\Carbon($driver->created_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Tgl Diedit</th>
          <td>{{ with(new Carbon\Carbon($driver->updated_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $driver->createdBy->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diedit Oleh</th>
          <td>{{ $driver->udatedBy->name ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary mr-3">Back</a>
    <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-primary">Edit</a>
  </div>
</div>
@endsection