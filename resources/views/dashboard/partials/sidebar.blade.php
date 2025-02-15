<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="./index.html" class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="{{ asset('dist/assets/img/LogoSellva.png') }}"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">SellVa</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
          @auth
          <!--Admin-->
              @if (Auth::user()->role === 'admin')
                  <li class="nav-item">
                      <a href="{{ route('dashboard.index') }}" class="nav-link">
                          <i class="bi bi-speedometer2"></i>
                          <p>Dashboard</p>
                      </a>
                  </li>
              @endif
              <!--Admin & Kasir-->
              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'kasir')
                  <li class="nav-item">
                      <a href="{{ route('dataProduk.index') }}" class="nav-link">
                        <i class="bi bi-box-seam"></i>
                          <p>Data Barang</p>
                      </a>
                  </li>
              @endif
              <!--Admin-->
              @if (Auth::user()->role === 'admin')
                  <li class="nav-item">
                      <a href="{{ route('dataOrder') }}" class="nav-link">
                        <i class="bi bi-receipt"></i>
                          <p>Data Order</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('dataUsers')}}" class="nav-link">
                        <i class="bi bi-person-badge-fill"></i>
                          <p>Data User</p>
                      </a>
                  </li>
              @endif
              <!--Admin & Kasir-->
              @if (Auth::user()->role === 'admin' || Auth::user()->role === 'kasir')
                  <li class="nav-item">
                      <a href="{{ route('profile') }}" class="nav-link">
                        <i class="bi bi-person-badge"></i>
                          <p>Profile</p>
                      </a>
                  </li>
              @endif
          @endauth
      </ul>
      
        {{-- <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false" >
        <li class="nav-item">
          <a href="{{ route('dashboard.index') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('dataProduk.index') }}" class="nav-link">
            <i class="bi bi-archive-fill"></i>
            <p>Data Barang</p>
          </a>
        </li>
        </ul> --}}
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
  <!--end::Sidebar-->