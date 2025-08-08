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
        <div class="col-sm-6"><h3 class="mb-0">CRM List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">crm List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="search-bar-container">
      <div class="input-group search-bar">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="crm-search" class="form-control" placeholder="Search CRM...">
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center w-100">
              <div class="card-title mb-0">CRMList</div>
              <div class="ms-auto">
                <a href="{{ route('crm.create') }}" class="btn btn-danger-subtle btn-sm">
                  <i class="bi bi-plus-lg"></i> Add New crm
                </a>
              </div>
            </div>

            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if($clients->count())
                <div class="table-responsive">
                  <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-danger">
                      <tr>
                        <th style="width: 50px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Name Company</th>
                        <th>Address</th>
                        <th>Website</th>
                        <th>Category</th>
                        <th>Notes</th>
                        <th style="width: 220px;">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="user-table-body">
                      @foreach($clients as $index => $c)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $c->name }}</td>
                          <td>{{ $c->email }}</td>
                            <td>{{ $c->phone }}</td>
                            <td>{{ $c->company }}</td>
                            <td>{{ $c->address }}</td>
                            <td>{{ $c->website }}</td>
                            <td>{{ $c->category }}</td>
                            <td>{{ $c->notes }}</td>
                          <td>
                          <div class="d-flex gap-2">
                              <a href="{{ route('crm.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                              </a>
                              <form action="{{ route('crm.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this crm data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                  <i class="bi bi-trash"></i> Delete
                                </button>
                              </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-info mt-3">No crm data found. Please add a new crm data.</div>
              @endif
            </div>

            <div class="card-footer clearfix">
              <div class="float-end">
                {{ $clients->links('pagination::bootstrap-5') }}
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
document.getElementById('crm-search').addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase();
  const rows = document.querySelectorAll('#user-table-body tr');

  rows.forEach(row => {
    const rowText = row.innerText.toLowerCase();
    row.style.display = rowText.includes(searchTerm) ? '' : 'none';
  });
});
</script>
@endpush
