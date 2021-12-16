<div class="card">
  <h4 class="card-header">{{ $checkout->cars->name }}</h4>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <img src="{{ $image }}" alt="{{ $checkout->cars->name }}" class="img-fluid"
          style="border: 1px solid #ccc; padding: 5px; border-radius: 10px;">
        <hr />
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Kode Booking
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $booking_code }}</p>
          </li>
        </ul>
        <hr />
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Mulai
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $start_date }}</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Tanggal Selesai
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $end_date }}</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Durasi
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $days }} Hari</p>
          </li>
        </ul>
        <hr />
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Pajak
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $tax }}%</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Subtotal
            </p>
          </li>
          <li class="nav-item">
            <p class="card-text text-dark nav-link">{{ $sub_total }}/hari</p>
          </li>
        </ul>
        <ul class="nav nav-pills card-header-pills justify-content-between">
          <li class="nav-item">
            <p class="card-text text-dark nav-link">
              Total
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