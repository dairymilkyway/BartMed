@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-10">
        <div class="container pt-7">
            <h2 class="text-4xl pb-5 text-center">Brand Sales Chart</h2>
            <canvas id="brandSalesChart"></canvas>
            <div id="brandDetails" class="mt-5">
                <!-- Brand details will be inserted here by JavaScript -->
            </div>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '/api/brand/chartdata',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var brandNames = [];
                            var totalSold = [];
                            var brandDetails = {};

                            data.forEach(function(brand) {
                                brandNames.push(brand.brand_name);
                                totalSold.push(brand.total_sold);

                                brandDetails[brand.brand_name] = brand.total_sold;
                            });

                            var ctx = document.getElementById('brandSalesChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: brandNames,
                                    datasets: [{
                                        data: totalSold,
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
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: 'Total Pieces Products Sold by Brand'
                                        }
                                    }
                                }
                            });
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
