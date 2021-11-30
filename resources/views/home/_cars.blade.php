@forelse ($cars as $car)
<div class="row">
  <div class="col-lg-12">
    <div class="card cars-card mb-3" data-cars="{{ $car->car_id }}">
      <div class="row no-gutters">
        <div class="col-lg-4 col-md-4 col-sm-4">
          <img src="{{ url(App\Models\Car::getImgUrl($car->image)) }}" class="card-img-top cars-image"
            alt="{{ $car->name }}">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="card-body">
            <h5 class="card-title text-dark">{{ $car->name }}</h5>
            <span class="d-flex flex-row">
              <p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom"
                title="Penumpang : {{ $car->seats }}">
                <i class="far fa-user-circle"></i>&nbsp;&nbsp;{{ $car->seats }}
              </p>
              <p class="card-text p-2 text-dark"> - </p>
              <p class="card-text p-2 text-dark" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom"
                title="Bagasi : {{ $car->luggage }}">
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
@empty
<div class="row">
  <div class="col-lg-12">
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title text-dark">Tidak ada mobil yang tersedia</h5>
      </div>
    </div>
  </div>
</div>
@endforelse