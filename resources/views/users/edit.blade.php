@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    h1 {
        font-weight: 800;
        color: #ffca28;
        animation: slideDown 0.6s ease-out;
    }

    .form-container {
        background-color: #1e1e1e;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 25px rgba(255, 235, 59, 0.1);
        animation: fadeIn 0.6s ease-in-out;
    }

    label {
        font-weight: 500;
        color: #ffeb3b;
    }

    .form-control {
        background-color: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
        padding: 0.65rem 0.75rem;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #ffeb3b;
        box-shadow: 0 0 0 0.2rem rgba(255, 235, 59, 0.2);
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #ffca28;
        color: #000;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #757575;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #616161;
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    @keyframes slideDown {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<div class="container py-4">
    <h1 class="mb-4">Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops! Something went wrong:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">New Password (optional)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank if unchanged">
            </div>

            <div class="form-group mb-3">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="project_ids">Project Access</label>
                <select name="project_ids[]" id="project_ids" class="form-control" multiple>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ $user->projects->contains($project->id) ? 'selected' : '' }}>
                            {{ $project->nama }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple projects.</small>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Changes
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>


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

        // Edit functionality
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
