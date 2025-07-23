@extends('layouts.app')

@section('content')
<style>
.search-bar-container {
  padding: 0 20px;
  margin-top: 20px;
  margin-bottom: 10px;
}

.search-bar {
  max-width: 400px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.search-bar .input-group-text {
  background-color: #edf2f7;
  border: none;
  color: #4a5568;
}

.search-bar .form-control {
  background-color: #f7fafc;
  border: none;
  color: #2d3748;
  font-weight: 500;
  font-size: 0.95rem;
}

.search-bar .form-control:focus {
  box-shadow: none;
  background-color: #ffffff;
}
</style>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Today's Active Users</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Active Users</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="search-bar-container">
      <div class="input-group search-bar">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="user-search" class="form-control" placeholder="Search active users...">
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center w-100 bg-light-subtle text-white">
              <div class="card-title mb-0">
               <span class="text-danger">
                <i class="bi bi-people-fill"></i> Active Users Today

               </span> 
            </div>
            </div>

            <div class="card-body">
              @if($activeUsers->count())
                <div class="table-responsive">
                  <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th style="width: 50px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last Login</th>
                      </tr>
                    </thead>
                    <tbody id="user-table-body">
                      @foreach($activeUsers as $index => $user)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            @if($user->role === 'admin')
                              <span class="badge bg-danger">Admin</span>
                            @else
                              <span class="badge bg-secondary">User</span>
                            @endif
                          </td>
                          <td>{{ \Carbon\Carbon::parse($user->last_login)->format('d M Y H:i') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-info mt-3">No active users found today.</div>
              @endif
            </div>

            <div class="card-footer clearfix">
              <div class="float-end">
                {{-- Tambahkan paginasi jika aktif --}}
                {{-- {{ $activeUsers->links('pagination::bootstrap-5') }} --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
@endsection

@push('js')
<script>
// User search filter
document.getElementById('user-search').addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase();
  const rows = document.querySelectorAll('#user-table-body tr');

  rows.forEach(row => {
    const rowText = row.innerText.toLowerCase();
    row.style.display = rowText.includes(searchTerm) ? '' : 'none';
  });
});
</script>
@endpush
