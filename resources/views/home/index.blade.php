@extends('layouts.app-user')
@section('pageTitle', 'Home')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Pilih Mobil</h1>

<div class="row">
  <div class="col-lg-4 col-md-4">
    <div class="card">
      <div class="card-header">
        Filter
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h5>Kapasitas Penumpang</h5>
          <div class="row no-gutters">
            <div class="col">
              <button class="btn btn-outline-primary less-then-five-seats btn-sm" data-seats="less_then_five_seats"
                id="less-then-five-seats">
                &lt; 5 Penumpang
              </button>
            </div>
            <div class="col">
              <button class="btn btn-outline-primary five-to-six-seats btn-sm" data-seats="five_to_six_seats"
                id="five-to-six-seats">
                5-6 Penumpang
              </button>
            </div>
            <div class="col">
              <button class="btn btn-outline-primary more-than-six-seats btn-sm" data-seats="more_then_six_seats"
                id="more-then-six-seats">
                &gt; 6 Penumpang
              </button>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <h5>Merek Mobil</h5>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Default checkbox
            </label>
          </div>
        </li>
        <li class="list-group-item">A third item</li>
      </ul>
    </div>
  </div>
  <div class="col-lg-8 col-md-8">
    <div class="row header-mobil">
      <div class="col-auto mr-auto">
        <p>{{ $totalCars }} Mobil</p>
      </div>
      <div class="col-auto">
        <div class="dropdown mb-4">
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fas fa-sort"></i>
            Urutkan
          </button>
          <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
            <button data-price="low_price" id="low-price" class="dropdown-item price">
              <i class="fas fa-check checkLp"></i>
              Harga Terendah
            </button>
            <button data-price="high_price" id="high-price" class="dropdown-item price">
              <i class="fas fa-check checkHp"></i>
              Harga Tertinggi
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="cars-data">
      @include('home._cars')
    </div>
  </div>
</div>
@endsection

@push('style')
<style>
  .cars-image {
    height: 100%;
    width: 100%;
    object-fit: contain;
  }

  @media screen and (max-width: 768px) {
    .header-mobil {
      margin-top: 30px;
    }
  }

</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    const checkLp = $('.checkLp').css('display', 'none');
    const checkHp = $('.checkHp').css('display', 'none');

    const lt = $('#less-then-five-seats');
    const fs = $('#five-to-six-seats');
    const mt = $('#more-then-six-seats');

    var data = {};

    $('#low-price').click(function () {
      price = $(this).data('price');

      if (price == 'low_price') checkLp.css('display', '');
      checkHp.css('display', 'none');

      data['price'] = price;

      ajaxCall(data);
    });

    $('#high-price').click(function () {
      price = $(this).data('price');

      if (price == 'high_price') checkHp.css('display', '');
      checkLp.css('display', 'none');
      data['price'] = price;

      ajaxCall(data);
    });

    $('#less-then-five-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;

      if (seats == 'less_then_five_seats') {
        lt.css({
          'color': '#fff',
          'background-color': '#4e73df',
          'border-color': '#4e73df',
        });
      }

      fs.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      mt.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      ajaxCall(data);
    });

    $('#five-to-six-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;
      
      if (seats == 'five_to_six_seats') {
        fs.css({
          'color': '#fff',
          'background-color': '#4e73df',
          'border-color': '#4e73df',
        });
      }

      lt.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      mt.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      ajaxCall(data);
    });

    $('#more-then-six-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;
      
      if (seats == 'more_then_six_seats') {
        mt.css({
          'color': '#fff',
          'background-color': '#4e73df',
          'border-color': '#4e73df',
        });
      }

      lt.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      fs.css({
        'color': '#4e73df',
        'background-color': '#fff',
      });

      ajaxCall(data);
    });

  });

  function ajaxCall(data) {
    $('.cars-data').html('');
    $.ajax({
      url: "{{ route('carsFilter') }}",
      type: 'GET',
      dataType: 'json',
      data: { 
        'price': data.price,
        'seats': data.seats,
      },
      success: function (result) {
        result.forEach(function (car) {
          $('.cars-data').append('<div class="row"><div class="col-lg-12"><div class="card mb-3"><div class="row no-gutters"><div class="col-lg-4 col-md-4 col-sm-4"><img src="{{ url("/storage/cars/") }}' + '/' + car.image + '" class="card-img-top cars-image"alt=" ' + car.name + ' "></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><h5 class="card-title text-dark">' + car.name + '</h5><span class="d-flex flex-row"><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title=" ' + car.seats + ' "><i class="far fa-user-circle"></i>&nbsp;&nbsp;' + car.seats + '</p><p class="card-text p-2 text-dark"> - </p><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"data-placement="bottom" title=" ' + car.luggage + ' "><i class="fas fa-suitcase-rolling"></i class=>&nbsp;&nbsp;' + car.luggage + '</p></span></div></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><div class="d-flex flex-row mb-4"><h5 class="card-title text-success">' + formatRupiah(car.price) + '</h5><span>/hari</span></div><a href="#" class="btn btn-primary btn-lg btn-block">Pilih</a></div></div></div></div></div></div>');
        });
      }, error: function (error) {
        console.log(error);
      }
    });
  }


  function formatRupiah(angka, prefix) {
    if (typeof angka !== 'number') var number_string = angka.replace(/[^,\d]/g, '').toString(),

      split = number_string.split(','),
      sisa = split[0].length % 2,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
</script>
@endpush