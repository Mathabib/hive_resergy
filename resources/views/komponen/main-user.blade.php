  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
  .task-hover:hover {
    background-color: #f1f5ff;
    transition: background-color 0.2s ease-in-out;
  }

  .card-header.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #3b8bfd);
  }

  .card-footer {
    border-top: 1px solid #eee;
  }

  .list-group-item-action {
    cursor: pointer;
  }

  .badge {
    font-size: 0.75rem;taskk
  }

 
  .card-body-scrollable {
    max-height: 350px;
    overflow-y: auto;
    overflow-x: hidden;
  }

  .card-body-scrollable::-webkit-scrollbar {
    width: 6px;
  }

  .card-body-scrollable::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.15);
    border-radius: 3px;
  }


</style>

  <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
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
        <!-- TODO Tasks -->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-danger">
            <div class="inner">
              <h3>{{ $todoTasks }}</h3>
              <p>Todo Tasks</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <a href="{{ route('tasks.byStatus', ['status' => 'todo']) }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
    <span class="text-light">
        View Todo Tasks <i class="bi bi-arrow-right-circle"></i>
    </span>
</a>
          </div>
        </div>

          <!-- In Progress Tasks -->
          <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
              <div class="inner">
                <h3>{{ $inprogressTasks }}</h3>
                <p>In Progress</p>
              </div>
              <svg
                class="small-box-icon"
                fill="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <path d="M12 2v20M2 12h20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
             <a href="{{ route('tasks.byStatus', ['status' => 'inprogress']) }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
    <span class="text-light">
        View In Progress Tasks <i class="bi bi-arrow-right-circle"></i>
    </span>
</a>
            </div>
          </div>

          <!-- Done Tasks -->
          <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
              <div class="inner">
                <h3>{{ $doneTasks }}</h3>
                <p>Completed Tasks</p>
              </div>
              <svg
                class="small-box-icon"
                fill="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <a href="{{ route('tasks.byStatus', ['status' => 'done']) }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
    <span class="text-light">
        View Completed Tasks <i class="bi bi-arrow-right-circle"></i>
    </span>
</a>
            </div>
          </div>

          <!-- Total Tasks -->
          <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
              <div class="inner">
                <h3>{{ $totalTasks }}</h3>
                <p>Total Tasks</p>
              </div>
              <svg
                class="small-box-icon"
                fill="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
              </svg>
              <a href="{{ route('tasks.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
              <span class="text-light">
                View All Tasks <i class="bi bi-arrow-right-circle"></i>
              </span>
          </a>
            </div>
          </div>
        </div>

            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
              <!-- Start col -->
              <div class="col-lg-7 connectedSortable">
                     <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Task Status Overview</h3></div>
                  <div class="card-body"><div id="revenue-chart"></div></div>
                </div>
                <!-- /.card -->
                <!-- DIRECT CHAT -->
                <!-- <div class="card direct-chat direct-chat-primary mb-4">
               
               
                </div> -->
                </div>
              <!-- /.Start col -->
              <!-- Start col -->

              <!-- notifi assign ask -->

            <div class="col-lg-5 connectedSortable">
              <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                  <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i> Assigned Tasks
                  </h5>

                  <!-- Wrapper kanan -->
                  <div class="d-flex align-items-center position-relative ms-auto">

                    <!-- Lonceng Notifikasi -->
                    <div class="position-relative me-3">
                      <a href="{{ route('tasks.assigned') }}" class="text-white" title="New Assigned Tasks">
                        <i class="fas fa-bell fa-lg"></i>
                      </a>
                      @if($unreadTaskCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          {{ $unreadTaskCount }}
                        </span>
                      @endif
                    </div>

                    <!-- Total Tasks Badge -->
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1" title="Total assigned tasks">
                      {{ $totalAssignedTasks }}
                    </span>
                  </div>
                </div>

                <!-- Scrollable Body -->
                <div class="card-body p-0 card-body-scrollable">
                  @forelse($assignedTasks as $task)
                    <a href="{{ route('tasks.show', $task->id) }}"
                      class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-3 py-3 border-bottom position-relative task-hover"
                      title="{{ $task->nama_task }}">

                      <div class="d-flex align-items-center w-75 text-truncate">
                        {{-- NEW badge jika belum dibaca --}}
                       @php
                        $assignedUser = $task->assignedUsers->firstWhere('id', Auth::id());
                      @endphp

                      @if($assignedUser && $assignedUser->pivot->is_read == 0)
                        <span class="badge bg-danger text-white me-2">NEW</span>
                      @endif

                        {{ Str::limit($task->nama_task, 40) }}
                      </div>

                      <span class="badge bg-light text-dark text-sm px-2 py-1 rounded-pill">
                        {{ ucfirst($task->status) }}
                      </span>
                    </a>
                  @empty
                    <div class="text-center text-muted py-5">
                      <i class="fas fa-check-circle fa-2x mb-2 text-secondary"></i>
                      <p class="mb-0">No tasks assigned</p>
                    </div>
                  @endforelse
                </div>

                <div class="card-footer text-center bg-light rounded-bottom-4">
                  <a href="{{ route('tasks.assigned') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    <i class="fas fa-eye me-1"></i> View My Tasks
                  </a>
                </div>
              </div>
            </div>


              <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const options = {
      series: [
        {
          name: 'Todo',
          data: @json($todoTasksPerMonth),
        },
        {
          name: 'In Progress',
          data: @json($inprogressTasksPerMonth),
        },
        {
          name: 'Done',
          data: @json($doneTasksPerMonth),
        },
      ],
      chart: {
        type: 'area',
        height: 300,
        stacked: false, // ✅ tidak ditumpuk
        toolbar: {
          show: true,
        },
      },
      colors: ['#FF5733', '#FFC300', '#28A745'], // ✅ Warna lebih soft
      stroke: {
        curve: 'smooth', // ✅ garis halus
        width: 2
      },
      dataLabels: {
        enabled: false, // ✅ tidak tampil angka di titik
      },
      xaxis: {
        categories: @json($months),
        title: {
          text: 'Months'
        }
      },
      yaxis: {
        min: 0, // ✅ mulai dari 0
        title: {
          text: 'Number of Tasks'
        },
        labels: {
          formatter: function (val) {
            return Math.round(val); // ✅ biar angka y axis bulat
          }
        }
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function (val) {
            return val + " Tasks"; // ✅ Tooltip jelas
          }
        }
      },
      legend: {
        position: 'top',
        horizontalAlign: 'center'
      }
    };

    const chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
    chart.render();
  });
</script>
