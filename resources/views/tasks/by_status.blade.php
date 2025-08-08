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

<div class="container-fluid">
    <h1 class="mb-4 text-capitalize">
        {{ $status }} Tasks
    </h1>

    <!-- Client-side search bar -->
    <div class="search-bar-container mb-3">
        <div class="input-group search-bar">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" id="task-search" class="form-control" placeholder="Search for task (name, project...)">
        </div>
    </div>

    <!-- Table: List Tasks -->
    <div class="card">
        <div class="card-header bg-light-subtle text-white">
            <span class="text-danger">
                <i class="bi bi-list-task"></i> List of {{ $status }} tasks
            </span>
        </div>
        <div class="card-body p-0">
            @if ($tasks->isEmpty())
                <div class="alert alert-info m-3">No tasks found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Task</th>
                                <th>Project</th>
                                <th>Deadline</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="task-table-body">
                            @foreach ($tasks as $task)
                                <tr>
                                   <td>{{ $tasks->firstItem() + $loop->index }}</td>
                                    <td>{{ $task->nama_task }}</td>
                                    <td>{{ $task->project->nama ?? '-' }}</td>
                                    <td>
                                        {{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @if (!$tasks->isEmpty() && method_exists($tasks, 'links'))
            <div class="card-footer">
                <div class="float-end">
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.getElementById('task-search').addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase();
  const rows = document.querySelectorAll('#task-table-body tr');

  rows.forEach(row => {
    const rowText = row.innerText.toLowerCase();
    row.style.display = rowText.includes(searchTerm) ? '' : 'none';
  });
});
</script>
@endpush
