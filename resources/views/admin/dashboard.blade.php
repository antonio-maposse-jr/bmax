@extends(backpack_view('blank'))

@section('content')
    <div section="before_content" class="row mt-3">

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-3  border-start-0 ">

                <div class="ribbon ribbon-top bg-success ">
                    <i class="la la-user fs-3"></i>
                </div>
                <div class="card-status-start bg-success"></div>
                <div class="card-body">
                    <div class="subheader ">Total Customers.</div>
                    <div class="h1 mb-3 ">{{$totalCustomerNr}}</div>
                    <div class="d-flex mb-2">
                        <div class="card-text ">200 more until next milestone.</div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 10%" role="progressbar" aria-valuenow="10"
                            aria-valuemin="0" aria-valuemax="100" aria-label="10% Complete">
                            <span class="visually-hidden">10% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-3  border-start-0 ">
                <div class="ribbon ribbon-top bg-danger ">
                    <i class="la la-bell fs-3"></i>
                </div>
                <div class="card-status-start bg-danger"></div>
                <div class="card-body">
                    <div class="subheader ">Completed Orders</div>
                    <div class="h1 mb-3 ">{{$productionComplete}}</div>
                    <div class="d-flex mb-2">
                        <div class="card-text ">Great! Don't stop.</div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 60%" role="progressbar" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100" aria-label="60% Complete">
                            <span class="visually-hidden">60% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-3  border-start-0 ">
                <div class="ribbon ribbon-top bg-info ">
                    <i class="la la-star fs-3"></i>
                </div>
                <div class="card-status-start bg-info"></div>
                <div class="card-body">
                    <div class="subheader ">Total Work Time.</div>
                    <div class="h1 mb-3 ">{{$totalWorkTime}}</div>
                    <div class="d-flex mb-2">
                        <div class="card-text ">More than  days</div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: 30%" role="progressbar" aria-valuenow="30"
                            aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                            <span class="visually-hidden">30% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-lg-3">
            <div class="card mb-3  border-start-0 ">
                <div class="ribbon ribbon-top bg-warning ">
                    <i class="la la-lock fs-3"></i>
                </div>
                <div class="card-status-start bg-warning"></div>
                <div class="card-body">
                    <div class="subheader ">Products.</div>
                    <div class="h1 mb-3 ">{{$totalProductNr}}</div>
                    <div class="d-flex mb-2">
                        <div class="card-text ">Try to stay under 75 products.</div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 280%" role="progressbar" aria-valuenow="280"
                            aria-valuemin="0" aria-valuemax="100" aria-label="280% Complete">
                            <span class="visually-hidden">280% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">Montlhy Process values and Volume</div>
                </div>
                <div class="card-body">
                  <canvas id="myChart" width="100" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
          <div class="card">
              <div class="card-header">
                  <div class="card-title mb-0">Process Status</div>
              </div>
              <div class="card-body">
                <canvas id="processStatus" width="100" height="100"></canvas>
              </div>
          </div>
      </div>
    </div>

@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        fetch('/admin/process-chart-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.date);
                const volumeValues = data.map(item => item.volume);
                const valueValues = data.map(item => item.value);

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Volume',
                                data: volumeValues,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Value',
                                data: valueValues,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });


            fetch('/admin/process-status-chart-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.status);
                const counts = data.map(item => item.count);

                var ctx = document.getElementById('processStatus').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Process Status',
                            data: counts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
    </script>
@endsection
