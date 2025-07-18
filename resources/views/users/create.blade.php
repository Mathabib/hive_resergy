@extends('layouts.app')

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Create Users</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-danger card-outline mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Create New User</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <div id="project-group" class="form-group mb-4">
                                    <label for="project_ids">Project Access</label>
                                    <select name="project_ids[]" id="project_ids" class="form-control" multiple>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" {{ (collect(old('project_ids'))->contains($project->id)) ? 'selected' : '' }}>
                                                {{ $project->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple projects.</small>
                                </div>

                                <div id="all-project-label" class="mb-4" style="display: none;">
                                    <label>Project Access</label>
                                    <div class="alert alert-info py-2 px-3 mb-0">
                                        <i class="bi bi-globe"></i> This user has access to <strong>all projects</strong> (Admin role).
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg"></i> Save
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-lg"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const projectSelect = document.getElementById('project_ids');
    const projectGroup = document.getElementById('project-group');
    const allProjectLabel = document.getElementById('all-project-label');

    function toggleProjectAccess() {
        if (!roleSelect || !projectGroup || !projectSelect || !allProjectLabel) return;

        if (roleSelect.value === 'admin') {
            projectGroup.style.display = 'none';
            allProjectLabel.style.display = 'block';

            for (let option of projectSelect.options) {
                option.selected = true;
            }
        } else {
            projectGroup.style.display = 'block';
            allProjectLabel.style.display = 'none';
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener('change', toggleProjectAccess);
        toggleProjectAccess();
    }
});


</script>
@endpush
