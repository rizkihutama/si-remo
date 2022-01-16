@extends('layouts.app-user')
@section('pageTitle', 'Booking')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active text-primary" aria-current="page">Booking</li>
    <li class="breadcrumb-item">Bayar</li>
    <li class="breadcrumb-item">Selesai</li>
  </ol>
</nav>

<div class="row">
  <div class="col-lg-4">
    <div class="card card-detail">
      <h5 class="card-header">{{ $car->name }}</h5>
      <div class="card-body">
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Mulai
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link start_date"></p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Selesai
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link end_date"></p>
          </li>
        </ul>
        <hr />
        <h5 class="card-title">Subtotal</h5>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Lama Sewa
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link days_rent"></p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Harga<small>/hari</small>
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link car_price" data-car-price="{{ $car->price }}">{{ $price }}</p>
          </li>
        </ul>
        <hr />
        <h5 class="card-title">Total</h5>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Pajak
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">2%</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Total keseluruhan
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link total"></p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    {!! Form::open(['route' => 'car-booking.create', 'method' => 'POST', 'files' => false, 'id' => 'checkout-form']) !!}
    <div class="card">
      <h5 class="card-header">Detil Pemesanan</h5>
      <div class="card-body">
        <input type="hidden" name="car_id" value="{{ $car->car_id }}">
        @include('booking._form-order-detail', ['isNewRecord' => true])
      </div>
    </div>
    <div class="card mt-4">
      <h5 class="card-header">Detil Sewa</h5>
      <div class="card-body">
        @include('booking._form-rent-detail', ['isNewRecord' => true])
      </div>
    </div>
    <button type="submit" onclick="return confirmCheckout(event)" class="btn btn-primary mt-4">Checkout</button>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@push('style')
<style>
  .card-detail-style {
    position: fixed;
    top: 0;
    width: 24rem;
  }

</style>
@endpush

@push('script')
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"
  integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  const $sticky = $('.card-detail');
  const generalSideBarHeight = $sticky.innerHeight();
  const stickyTop = $sticky.offset().top;
  const stickOffset = 0;

  $(window).scroll(function() {
    const windowTop = $(window).scrollTop();
    if (stickyTop < windowTop + stickOffset) {
      $sticky.addClass('card-detail-style');
    } else {
      $sticky.removeClass('card-detail-style');
    }
  });

  // get from input
  const startDateInput = $('#start_date');
  const endDateInput = $('#end_date');

  var startDate, endDate, days;

  startDateInput.on('change', function() {
    const startDateVal = $(this).val();
    const StartDateValFormat = moment(startDateVal, ['DD/MM/YYYY'], 'id').format('ddd, DD MMM yyyy');
    startDate = startDateVal;
    $('.start_date').text(StartDateValFormat);
  });

  endDateInput.on('change', function() {
    const endDateVal = $(this).val();
    const endDateValFormat = moment(endDateVal, ['DD/MM/YYYY'], 'id').format('ddd, DD MMM yyyy');
    endDate = endDateVal;
    days = moment(endDate, 'DD/MM/YYYY').diff(moment(startDate, 'DD/MM/YYYY'), 'days') + 1;
    if (days < 1 || !days) days = 1;
    $('.end_date').text(endDateValFormat);
    $('.days_rent').text(days + ' hari');

    let carPrice = parseInt($('.car_price').data('car-price'));
    const taxRate = 2;
    let tax = carPrice * taxRate / 100;
    let total = (carPrice + tax) * days;
    $('.total').text(formatRupiah(total));
  });

  function formatRupiah(angka, prefix) {
    //   var number_string = angka.replace(/[^,\d]/g, '').toString();

    var number_string = angka.toString(),
    split = number_string.split(','),
    sisa = split[0].length % 2,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? (rupiah ? 'Rp.' + rupiah : '') : rupiah;
  }

  function confirmCheckout(e) {
    e.preventDefault();

    swalWithBootstrapButtons.fire({
      title: 'Lanjutkan Pesanan?',
      text: "Harap periksa lagi data anda!",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Tidak, batalkan!',
      confirmButtonText: 'Ya, checkout!',
    }).then((result) => {
      if (result.isConfirmed) $('#checkout-form').submit();
    });
  }
</script>
@endpush