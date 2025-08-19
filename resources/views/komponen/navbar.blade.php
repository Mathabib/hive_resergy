
<style>
 /* Navbar text & icon jadi hitam */
.app-header.navbar.bg-warning .nav-link,
.app-header.navbar.bg-warning .nav-link i,
.app-header.navbar.bg-warning .user-menu > a,
.app-header.navbar.bg-warning .dropdown-menu a {
  color: #000 !important;
}

/* Hover effect opsional */
.app-header.navbar.bg-warning .nav-link:hover,
.app-header.navbar.bg-warning .dropdown-menu a:hover {
  color: #333 !important;
}
</style>
<nav class="app-header navbar navbar-expand bg-warning">
    {{-- <nav class="app-header navbar navbar-expand {{ $themeSetting->navbar_color ?? 'bg-primary' }}"
    data-bs-theme="{{ $themeSetting->navbar_theme ?? 'light' }}"> --}}

        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          
          </ul>
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
           
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                 src="{{ $authuser && $authuser->profile_photo ? asset('storage/profile_photos/' . $authuser->profile_photo) : asset('assets/img/default-avatar.png') }}"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                 <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-warning">
                  <img
                     src="{{ $authuser && $authuser->profile_photo ? asset('storage/profile_photos/' . $authuser->profile_photo) : asset('assets/img/default-avatar.png') }}"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                    <p>
                        {{ Auth::user()->name }}
                       </p>
                </li>



                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                 <!-- diisi dengan desc si user -->
                </li>
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
               <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat bg-warning">Profile</a>

                    <a href="#" class="btn btn-default btn-flat bg-warning float-end"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>