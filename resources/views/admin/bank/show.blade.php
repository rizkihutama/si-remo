@extends('layouts.app-admin')
@section('pageTitle', 'Driver Detail')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Bank Detail</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Bank Detail</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Bank Name</th>
          <td>{{ $bank->name }}</td>
        </tr>
        <tr>
          <th>No. Rekening</th>
          <td>{{ $bank->account_number }}</td>
        </tr>
        <tr>
          <th>Pemilik Rekening</th>
          <td>{{ $bank->account_name }}</td>
        </tr>
        <tr>
          <th>Tgl Dibuat</th>
          <td>{{ with(new Carbon\Carbon($bank->created_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Tgl Diedit</th>
          <td>{{ with(new Carbon\Carbon($bank->updated_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $bank->createdBy->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diedit Oleh</th>
          <td>{{ $bank->udatedBy->name ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary mr-3">Back</a>
    <a href="{{ route('admin.banks.edit', $bank) }}" class="btn btn-primary">Edit</a>
  </div>
</div>
@endsection