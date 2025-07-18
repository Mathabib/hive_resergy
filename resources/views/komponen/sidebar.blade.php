  <!--begin::Sidebar-->
      <!-- <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> -->
      <aside class="app-sidebar {{ $themeSetting->sidebar_color ?? 'bg-body-tertiary' }}"
    data-bs-theme="{{ $themeSetting->sidebar_theme ?? 'light' }}">
  
      <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
             <!--begin::Left Logo-->
               <img
                src="{{ asset('assets/image/logo-isol.png') }}"
                alt="Isolutions Logo"
                style="width: 140px; height: auto;"
                class="brand-image opacity-75 shadow"
                />


            <!--end::Brand Image-->
          
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

                               <li class="nav-item">
                                <a href="{{ route('theme.index') }}" class="nav-link {{ request()->routeIs('theme.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-palette"></i>
                                    <p>Theme</p>
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