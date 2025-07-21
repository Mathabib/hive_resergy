@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Recurring Tasks by Project</h1>
        <form action="{{ route('admin.task-rutinan.generate-now') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-arrow-repeat me-1"></i> Generate Now
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="accordion" id="projectAccordion">
        @foreach($projects as $project)
            <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="heading{{ $project->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $project->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $project->id }}">
                        {{ $project->nama }}
                    </button>
                </h2>
                <div id="collapse{{ $project->id }}" class="accordion-collapse collapse"
                     aria-labelledby="heading{{ $project->id }}" data-bs-parent="#projectAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%;">Task Name</th>
                                    <th style="width: 50%;">Description</th>
                                    <th style="width: 20%;" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->recurringTasks as $task)
                                <tr data-task-id="{{ $task->id }}">
                                    <form method="POST" action="{{ route('admin.task-rutinan.s.update', $task->id) }}" class="task-form">
                                        @csrf
                                        @method('PUT')
                                        <td>
                                            <span class="task-name">{{ $task->nama }}</span>
                                            <input type="text" name="nama" class="form-control form-control-sm d-none" value="{{ $task->nama }}" required>
                                        </td>
                                        <td>
                                            <span class="task-desc">{{ $task->deskripsi }}</span>
                                            <input type="text" name="deskripsi" class="form-control form-control-sm d-none" value="{{ $task->deskripsi }}">
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-outline-success d-none btn-save">
                                                    <i class="bi bi-check"></i> Save
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary d-none btn-cancel">
                                                    <i class="bi bi-x"></i> Cancel
                                                </button>
                                            </div>
                                        </td>
                                    </form>
                                    <td>
                                        <form method="POST" action="{{ route('admin.task-rutinan.destroy', $task->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <form method="POST" action="{{ route('admin.task-rutinan.store') }}">
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        <td>
                                            <input type="text" name="nama" class="form-control form-control-sm" placeholder="Task Name" required>
                                        </td>
                                        <td>
                                            <input type="text" name="deskripsi" class="form-control form-control-sm" placeholder="Task Description">
                                        </td>
                                        <td colspan="2">
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-plus-circle"></i> Add
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const namaSpan = row.querySelector('.task-name');
            const deskripsiSpan = row.querySelector('.task-desc');
            const namaInput = row.querySelector('input[name="nama"]');
            const deskripsiInput = row.querySelector('input[name="deskripsi"]');

            // Simpan nilai awal
            namaInput.dataset.original = namaInput.value;
            deskripsiInput.dataset.original = deskripsiInput.value;

            // Tampilkan input dan sembunyikan span
            namaSpan.classList.add('d-none');
            deskripsiSpan.classList.add('d-none');
            namaInput.classList.remove('d-none');
            deskripsiInput.classList.remove('d-none');

            // Tampilkan tombol Save dan Cancel
            button.classList.add('d-none');
            row.querySelector('.btn-save').classList.remove('d-none');
            row.querySelector('.btn-cancel').classList.remove('d-none');
        });
    });

    document.querySelectorAll('.btn-cancel').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const row = button.closest('tr');
            const namaSpan = row.querySelector('.task-name');
            const deskripsiSpan = row.querySelector('.task-desc');
            const namaInput = row.querySelector('input[name="nama"]');
            const deskripsiInput = row.querySelector('input[name="deskripsi"]');

            // Kembalikan nilai ke semula
            namaInput.value = namaInput.dataset.original;
            deskripsiInput.value = deskripsiInput.dataset.original;

            // Sembunyikan input, tampilkan span
            namaSpan.classList.remove('d-none');
            deskripsiSpan.classList.remove('d-none');
            namaInput.classList.add('d-none');
            deskripsiInput.classList.add('d-none');

            // Reset tombol
            row.querySelector('.btn-edit').classList.remove('d-none');
            row.querySelector('.btn-save').classList.add('d-none');
            row.querySelector('.btn-cancel').classList.add('d-none');
        });
    });
});
</script>
@endpush
