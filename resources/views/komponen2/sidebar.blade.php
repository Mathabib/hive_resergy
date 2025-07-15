<!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="./index.html" class="brand-link d-flex align-items-center justify-content-between px-3">
                <!--begin::Left Logo-->
                <img
                  src="{{ asset('assets/image/logo-isol.png') }}"
                  width="70"
                  alt="Isolutions Logo"
                  class="brand-image opacity-75 shadow"
                />
            
            </a>
            <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
            <nav class="mt-2">
                <!--begin::Sidebar Menu-->
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link active">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> 
                   <li class="nav-item {{ request()->is('projects*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('projects*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    Projects
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="{{ request()->is('projects*') ? 'display: block;' : 'display: none;' }}">
                  @foreach($projects_sidebar as $project)
                    <li class="nav-item">
                      <a href="{{ route('projects.show', $project->id) }}"
                          class="nav-link {{ request()->is('projects/'.$project->id) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>{{ $project->nama }}</p>
                      </a>
                    </li>
                  @endforeach
                </ul>
                </li>

                    
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>
                                    Settings
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">                            
                                    <li class="nav-item">
                                        {{-- <a href="{{ route('projects.index2', $project->id) }}" class="nav-link"> --}}
                                        <a href="{{ route('projects.index2') }}" class="nav-link">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Projects</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        {{-- <a href="{{ route('users.index', $project->id) }}" class="nav-link"> --}}
                                        <a href="{{ route('users.index') }}" class="nav-link">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Users</p>
                                        </a>
                                    </li>  
                                    
                                   <li class="nav-item">
                                    <a href="{{ route('admin.task-rutinan') }}" class="nav-link {{ request()->routeIs('admin.task-rutinan') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Recurring Tasks</p>
                                    </a>
                                </li>

                            </ul>                            
                        </li>
                    @endif
                </ul>
                <!--end::Sidebar Menu-->
            </nav>
            </div>
            <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

      <script>
        console.log('hallo dari asside menu kebaca gak ya')
      </script>

      <script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.sidebar-menu [data-lte-toggle="treeview"]').forEach(function (treeviewToggle) {
    treeviewToggle.querySelectorAll('.nav-link').forEach(function (link) {
      link.addEventListener('click', function (e) {
        const parentItem = this.closest('.nav-item');
        const subMenu = parentItem.querySelector('.nav-treeview');
        const isOpen = parentItem.classList.contains('menu-open');

        if (subMenu) {
          e.preventDefault();

          if (isOpen) {
            parentItem.classList.remove('menu-open');
            subMenu.style.display = 'none';
          } else {
            parentItem.classList.add('menu-open');
            subMenu.style.display = 'block';
          }
        }
      });
    });
  });
});
</script>
