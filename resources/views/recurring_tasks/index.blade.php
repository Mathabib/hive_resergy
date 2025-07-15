@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Recurring Tasks by Project</h1>
        
        {{-- Generate Now Button --}}
        <form action="{{ route('admin.task-rutinan.generate-now') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-arrow-repeat me-1"></i>
                Generate Now
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $project->id }}" aria-expanded="false" aria-controls="collapse{{ $project->id }}">
                        {{ $project->nama }}
                    </button>
                </h2>
                <div id="collapse{{ $project->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $project->id }}" data-bs-parent="#projectAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%;">Task Name</th>
                                    <th style="width: 50%;">Description</th>
                                    <th style="width: 20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->recurringTasks as $task)
                                    <tr>
                                        <td>{{ $task->nama }}</td>
                                        <td>{{ $task->deskripsi }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.task-rutinan.destroy', $task->id) }}">
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
                                        <td>
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
