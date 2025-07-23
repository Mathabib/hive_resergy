@extends('layouts.app')

@section('content')

    @if(Auth::user()->role === 'admin')

        @include('komponen.main', [
            'totalProjects'    => $totalProjects,
            'totalTasks'       => $totalTasks,
            'totalUsers'       => $totalUsers,
            'tasksPerProject'  => $tasksPerProject,
            'taskStats'        => $taskStats ?? []
        ])

    @else

        @include('komponen.main-user')

    @endif

@endsection
