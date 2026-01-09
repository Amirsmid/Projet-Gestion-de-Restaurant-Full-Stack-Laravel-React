  <!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo " href="{{ route('dashboard') }}">
              @if (isset($infoormations) && $infoormations->logo)
                  <img src="{{ asset('images') }}/{{ $infoormations->logo }}" width="50" height="50" alt="logo" style="object-fit: contain;" />
              @else
                  <span class="text-white fw-bold">{{ config('app.name','Dashboard') }}</span>
              @endif
          </a>
          @if (isset($infoormations) && $infoormations->logo)
                  <img src="{{ asset('images') }}/{{ $infoormations->logo }}" width="30" height="30" alt="logo" class="navbar-brand brand-logo-mini" style="object-fit: contain;" />
          @endif
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu"></span>
          </button>

          <ul class="navbar-nav navbar-nav-right">

              <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                      <img src="{{ asset('images/faces/face28.png') }}" alt="profile" />{{ Auth::user()->name }}
                  </a>
              </li>
              <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                      <i class="icon-ellipsis"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                      <a class="dropdown-item">
                          <i class="ti-settings text-primary"></i>
                          Settings
                      </a>
                      <a class="dropdown-item" href="{{ route('logout') }}">
                          <i class="ti-power-off text-primary"></i>
                          Logout
                      </a>
                  </div>
              </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
              data-toggle="offcanvas">
              <span class="icon-menu"></span>
          </button>
      </div>
  </nav>
  <!-- partial -->
