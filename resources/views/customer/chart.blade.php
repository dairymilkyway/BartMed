@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-9">
        <div class="container pt-7">
            <h2 class="text-4xl pb-5 text-center">Customer Registered Per Month</h2>
            <canvas id="customerChart"></canvas>
            <div id="dateDisplay" class="text-center mt-4"></div>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '/api/customer/chartdata',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var ctx = document.getElementById('customerChart').getContext('2d');
                            var customerChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: data.months, // X-axis labels
                                    datasets: [{
                                        label: 'Total Registrations',
                                        data: data.totals, // Y-axis values
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderWidth: 2,
                                        tension: 0.1 // Smooth line
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return `Total Registrations: ${context.raw}`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Month'
                                            },
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Number of Registrations'
                                            },
                                            beginAtZero: true,
                                            grid: {
                                                borderDash: [5, 5]
                                            }
                                        }
                                    }
                                }
                            });

                            // Display the current date below the chart
                            var currentDate = new Date().toLocaleDateString();
                            $('#dateDisplay').text('Date: ' + currentDate);
                        },
                        error: function(xhr) {
                            console.error('Error fetching data:', xhr);
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
