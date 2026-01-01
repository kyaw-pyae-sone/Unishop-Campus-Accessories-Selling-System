@extends('admin.layouts.master');

@section("content")
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Sell Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSaleAmt -> totalAmt }} mmk</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <a href="">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Order Request</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Register
                                    User Count
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $registerCount }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        {{-- Chart Row --}}
        <div class="row px-2">
            <div class="col-12 card mb-4 p-0">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sale Rate within A Year</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height:450px; width:100%">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-6 col-lg-7">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Category Wise Products</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-3 col-lg-3">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Fulfillment Status</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="pt-4">
                            <canvas id="statusDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3">
                <div class="card mx-1 mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Login Preferences</h6>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <canvas id="loginPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Chart Row --}}

    </div>
@endsection

@section("js-script")
    <script type="text/javascript">
        $(document).ready(function() {
            Chart.register(ChartDataLabels);

            $.ajax({
                url : "{{ route("admin#dashboard") }}",
                dataType: "json",
                success : function(res){
                    new Chart(document.getElementById("salesTrendChart"), {
                        type: 'line',
                        data: {
                            labels: res.sales.labels,
                            datasets: [{
                                label: 'Monthly Revenue',
                                data: res.sales.data,
                                fill: true,
                                backgroundColor: 'rgba(52, 152, 219, 0.1)', // Light blue fill
                                borderColor: '#3498db', // Solid blue line
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                                pointBackgroundColor: '#fff',
                                pointBorderWidth: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        drawBorder: false,
                                        color: '#f0f0f0'
                                    },
                                    // ticks: {
                                    //     callback: function(value) {
                                    //         return value.toLocaleString() + ' MMK'; // Adds currency formatting
                                    //     }
                                    // }
                                    ticks: {
                                        callback: function(value) {
                                            return value >= 1000 ? (value / 1000) + 'k MMK' : value + ' MMK';
                                        }
                                    }
                                },
                                x: {
                                    offset: true,
                                    grid: { display: false }
                                },
                                // x: {
                                //     offset: true, // This pushes the 'January' point away from the Y-axis line
                                // },
                                // y: {
                                //     beginAtZero: true,
                                //     suggestedMax: 700000, // Gives more "headroom" so labels don't hit the top
                                // }
                            },
                            plugins: {
                                tooltip: {
                                    backgroundColor: '#2c3e50',
                                    padding: 12,
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 13 },
                                    displayColors: false
                                }
                            }
                        }
                    });
                    new Chart(document.getElementById("categoryPieChart"), {
                        type : "bar",
                        data : {
                            labels : res.categories.labels,
                            datasets : [{
                                    labels: "Total Sales",
                                    data : res.categories.data,
                                    backgroundColor : '#3498db',
                                }
                            ]
                        },
                        options: {
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    // Adds 10% extra space beyond the highest value (2)
                                    // This pushes the chart boundary to 2.2, making room for the text.
                                    grace: '10%',
                                    beginAtZero: true,
                                    grid: { display: false },
                                    ticks: { display: false } // Keeps the clean look
                                },
                                y: {
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'right', // Places the label outside the bar
                                    offset: 5,      // Adds a small 5px gap from the bar tip
                                    color: '#444',
                                    font: { weight: 'bold' }
                                }
                            },
                        }

                    });
                    new Chart(document.getElementById("statusDoughnutChart"), {
                        type: 'doughnut',
                        data: {
                            labels: res.statues.labels,
                            datasets: [{
                                data: res.statues.data,
                                backgroundColor: ['#f1c40f', '#22d1ee', '#c94e4e', '#2ecc71', '#e74c3c'],
                            }]
                        },
                        options: {
                            plugins: {
                                title: { display: true, text: 'Order Fulfillment Status' },
                                legend: { position: 'bottom' },
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        let sum = 0;
                                        let dataArr = ctx.chart.data.datasets[0].data;
                                        dataArr.map(data => { sum += data; });
                                        return (value * 100 / sum).toFixed(0) + "%";
                                    },
                                    color: '#000',
                                }
                            }
                        }
                    });
                    new Chart(document.getElementById("loginPieChart"), {
                        type: 'pie', // Change 'doughnut' to 'pie'
                        data: {
                            labels: ['Simple Login', 'Github Login', 'Google Login'],
                            datasets: [{
                                data: res.logins.data,
                                backgroundColor: [
                                    '#3498db', // Simple Blue
                                    '#24292e', // Github Grey
                                    '#ea4335'  // Google Red
                                ],
                                hoverOffset: 20, // Slices "pop out" more on hover
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'User Login Preferences',
                                    font: { size: 16, weight: 'bold' }
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: {
                                    color: '#fff',
                                    font: { weight: 'bold', size: 14 },
                                    formatter: (value, ctx) => {
                                        let sum = 0;
                                        let dataArr = ctx.chart.data.datasets[0].data;
                                        dataArr.map(data => { sum += data; });
                                        return (value * 100 / sum).toFixed(0) + "%";
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: true, // Change this to TRUE for the Pie Chart only
                            aspectRatio: 1, // This forces it to be a perfect circle
                        }
                    });
                    new Chart(document.getElementById("topProductsChart"), {
                        type: 'bar',
                        data: {
                            labels: res.products.labels, // Product Names
                            datasets: [{
                                label: 'Quantity Sold',
                                data: res.products.data,
                                backgroundColor: '#198754', // Use Success Green
                                borderRadius: 5,
                                barThickness: 20
                            }]
                        },
                        options: {
                            layout: {
                                padding: {
                                    right: 40 // Adds 40px of space on the right
                                }
                            },
                            indexAxis: 'y',
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    grid: { display: false }, // Hide horizontal lines for a cleaner look
                                    ticks: { padding: 10 }    // Move text slightly away from the bars
                                },
                                x: {
                                    beginAtZero: true,
                                    suggestedMax: 22 // Forces the scale to go higher than the bar
                                }
                            },
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'left', // Moves the number "18" inside the green bar
                                    color: '#fff'  // Use white text so it is visible on green
                                }
                            },
                            // This adds the spacing back between bars
                            barThickness: 25,
                            maxBarThickness: 30
                        }
                    });
                }
            });
        });
    </script>
@endsection
