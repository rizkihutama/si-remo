@extends('layouts.app-user')
@section('pageTitle', 'Invoice')
@section('content')
<div class="row justify-content-center" style="margin-bottom: 3rem;">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        Invoice
      </div>
      <div class="card-body">
        <h5 class="card-title">{{ $booking_code }}</h5>
        <hr>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Mulai :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $start_date }}</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Selesai :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $end_date }}</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Lama Sewa :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $days }} Hari</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Pajak :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $tax }}%</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Subtotal :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $sub_total }}</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Total :
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $total }}</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection