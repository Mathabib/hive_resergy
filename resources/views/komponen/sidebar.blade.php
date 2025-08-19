  <!--begin::Sidebar-->
      <aside class="app-sidebar bg-warning shadow">

        {{-- styling tambahan untuk merubah warna text sidebar menu --}}
        <style>
          .sidebar-wrapper .nav-link,
          .sidebar-wrapper .nav-link p,
          .sidebar-wrapper .nav-link i {
            color: #000 !important;
          }
        </style>
        
      {{-- <aside class="app-sidebar {{ $themeSetting->sidebar_color ?? 'bg-body-tertiary' }}"
    data-bs-theme="{{ $themeSetting->sidebar_theme ?? 'light' }}"> --}}
  
      <!--begin::Sidebar Brand-->
        <div class="d-flex justify-content-center p-2">
          <!--begin::Brand Link-->
          <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
             <!--begin::Left Logo-->
               <img
                src="{{ asset('assets/image/resindo-logo.jpg') }}"
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
        <div class="sidebar-wrapper text-dark">
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
                        Department
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <!-- <ul class="nav nav-treeview" style="{{ request()->is('projects*') ? 'display: block;' : 'display: none;' }}">
                      @foreach($projects_sidebar as $project)
                        <li class="nav-item">
                          <a href="{{ route('projects.show', $project->id) }}"
                              class="nav-link {{ request()->is('projects/'.$project->id) ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>{{ $project->nama }}</p>
                          </a>
                        </li>
                      @endforeach
                    </ul> -->

<ul class="nav nav-treeview">
  @foreach($projects_sidebar as $project)
    @if(is_null($project->parent_id))
      <li class="nav-item has-treeview">
        @if($project->children && $project->children->count())
          <!-- Bagi jadi dua: satu untuk link, satu untuk toggle -->
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('projects.show', $project->id) }}"
               class="nav-link flex-grow-1 text-truncate {{ request()->is('projects/'.$project->id) ? 'active' : '' }}">
              <i class="nav-icon bi bi-folder"></i>
              <p class="mb-0">{{ $project->nama }}</p>
            </a>
            <button class="btn btn-sm btn-toggle-subfolder" style="background:none; border:none;">
              <i class="fas fa-angle-left"></i>
            </button>
          </div>

          <ul class="nav nav-treeview subproject-list ms-3" style="display: none;">
            @foreach($project->children as $child)
              <li class="nav-item">
                <a href="{{ route('projects.show', $child->id) }}"
                   class="nav-link {{ request()->is('projects/'.$child->id) ? 'active' : '' }}">
                  <i class="bi bi-circle nav-icon"></i>
                  <p>{{ $child->nama }}</p>
                </a>
              </li>
            @endforeach
          </ul>
        @else
          <!-- Kalau tidak punya anak, langsung jadi link biasa -->
          <a href="{{ route('projects.show', $project->id) }}"
             class="nav-link {{ request()->is('projects/'.$project->id) ? 'active' : '' }}">
            <i class="nav-icon bi bi-folder"></i>
            <p>{{ $project->nama }}</p>
          </a>
        @endif
      </li>
    @endif
  @endforeach
</ul>



                    </li>

                    
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear-fill"></i>
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

                         <li class="nav-item">
                            <a href="#" class="nav-link">
                               <i class="nav-icon bi bi-envelope-fill"></i>
                                <p>
                                    Email
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">                            
                                    <li class="nav-item">
                                        <a href="{{ route('crm.index') }}" class="nav-link">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>CRM</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('broadcast.index') }}" class="nav-link">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Broadcast Email</p>
                                        </a>
                                    </li>  
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

      @push('js')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.btn-toggle-subfolder');

    toggleButtons.forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault(); // jangan biarkan button nge-reload
        const parent = this.closest('li');
        const sublist = parent.querySelector('.subproject-list');
        const icon = this.querySelector('i');

        if (sublist.style.display === 'none' || sublist.style.display === '') {
          sublist.style.display = 'block';
          icon.classList.remove('fa-angle-left');
          icon.classList.add('fa-angle-down');
        } else {
          sublist.style.display = 'none';
          icon.classList.remove('fa-angle-down');
          icon.classList.add('fa-angle-left');
        }
      });
    });
  });
</script>

      @endpush