@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-group mb-3">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
  </div>

  <div class="form-group mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
  </div>



<div class="form-group mb-3">
  <label for="password">New Password <small class="text-muted">(optional)</small></label>
  <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
</div>

<div class="form-group mb-3">
  <label for="password_confirmation">Confirm Password <small class="text-muted">(optional)</small></label>
  <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank if not changing password">
</div>



<div class="form-group mb-3">
  <label for="role">Role</label>
  <select name="role" id="role" class="form-control" onchange="toggleProjectAccess()">
      <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
      <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
  </select>
</div>

<div class="form-group mb-4" id="project-access-section">
    <label for="project_ids">Project Access</label>

    {{-- Info untuk admin --}}
    <div id="admin-info" class="alert alert-info py-2 px-3 mb-0" style="display: none;">
        <i class="bi bi-globe"></i> This user has access to <strong>all projects</strong> (Admin role).
    </div>

    {{-- Dropdown untuk user --}}
    <select name="project_ids[]" id="project_ids" class="form-control" multiple>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}"
                {{ in_array($project->id, old('project_ids', $selectedProjects)) ? 'selected' : '' }}>
                {{ $project->nama }}
            </option>
        @endforeach
    </select>
</div>




  <button type="submit" class="btn btn-primary">Update</button>
</form>

</div>
@endsection

@push('scripts')
<script>
    function toggleProjectAccess() {
        const roleSelect = document.getElementById('role');
        const selectedRole = roleSelect.value;
        const adminInfo = document.getElementById('admin-info');
        const projectDropdown = document.getElementById('project_ids');

        if (selectedRole === 'admin') {
            adminInfo.style.display = 'block';
            projectDropdown.style.display = 'none';
        } else {
            adminInfo.style.display = 'none';
            projectDropdown.style.display = 'block';
        }
    }

    // Panggil saat halaman pertama kali dimuat
    window.addEventListener('DOMContentLoaded', toggleProjectAccess);
</script>
@endpush

