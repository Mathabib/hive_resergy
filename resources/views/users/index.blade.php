@extends('layouts.app')
@section('content')
   <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Users List</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Users List</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
     <div class="card-header d-flex justify-content-between align-items-center w-100">
    <div class="card-title mb-0">User List</div>
    <div class="ms-auto">
        <a href="{{ route('users.create') }}" class="btn btn-danger-subtle btn-sm">
            <i class="bi bi-plus-lg"></i> Add New User
        </a>
    </div>
</div>


          <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($users->count())
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                  <thead class="table-danger">
                      <tr>
                        <th style="width: 50px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Project Access</th>
                        <th style="width: 220px;">Actions</th>
                      </tr>
                    </thead>

                  </thead>
                  <tbody>
                    @foreach($users as $index => $user)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                       <td>
                      @if($user->role === 'admin')
                        <span class="badge bg-danger">All Project</span>
                      @elseif($user->projects && $user->projects->count())
                        <ul class="mb-0 ps-3">
                          @foreach($user->projects as $project)
                            <li>{{ $project->nama }}</li>
                          @endforeach
                        </ul>
                      @else
                        <span class="text-muted">No Project</span>
                      @endif
                    </td>

                        <td>
                          <div class="d-flex gap-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                              <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info mt-3">No users found. Please add a new user.</div>
            @endif
          </div>

          <!-- Pagination -->
          <div class="card-footer clearfix">
            <div class="float-end">
              {{ $users->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>

        <!--end::App Content-->
      </main>

@endsection