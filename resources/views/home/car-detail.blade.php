@extends('layouts.app-user')
@section('pageTitle', 'Detil Mobil')
@section('content')
<div class="row">
  <div class="col-lg-4 col-md-4">
    <div class="card">
      <img src="{{ $image }}" class="card-img-top" alt="{{ $car->name }}">
      <div class="card-body mt-3">
        <h3 class="card-title text-dark">{{ $car->name }}</h3>
        <ul class="nav nav-pills card-header-pills justify-content-between mt-3">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              <i class="far fa-user-circle"></i>&nbsp;&nbsp;{{ $car->seats }} Penumpang
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              <i class="fas fa-suitcase-rolling"></i>&nbsp;&nbsp;{{ $car->luggage }} Bagasi
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-8 col-md-8">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row mb-4">
          <h2 class="card-title text-success">{{ $price }}</h2>
          <span class="mt-2">/hari</span>
        </div>

        @auth
        <a href="{{ route('car-booking', $car) }}" class="btn btn-primary btn-lg btn-block">Pesan Sekarang</a>
        @endauth

        @guest
        <a href="{{ route('login') }}" onclick="confirmLogin(event);" class="btn btn-primary btn-lg btn-block">
          Pesan Sekarang
        </a>
        @endguest

        <h4 class="text-dark mt-5">Ketentuan</h4>
        <div class="row mt-4">
          <div class="col">
            <h5 class="text-dark">Termasuk</h5>
            <ul>
              <li>
                <p>Mobil</p>
              </li>
              <li>
                <p>Supir*</p>
              </li>
              <li>
                <p>PPN</p>
              </li>
            </ul>
          </div>
          <div class="col">
            <h5 class="text-dark">Tidak Termasuk</h5>
            <ul>
              <li>
                <p>BBM*</p>
              </li>
              <li>
                <p>Parkir*</p>
              </li>
              <li>
                <p>Tol*</p>
              </li>
              <li>
                <p>Uang makan supir*</p>
              </li>
              <li>
                <p><i>Overtime</i></p>
              </li>
              <li>
                <p>Tiket masuk objek wisata</p>
              </li>
            </ul>
          </div>
        </div>
        <p>* kecuali paket Lepas Kunci (tanpa pengemudi)</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  function confirmLogin(e) {
    e.preventDefault();

    swalWithBootstrapButtons.fire({
      title: 'Anda harus login terlebih dahulu',
      text: "Apakah anda ingin login sekarang?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, login sekarang!'
    }).then((result) => {
      if (result.value) {
        window.location.href = "{{ route('login') }}";
      }
    });
  }
</script>
@endpush