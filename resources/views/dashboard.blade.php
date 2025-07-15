@extends('layouts.app')

@section('content')

    @if(Auth::user()->role === 'admin')
        @include('komponen.main')
    @else
        @include('komponen.main-user')
    @endif

@endsection