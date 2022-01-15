<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-car"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SiRemo</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Admin
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item {{ (request()->segment(1) == 'cars') ? 'active' : ''}}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-car-side"></i>
      <span>Cars</span>
    </a>
    <div id="collapseTwo" class="collapse {{ (request()->segment(1) == 'cars') ? 'show' : ''}}"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Cars:</h6>
        <a class="collapse-item {{ (request()->segment(2) == 'car-brands') ? 'active' : ''}}"
          href="{{ route('admin.car-brands.index') }}">Brands</a>
        <a class="collapse-item {{ (request()->segment(2) == 'car-models') ? 'active' : ''}}"
          href="{{ route('admin.car-models.index') }}">Models</a>
        <a class="collapse-item {{ (request()->segment(2) == 'cars') ? 'active' : ''}}"
          href="{{ route('admin.cars.index') }}">Cars</a>
      </div>
    </div>
  </li>

  <!-- Drivers -->
  <li class="nav-item {{ (request()->segment(1) == 'drivers') ? 'active' : ''}}">
    <a class="nav-link" href="{{ route('admin.drivers.index') }}">
      <i class="fas fa-user-tie"></i>
      <span>Drivers</span></a>
  </li>

  <!-- Banks -->
  <li class="nav-item {{ (request()->segment(1) == 'banks') ? 'active' : ''}}">
    <a class="nav-link" href="{{ route('admin.banks.index') }}">
      <i class="fas fa-money-check-alt"></i>
      <span>Banks</span></a>
  </li>

  <!-- Checkouts -->
  {{-- <li class="nav-item {{ (request()->segment(1) == 'checkouts') ? 'active' : ''}}">
  <a class="nav-link" href="{{ route('admin.checkouts.index') }}">
    <i class="far fa-money-bill-alt"></i>
    Checkouts
    @if (App\Models\Checkout::waitingConfirmation()->count() > 0)
    <span class="badge badge-danger ml-2">•</span>
    @endif
  </a>
  </li> --}}

  <!-- Car in and out -->
  <li class="nav-item {{ (request()->segment(1) == 'car-in-and-out') ? 'active' : ''}}">
    <a class="nav-link" href="{{ route('admin.car-in-and-out.index') }}">
      <i class="fas fa-folder"></i>
      <span>Car in and out</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>

@if (App\Models\Checkout::waitingConfirmation()->count() > 0 && request()->segment(1) !== 'checkouts')
@push('script')
<script>
  $(document).ready(function() {
      swalWithBootstrapButtons.fire({
      title: 'Ada pesanan masuk!',
      text: 'Silahkan cek pesanan masuk',
      icon: 'info',
    })
  });
</script>
@endpush
@endif