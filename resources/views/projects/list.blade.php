



@extends('layouts.app')
@section('content')
@include('komponen.navbar_mode')
   <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
          
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
     <div class="card-header d-flex justify-content-between align-items-center w-100">
    <div class="card-title mb-0">List Task</div>
</div>


          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                  <thead class="table-danger">
                    <tr>
                      <th>No</th>
                      <th>Task</th>
                      <th>Status</th>
                      <th>Duration Estimate</th>
                      <th>Start</th>
                      <th>End</th>
                      <th>Priority</th>
                      <th>Assign To</th>


                    </tr>
                  </thead>
                  <tbody>
                 @foreach ( $tasks as $index => $item)
               <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_task }}</td>
                        <td><span class="badge 
                            {{ $item->status == 'todo' ? 'text-bg-secondary' : ($item->status == 'inprogress' ? 'text-bg-warning' : 'text-bg-success') }}">
                            {{ $item->status }}
                        </span></td>
                        <td>{{ $item->estimate }} Hour</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td>{{ $item->priority }}</td>
                        <td>{{ $item->assign_to }}</td>
                        
               
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>

          <!-- Pagination -->
          <div class="card-footer clearfix">
            <!--  -->
          </div>
        </div>
      </div>
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>

        <!--end::App Content-->
      </main>

@endsection