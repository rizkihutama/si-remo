@extends('layouts.app-admin')
@section('pageTitle', 'Detail Rent')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail Rent</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Detail Rent</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <tr>
          <th>Kode Booking</th>
          <td>{{ $carInAndOut->code }}</td>
        </tr>
        <tr>
          <th>Mobil</th>
          <td>{{ $carInAndOut->cars->name }}</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <img src="{{ url(App\Models\Car::getImgUrl($carInAndOut->cars->image)) }}" class="img-fluid"
              style="border: 1px solid #ccc; padding: 5px; border-radius: 10px;" width="250" height="250">
          </td>
        </tr>
        <tr>
          <th>Bank Transfer</th>
          <td>{!! $carInAndOut->checkouts->banks->name !!}</td>
        </tr>
        <tr>
          <th>Dengan Pengemudi</th>
          <td>{!! $carInAndOut->checkouts->getWithDriverStatusBadgeLabelAttribute() !!}</td>
        </tr>
        <tr>
          <th>Bukti Transfer</th>
          <td>
            @if ($carInAndOut->checkouts->payment_proof)
            <img src="{{ url(App\Models\Checkout::getImgProofUrl($carInAndOut->checkouts->payment_proof)) }}"
              class="img-fluid" style="border: 1px solid #ccc; padding: 5px; border-radius: 10px;" width="250"
              height="250">
            @else
            <h5><span class="badge badge-danger">Belum ada bukti transfer</span></h5>
            @endif
          </td>
        </tr>
        <tr>
          <th>Tgl Mulai</th>
          <td>{{ App\Models\CarInAndOut::formatDateFE($carInAndOut->car_in) ?? '-' }}</td>
        </tr>
        <tr>
          <th>Tgl Selesai</th>
          <td>{{ App\Models\CarInAndOut::formatDateFE($carInAndOut->car_out) ?? '-' }}</td>
        </tr>
        <tr>
          <th>Lama Sewa</th>
          <td>{{ $carInAndOut->bookings->days }} Hari</td>
        </tr>
        <tr>
          <th>Lokasi Jemput</th>
          <td>{{ $carInAndOut->bookings->pickup_location }}</td>
        </tr>
        <tr>
          <th>Lokasi Antar</th>
          <td>{{ $carInAndOut->bookings->dropoff_location }}</td>
        </tr>
        <tr>
          <th>Waktu Jemput</th>
          <td>{{ $carInAndOut->bookings->pickup_time }}</td>
        </tr>
        <tr>
          <th>Waktu Antar</th>
          <td>{{ $carInAndOut->bookings->dropoff_time }}</td>
        </tr>
        <tr>
          <th>Subtotal</th>
          <td>{{ App\Models\Checkout::rupiah($carInAndOut->checkouts->sub_total) }}</td>
        </tr>
        <tr>
          <th>Total</th>
          <td>{{ App\Models\Checkout::rupiah($carInAndOut->checkouts->total) }}</td>
        </tr>
        <tr>
          <th>Status Pembayaran Denda</th>
          <td>{!! $carInAndOut->getFineStatusBadgeLabelAttribute() !!}</td>
        </tr>
        <tr>
          <th>Status Sewa</th>
          <td>{!! $carInAndOut->getRentStatusBadgeLabelAttribute() !!}</td>
        </tr>
        <tr>
          <th>Denda</th>
          <td>{!! $carInAndOut->getFine() ?? '-' !!}</td>
        </tr>
        <tr>
          <th>Tgl Dibuat</th>
          <td>{{ with(new Carbon\Carbon($carInAndOut->created_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Tgl Diedit</th>
          <td>{{ with(new Carbon\Carbon($carInAndOut->updated_at))->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $carInAndOut->createdBy->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Diedit Oleh</th>
          <td>{{ $carInAndOut->udatedBy->name ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <a href="{{ route('admin.car-in-and-out.index') }}" class="btn btn-secondary mr-3">Back</a>
    <a href="{{ route('admin.car-in-and-out.edit', $carInAndOut) }}" class="btn btn-primary">Edit</a>
  </div>
</div>
@endsection