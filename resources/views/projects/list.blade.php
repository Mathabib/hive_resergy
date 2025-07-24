@extends('layouts.app')
@section('content')
@include('komponen.navbar_mode')

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
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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
      <!-- Header Kosong / Breadcrumb jika perlu -->
    </div>
  </div>

  <div class="app-content">
    <!-- Search bar -->
<div style="max-width: 600px; width: 100%; margin-bottom: 15px;">
  <div class="d-flex align-items-center gap-2 flex-wrap">
    <div style="flex: 1 1 250px;">
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="task-search" class="form-control" placeholder="Search tasks...">
      </div>
    </div>
    <div style="flex: 1 1 140px;">
      <select id="status-filter" class="form-select form-select-sm rounded shadow-sm">
        <option value="">All Status</option>
        <option value="todo">To Do</option>
        <option value="inprogress">In Progress</option>
        <option value="done">Done</option>
      </select>
    </div>
  </div>
</div>




    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center w-100">
              <div class="card-title mb-0">List Task</div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="task-table">
                  <thead class="table-danger">
                    <tr>
                      <th>No</th>
                      <th>Task</th>
                      <th>Status</th>
                      <th>Duration Estimate</th>
                      <th>Start</th>
                      <th>End</th>
                      <th>Priority</th>
                      <th>Assign To</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($tasks as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_task }}</td>
                        <td>
                          <span class="badge 
                            {{ $item->status == 'todo' ? 'text-bg-secondary' : ($item->status == 'inprogress' ? 'text-bg-warning' : 'text-bg-success') }}">
                            {{ $item->status }}
                          </span>
                        </td>
                        <td>{{ $item->estimate }} Hour</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td>{{ $item->priority }}</td>
                       <td>
                        @if($item->assignedUsers->count())
                          <ul class="mb-0 ps-3">
                            @foreach($item->assignedUsers as $user)
                              <li>{{ $user->name }}</li>
                            @endforeach
                          </ul>
                        @else
                          -
                        @endif
                      </td>

 
                      </tr>
                    @empty
                      <tr>
                        <td colspan="8" class="text-center">No tasks available</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <div class="card-footer clearfix">
            <div class="float-end">
                {{ $tasks->links('pagination::bootstrap-5') }}
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
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('task-search');
  const statusFilter = document.getElementById('status-filter');
  const rows = document.querySelectorAll('#task-table tbody tr');

  function filterTasks() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedStatus = statusFilter.value;

    rows.forEach(row => {
      const taskName = row.children[1]?.textContent.toLowerCase() || '';
      const taskStatus = row.children[2]?.textContent.toLowerCase().trim() || '';

      const matchesName = taskName.includes(searchTerm);
      const matchesStatus = !selectedStatus || taskStatus === selectedStatus;

      row.style.display = (matchesName && matchesStatus) ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterTasks);
  statusFilter.addEventListener('change', filterTasks);
});
</script>

@endpush
