@extends('layouts.app')

@section('content')
<main class="app-main">
  <!-- App Content Header -->
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Project List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Project List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- App Content -->
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-12">

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <div class="card card-danger card-outline">
            <div class="card-header">
              <h5 class="card-title mb-0">Project Management</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-danger">
                    <tr>
                      <th style="width: 50px;">No</th>
                      <th>Project Name</th>
                      <th>Description</th>
                      <th style="width: 250px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $counter = 1; @endphp
                    @foreach ($projects->where('parent_id', null) as $parent)
                      @php $hasSubfolders = $projects->where('parent_id', $parent->id)->count() > 0; @endphp
                      <tr data-id="{{ $parent->id }}" class="parent-row">
                        <td>{{ $counter++ }}</td>
                        <td>
                          @if ($hasSubfolders)
                            <button class="btn btn-sm btn-toggle-subfolder" data-id="{{ $parent->id }}">
                              <i class="bi bi-caret-right-fill"></i>
                            </button>
                          @endif
                          <strong>{{ $parent->nama }}</strong>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($parent->deskripsi, 100) }}</td>
                        <td>
                          <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-sm btn-warning btn-edit">  <i class="bi bi-pencil-square"></i> Edit</button>
                            <form action="{{ route('projects.destroy', $parent->id) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger">  <i class="bi bi-trash"></i> Delete</button>
                            </form>
                            <button class="btn btn-sm btn-primary btn-add-subfolder" data-id="{{ $parent->id }}">
                             <i class="bi bi-folder-plus"></i> 
                            </button>
                          </div>
                        </td>
                      </tr>

                      {{-- Edit row for parent --}}
                      <tr class="edit-row d-none" data-id="{{ $parent->id }}">
                        <form action="{{ route('projects.update', $parent->id) }}" method="POST">
                          @csrf @method('PUT')
                          <td></td>
                          <td><input type="text" name="nama" class="form-control" value="{{ $parent->nama }}" required></td>
                          <td><input type="text" name="deskripsi" class="form-control" value="{{ $parent->deskripsi }}"></td>
                          <td>
                            <div class="d-flex gap-2">
                              <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Save</button>
                              <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit" data-id="{{ $parent->id }}"><i class="bi bi-x-lg"></i> Cancel</button>
                            </div>
                          </td>
                        </form>
                      </tr>

                      @foreach ($projects->where('parent_id', $parent->id) as $child)
                        <tr class="subfolder-row d-none" data-parent-id="{{ $parent->id }}" data-id="{{ $child->id }}">
                          <td></td>
                          <td><span class="ms-4"><i class="bi bi-arrow-return-right text-muted me-1"></i> {{ $child->nama }}</span></td>
                          <td>{{ \Illuminate\Support\Str::limit($child->deskripsi, 100) }}</td>
                          <td>
                            <div class="d-flex gap-2">
                              <button class="btn btn-sm btn-warning btn-edit">Edit</button>
                              <form action="{{ route('projects.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Delete this subfolder?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </div>
                          </td>
                        </tr>

                        {{-- Edit row for child --}}
                        <tr class="edit-row d-none" data-id="{{ $child->id }}">
                          <form action="{{ route('projects.update', $child->id) }}" method="POST">
                            @csrf @method('PUT')
                            <td></td>
                            <td><input type="text" name="nama" class="form-control" value="{{ $child->nama }}" required></td>
                            <td><input type="text" name="deskripsi" class="form-control" value="{{ $child->deskripsi }}"></td>
                            <td>
                              <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Save</button>
                                <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit" data-id="{{ $child->id }}"><i class="bi bi-x-lg"></i> Cancel</button>
                              </div>
                            </td>
                          </form>
                        </tr>
                      @endforeach

                      {{-- Subfolder Add Form --}}
                      <tr class="subfolder-form-row d-none" data-parent-id="{{ $parent->id }}">
                        <form action="{{ route('projects.store') }}" method="POST">
                          @csrf
                          <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                          <td></td>
                          <td><input type="text" name="nama" class="form-control" placeholder="Subfolder name" required></td>
                          <td><input type="text" name="deskripsi" class="form-control" placeholder="Subfolder description"></td>
                          <td>
                            <div class="d-flex gap-2">
                              <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Save</button>
                              <button type="button" class="btn btn-sm btn-secondary btn-cancel-subfolder"><i class="bi bi-x-lg"></i> Cancel</button>
                            </div>
                          </td>
                        </form>
                      </tr>
                    @endforeach

                    <!-- Add Button -->
                    <tr id="add-project-button-row">
                      <td>{{ $projects->count() + 1 }}</td>
                      <td colspan="2">
                        <button id="btn-show-add" class="btn btn-sm btn-danger-subtle">
                          <i class="bi bi-plus-lg"></i> Add Project
                        </button>
                      </td>
                      <td></td>
                    </tr>

                    <!-- Add Form -->
                    <tr id="add-project-form-row" class="d-none">
                      <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <td></td>
                        <td><input type="text" name="nama" class="form-control" placeholder="Project name" required></td>
                        <td><input type="text" name="deskripsi" class="form-control" placeholder="Project description"></td>
                        <td>
                          <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-success">
                              <i class="bi bi-check-lg"></i> Save
                            </button>
                            <button type="button" id="btn-cancel-add" class="btn btn-sm btn-secondary">
                              <i class="bi bi-x-lg"></i> Cancel
                            </button>
                          </div>
                        </td>
                      </form>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn-show-add')?.addEventListener('click', () => {
      document.getElementById('add-project-button-row').classList.add('d-none');
      document.getElementById('add-project-form-row').classList.remove('d-none');
    });

    document.getElementById('btn-cancel-add')?.addEventListener('click', () => {
      document.getElementById('add-project-form-row').classList.add('d-none');
      document.getElementById('add-project-button-row').classList.remove('d-none');
    });

    document.querySelectorAll('.btn-toggle-subfolder').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        document.querySelectorAll(`.subfolder-row[data-parent-id="${id}"]`).forEach(row => row.classList.toggle('d-none'));
        const icon = btn.querySelector('i');
        icon.classList.toggle('bi-caret-right-fill');
        icon.classList.toggle('bi-caret-down-fill');
      });
    });

    document.querySelectorAll('.btn-add-subfolder').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const row = document.querySelector(`.subfolder-form-row[data-parent-id="${id}"]`);
        row?.classList.remove('d-none');
      });
    });

    document.querySelectorAll('.btn-cancel-subfolder').forEach(btn => {
      btn.addEventListener('click', () => {
        const row = btn.closest('tr');
        row.classList.add('d-none');
        row.querySelector('input[name="nama"]').value = '';
        row.querySelector('input[name="deskripsi"]').value = '';
      });
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.addEventListener('click', () => {
        const tr = btn.closest('tr');
        const id = tr.dataset.id;
        tr.style.display = 'none';
        document.querySelector(`.edit-row[data-id="${id}"]`).classList.remove('d-none');
      });
    });

    document.querySelectorAll('.btn-cancel-edit').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        document.querySelector(`.edit-row[data-id="${id}"]`).classList.add('d-none');
        document.querySelector(`tr[data-id="${id}"]`).style.display = '';
      });
    });
  });
</script>
@endsection