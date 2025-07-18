@extends('layouts.app')

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Profile</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
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
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-danger card-outline mb-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $authuser->name) }}">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $authuser->email) }}">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>New Password (leave blank if not changing)</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Profile Photo</label><br>
                                    @if($authuser->profile_photo)
                                        <img src="{{ asset('storage/profile_photos/' . $authuser->profile_photo) }}" width="100" class="rounded mb-2">
                                    @endif
                                    <input type="file" name="profile_photo" class="form-control">
                                    @error('profile_photo') <small class="text-danger">{{ $message }}</small> @enderror
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
