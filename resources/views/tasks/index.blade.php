@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">
  @if(request()->is('my-assigned-tasks'))
    My Tasks
  @else
    Daftar Tasks
  @endif
</h1>


    <!-- Card: Filter & Search -->
    <div class="card mb-4">
        <div class="card-header bg-light text-white">
          <span class="text-danger">
    <i class="bi bi-list-task"></i> Filter & Search
</span>

        </div>
        <div class="card-body">
            <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari task..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>Todo</option>
                        <option value="inprogress" {{ request('status') == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="project_id" class="form-select">
                        <option value="">Semua Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table: List Tasks -->
    <div class="card">
        <div class="card-header bg-light-subtle text-white">
           <span class="text-danger">
    <i class="bi bi-list-task"></i> list of all tasks
</span>

        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Task</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                  <tbody>
    @forelse ($tasks as $task)
    <tr>
        <td>{{ $tasks->firstItem() + $loop->index }}</td>
        <td>{{ $task->nama_task }}</td>
        <td>{{ $task->project->nama ?? '-'  }}</td>
        <td>
            @if ($task->status == 'todo')
                <span class="badge bg-secondary">Todo</span>
            @elseif ($task->status == 'inprogress')
                <span class="badge bg-warning text-dark">In Progress</span>
            @else
                <span class="badge bg-success">Done</span>
            @endif
        </td>
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
    @empty
    <tr>
        <td colspan="7" class="text-center">Tidak ada task ditemukan.</td>
    </tr>
    @endforelse
</tbody>

                </table>
            </div>
        </div>

        <div class="card-footer">
          <div class="float-end">
                {{ $tasks->links('pagination::bootstrap-5') }}
              </div>
        </div>
    </div>
</div>
@endsection
