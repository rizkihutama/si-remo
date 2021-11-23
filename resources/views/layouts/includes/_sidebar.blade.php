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
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
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

  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Charts</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>