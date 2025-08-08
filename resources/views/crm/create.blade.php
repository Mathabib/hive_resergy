@extends('layouts.app')

@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Add CRM Data</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create CRM</li>
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
                            <h5 class="card-title mb-0">Create CRM</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('crm.store') }}" method="POST">
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
                                    <label for="phone">Phone</label>
                                    <input type="phone" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" >
                                </div>

                                <div class="form-group mb-3">
                                    <label for="company">Name Company</label>
                                    <input type="company" name="company" id="company" class="form-control" required>
                                </div>

                               <div class="form-group mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">-- Pilih Category --</option>
                                        <option value="Clients" {{ old('category') == 'Clients' ? 'selected' : '' }}>Clients</option>
                                        <option value="Vendor" {{ old('category') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="website">Website</label>
                                    <input type="website" name="website" id="website" class="form-control" value="{{ old('website') }}" >
                                </div>

                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <input type="address" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="4" >{{ old('notes') }}</textarea>
                                </div>


                                
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg"></i> Save
                                    </button>
                                    <a href="{{ route('crm.index') }}" class="btn btn-secondary">
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
@endpush
