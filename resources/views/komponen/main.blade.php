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
              <!--begin::Col-->
 <!-- Total Projects -->
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-light">
                <div class="inner">
                    <h3>{{ $totalProjects }}</h3>
                    <p>Total Projects</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 3.75A.75.75 0 005.25 3h13.5a.75.75 0 01.75.75V6H4.5V3.75zM3.75 7.5h16.5v12a.75.75 0 01-.75.75H4.5a.75.75 0 01-.75-.75v-12z"></path>
                </svg>
               <a href="{{ route('projects.index2') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                <span class="text-dark">
    View All Projects <i class="bi bi-arrow-right-circle"></i>
                </span>
              </a>

            </div>
        </div>

        <!-- Total Tasks -->
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-light">
                <div class="inner">
                    <h3>{{ $totalTasks }}</h3>
                    <p>Total Tasks</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3.75A.75.75 0 013.75 3h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 3.75zm0 4.5A.75.75 0 013.75 7.5h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 8.25z"></path>
                </svg>
               <a href="{{ route('tasks.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
              <span class="text-dark">
                View All Tasks <i class="bi bi-arrow-right-circle"></i>
              </span>
          </a>

            </div>
        </div>

        <!-- Total Users -->
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-light">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.75 5.25a3 3 0 116 0 3 3 0 01-6 0zM4.5 14.25a3.75 3.75 0 017.5 0v1.5H4.5v-1.5z"></path>
                </svg>
                <a href="{{ route('users.index') }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                <span class="text-dark">
                    View All Users <i class="bi bi-arrow-right-circle"></i>
                </span>
              </a>

            </div>
        </div>

        <!-- Active Tasks -->
       <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 4-->
    <div class="small-box text-bg-light">
        <div class="inner">
            <h3>{{ $activeUsersToday }}</h3>
            <p>Active Users Today</p>
        </div>
        <svg
            class="small-box-icon"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
            ></path>
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
            ></path>
        </svg>
        <a href="{{ route('users.activeToday') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          <span class="text-dark">
           View Today's Active Users <i class="bi bi-arrow-right-circle"></i>

          </span>
</a>

    </div>
    <!--end::Small Box Widget 4-->
</div>

              <!--end::Col-->
            </div>

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
      <a
        href="#"
        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        <!-- More info <i class="bi bi-link-45deg"></i> -->
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
      <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        <!-- More info <i class="bi bi-link-45deg"></i> -->
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
      <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        <!-- More info <i class="bi bi-link-45deg"></i> -->
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
      <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
      >
        <!-- More info <i class="bi bi-link-45deg"></i> -->
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
                <!-- /.direct-chat -->
              </div>
              <!-- /.Start col -->
              <!-- Start col -->
              <!-- <div class="col-lg-5 connectedSortable">
               
            </div> -->
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

