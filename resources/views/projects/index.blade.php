@extends('layouts.app')

@section('content')

<main class="app-main">
  <!--begin::App Content Header-->
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
  <!--end::App Content Header-->

  <!--begin::App Content-->
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
                      <th style="width: 160px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($projects as $index => $project)
                      <!-- Display Row -->
                      <tr data-id="{{ $project->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $project->nama }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($project->deskripsi, 100) }}</td>
                        <td>
                          <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning btn-edit">
                              <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>

                      <!-- Edit Row -->
                      <tr class="edit-row d-none" data-id="{{ $project->id }}">
                        <form action="{{ route('projects.update', $project->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <td></td>
                          <td><input type="text" name="nama" class="form-control" value="{{ $project->nama }}" required></td>
                          <td><input type="text" name="deskripsi" class="form-control" value="{{ $project->deskripsi }}"></td>
                          <td>
                            <div class="d-flex gap-2">
                              <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg"></i> Save
                              </button>
                              <button type="button" class="btn btn-sm btn-secondary btn-cancel">
                                <i class="bi bi-x-lg"></i> Cancel
                              </button>
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
              </div> <!-- end table-responsive -->
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--end::App Content-->
</main>

<!-- Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnShowAdd = document.getElementById('btn-show-add');
    const addFormRow = document.getElementById('add-project-form-row');
    const addBtnRow = document.getElementById('add-project-button-row');
    const btnCancelAdd = document.getElementById('btn-cancel-add');

    // Show add form
    btnShowAdd.addEventListener('click', () => {
      addBtnRow.classList.add('d-none');
      addFormRow.classList.remove('d-none');
    });

    // Cancel add form
    btnCancelAdd.addEventListener('click', () => {
      addFormRow.classList.add('d-none');
      addBtnRow.classList.remove('d-none');
      addFormRow.querySelector('input[name="nama"]').value = '';
      addFormRow.querySelector('input[name="deskripsi"]').value = '';
    });

    // Edit
    document.querySelectorAll('.btn-edit').forEach(button => {
      button.addEventListener('click', e => {
        const row = e.target.closest('tr');
        const id = row.dataset.id;
        row.style.display = 'none';
        document.querySelector(`tr.edit-row[data-id="${id}"]`).classList.remove('d-none');
      });
    });

    // Cancel edit
    document.querySelectorAll('.btn-cancel').forEach(button => {
      button.addEventListener('click', e => {
        const row = e.target.closest('tr.edit-row');
        const id = row.dataset.id;
        row.classList.add('d-none');
        document.querySelector(`tr[data-id="${id}"]`).style.display = '';
      });
    });
  });
</script>

@endsection
