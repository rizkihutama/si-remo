@extends('layouts.app-user')
@section('pageTitle', 'Home')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Pilih Mobil</h1>

<div class="row">
  <div class="col-lg-4 col-md-4">

  </div>
  <div class="col-lg-8 col-md-8">
    <div class="row">
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
            <button data-price="low_price" id="low-price" class="dropdown-item">
              <i class="fas fa-check checkLp"></i>
              Harga Terendah
            </button>
            <button data-price="high_price" id="high-price" class="dropdown-item">
              <i class="fas fa-check checkHp"></i>
              Harga Tertinggi
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="cars-data">
      @foreach ($cars as $car)
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-lg-4 col-md-4 col-sm-4">
                <img src="{{ url(App\Models\Car::getImgUrl($car->image)) }}" class="card-img-top cars-image"
                  alt="{{ $car->name }}">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card-body">
                  <h5 class="card-title text-dark">{{ $car->name }}</h5>
                  <span class="d-flex flex-row">
                    <p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"
                      data-placement="bottom" title="{{ 'Penumpang : ' . $car->seats }}">
                      <i class="far fa-user-circle"></i>&nbsp;&nbsp;{{ $car->seats }}
                    </p>
                    <p class="card-text p-2 text-dark"> - </p>
                    <p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"
                      data-placement="bottom" title="{{ 'Bagasi : ' . $car->luggage }}">
                      <i class="fas fa-suitcase-rolling"></i>&nbsp;&nbsp;{{ $car->luggage }}
                    </p>
                  </span>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card-body">
                  <div class="d-flex flex-row mb-4">
                    <h5 class="card-title text-success">{{ App\Models\Car::rupiah($car->price) }}</h5>
                    <span>/hari</span>
                  </div>
                  <a href="#" class="btn btn-primary btn-lg btn-block">Pilih</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection

@push('style')
<style>
  .cars-image {
    height: 180px;
    width: 100%;
    object-fit: contain;
  }

</style>
@endpush

@push('script')
<script>
  $(document).ready(function() {
    const checkLp = $('.checkLp').css('display', 'none');
    const checkHp = $('.checkHp').css('display', 'none');
    
    $('#low-price').click(function() {
      const element = $(this);
      const data = element.data('price');

      if (data == 'low_price') checkLp.css('display', '');
      checkHp.css('display', 'none');

      $('.cars-data').html('');
      $.ajax({
        url: "{{ route('sortCarFromLowPrice') }}",
        type: 'GET',
        dataType: 'json',
        data: { price: 'low_price' },
        success: function(result) {
          result.forEach(function(car) {
            $('.cars-data').append('<div class="row"><div class="col-lg-12"><div class="card mb-3"><div class="row no-gutters"><div class="col-lg-4 col-md-4 col-sm-4"><img src="{{ url("/storage/cars/") }}' + '/' + car.image + '" class="card-img-top cars-image"alt=" ' + car.name + ' "></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><h5 class="card-title text-dark">' + car.name + '</h5><span class="d-flex flex-row"><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title=" ' + car.seats + ' "><i class="far fa-user-circle"></i>&nbsp;&nbsp;' + car.seats + '</p><p class="card-text p-2 text-dark"> - </p><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"data-placement="bottom" title=" ' + car.luggage + ' "><i class="fas fa-suitcase-rolling"></i>&nbsp;&nbsp;' + car.luggage + '</p></span></div></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><div class="d-flex flex-row mb-4"><h5 class="card-title text-success">' + formatRupiah(car.price) +'</h5><span>/hari</span></div><a href="#" class="btn btn-primary btn-lg btn-block">Pilih</a></div></div></div></div></div></div>');
          });
        }
      });

    });
    
    $('#high-price').click(function() {
      const element = $(this);
      const data = element.data('price');

      if (data == 'high_price') checkHp.css('display', '');
      checkLp.css('display', 'none');

      $('.cars-data').html('');
      $.ajax({
        url: "{{ route('sortCarFromHighPrice') }}",
        type: 'GET',
        dataType: 'json',
        data: { price: 'high_price' },
        success: function(result) {
          result.forEach(function(car) {
            $('.cars-data').append('<div class="row"><div class="col-lg-12"><div class="card mb-3"><div class="row no-gutters"><div class="col-lg-4 col-md-4 col-sm-4"><img src="{{ url("/storage/cars/") }}' + '/' + car.image + '" class="card-img-top cars-image"alt=" ' + car.name + ' "></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><h5 class="card-title text-dark">' + car.name + '</h5><span class="d-flex flex-row"><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title=" ' + car.seats + ' "><i class="far fa-user-circle"></i>&nbsp;&nbsp;' + car.seats + '</p><p class="card-text p-2 text-dark"> - </p><p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip"data-placement="bottom" title=" ' + car.luggage + ' "><i class="fas fa-suitcase-rolling"></i>&nbsp;&nbsp;' + car.luggage + '</p></span></div></div><div class="col-lg-4 col-md-4 col-sm-4"><div class="card-body"><div class="d-flex flex-row mb-4"><h5 class="card-title text-success">' + formatRupiah(car.price) +'</h5><span>/hari</span></div><a href="#" class="btn btn-primary btn-lg btn-block">Pilih</a></div></div></div></div></div></div>');
          });
        }
      });
    });

    function formatRupiah(angka, prefix){
      if (typeof angka !== 'number') var number_string = angka.replace(/[^,\d]/g, '').toString(),

			split   		= number_string.split(','),
			sisa     		= split[0].length % 2,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
  });
</script>
@endpush