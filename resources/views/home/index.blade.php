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
          <div class="row row-cols-3 my-3">
            <div class="col-lg-3 col-md-4 col">
              <button class="btn btn-seats btn-outline-primary all-seats btn-sm" data-seats="all-seats" id="all-seats">
                Semua
              </button>
            </div>
            <div class="col">
              <button class="btn btn-seats btn-outline-primary less-then-five-seats btn-sm ls"
                data-seats="less_then_five_seats" id="less-then-five-seats">
                &lt; 5 Penumpang
              </button>
            </div>
            <div class="col">
              <button class="btn btn-seats btn-outline-primary five-to-six-seats btn-sm ft"
                data-seats="five_to_six_seats" id="five-to-six-seats">
                5-6 Penumpang
              </button>
            </div>
            <div class="col">
              <button class="btn btn-seats btn-outline-primary more-than-six-seats btn-sm mt"
                data-seats="more_then_six_seats" id="more-then-six-seats">
                &gt; 6 Penumpang
              </button>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <h5>Merek</h5>
          @foreach ($brands as $brand)
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input brands" value="{{ $brand->brand_id }}"
              id="{{ $brand->brand_name }}">
            <label class="custom-control-label" for="{{ $brand->brand_name }}">{{ $brand->brand_name }}</label>
          </div>
          @endforeach
        </li>
        <li class="list-group-item">
          <h5>Model</h5>
          @foreach ($models as $model)
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input models" value="{{ $model->model_id }}"
              id="{{ $model->model_name }}">
            <label class="custom-control-label" for="{{ $model->model_name }}">{{ $model->model_name }}</label>
          </div>
          @endforeach
        </li>
      </ul>
    </div>
  </div>
  <div class="col-lg-8 col-md-8">
    <div class="row header-mobil">
      <div class="col-auto mr-auto">
        <p id="totalCars">{{ $totalCars }} Mobil</p>
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
  /* .cars-card {
    cursor: pointer;
  } */

  .cars-image {
    height: 100%;
    width: 100%;
    object-fit: contain;
  }

  .btn-outline-primary:focus {
    box-shadow: none !important;
  }

  .custom-control-input:focus~.custom-control-label::before {
    box-shadow: none !important;
  }

  .btn-seats:hover {
    color: #fff !important;
    background-color: #4e73df !important;
    border-color: #4e73df !important;
  }

  @media screen and (max-width: 768px) {
    .header-mobil {
      margin-top: 30px;
    }
  }

  @media screen and (max-width: 268px) {
    .ls {
      margin-top: 20px;
    }
  }

  @media screen and (max-width: 1090px) and (min-width: 767px) {
    .ft {
      margin-top: 20px
    }
  }

  @media screen and (max-width: 386px) {
    .ft {
      margin-top: 20px
    }
  }

  @media screen and (min-width: 768px) {
    .mt {
      margin-top: 20px;
    }
  }

  @media screen and (max-width: 503px) {
    .mt {
      margin-top: 20px;
    }
  }

</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    const checkLp = $('.checkLp').css('display', 'none');
    const checkHp = $('.checkHp').css('display', 'none');

    // keep data all filters and pass it to backend : obj
    var data = {};

    // keep data from brands checkbox filter and merge it to var data : array
    var brandsData = [];

    // keep data from models checkbox filter and merge it to var data : array
    var modelsData = [];

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

    $('#all-seats').click(function() {
      seats = $(this).data('seats');
      data['seats'] = seats;

      $(this).parent().parent().find('.btn-seats').css({
        'color': '#4e73df',
        'background-color': '#fff',
        'border-color': '#4e73df',
      });

      $(this).css({
        'color': '#fff',
        'background-color': '#6c757d',
        'border-color': '#6c757d',
      });

      ajaxCall(data);
    });

    $('#less-then-five-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;

      $(this).parent().parent().find('.btn-seats').css({
        'color': '#4e73df',
        'background-color': '#fff',
        'border-color': '#4e73df',
      });

      $(this).css({
        'color': '#fff',
        'background-color': '#6c757d',
        'border-color': '#6c757d',
      });

      ajaxCall(data);
    });

    $('#five-to-six-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;
      
      $(this).parent().parent().find('.btn-seats').css({
        'color': '#4e73df',
        'background-color': '#fff',
        'border-color': '#007bff',
      });

      $(this).css({
        'color': '#fff',
        'background-color': '#6c757d',
        'border-color': '#6c757d',
      });

      ajaxCall(data);
    });

    $('#more-then-six-seats').click(function () {
      seats = $(this).data('seats');
      data['seats'] = seats;

      $(this).parent().parent().find('.btn-seats').css({
        'color': '#4e73df',
        'background-color': '#fff',
        'border-color': '#007bff',
      });

      $(this).css({
        'color': '#fff',
        'background-color': '#6c757d',
        'border-color': '#6c757d',
      });

      ajaxCall(data);

    });

    $('.brands').click(function () {
      if ($(this).is(':checked')) {
        brandsData.push($(this).val());
        data['brands'] = brandsData;
      } else {
        brandsData.splice(brandsData.indexOf($(this).val()), 1);
        data['brands'] = brandsData;
      }

      ajaxCall(data);
    });

    $('.models').click(function () {
      if ($(this).is(':checked')) {
        modelsData.push($(this).val());
        data['models'] = modelsData;
      } else {
        modelsData.splice(modelsData.indexOf($(this).val()), 1);
        data['models'] = modelsData;
      }

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
        'brands': data.brands,
        'models': data.models,
      },
      success: function (result) {
        $('#totalCars').html(`${result.totalCars} Mobil`);
        if (result['cars'].length < 1) {
          $('.cars-data').append(
            `<div class="col-12">
              <div class="alert alert-danger text-center" role="alert">
                <h4 class="alert-heading">Maaf</h4>
                <p>Tidak ada mobil yang sesuai dengan kriteria anda.</p>
              </div>
            </div>`
          );
        }

        result['cars'].forEach(function (car) {
          $('.cars-data').append('<div class="row"><div class="col-lg-12"><div class="card mb-3"><div class="row no-gutters"><div class="col-lg-4 col-md-4 col-sm-4"><img src="{{ url("/storage/cars/") }}' + '/' + car.image + '" class="card-img-top cars-image"alt=" ' + car.name + ' "></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><h5 class="card-title text-dark">' + car.name + '</h5><span class="d-flex flex-row"><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Penumpang : ' + car.seats + ' "><i class="far fa-user-circle"></i>&nbsp;&nbsp;' + car.seats + '</p><p class="card-text p-2 text-dark"> - </p><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"data-placement="bottom" title="Bagasi : ' + car.luggage + ' "><i class="fas fa-suitcase-rolling"></i class=>&nbsp;&nbsp;' + car.luggage + '</p></span></div></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><div class="d-flex flex-row mb-4"><h5 class="card-title text-success">' + formatRupiah(car.price) + '</h5><span>/hari</span></div><a href="{{ url("/car-detail/") }}' + '/' + car.car_id + '" class="btn btn-primary btn-lg btn-block">Pilih</a></div></div></div></div></div></div>');
        });
      }, 
      error: function (textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
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