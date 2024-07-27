@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-9">
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
                            var backgroundColors = [];
                            var borderColors = [];

                            function getRandomColor(alpha) {
                                var r = Math.floor(Math.random() * 255);
                                var g = Math.floor(Math.random() * 255);
                                var b = Math.floor(Math.random() * 255);
                                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                            }

                            data.forEach(function(brand) {
                                brandNames.push(brand.brand_name);
                                totalSold.push(brand.total_sold);
                                brandDetails[brand.brand_name] = brand.total_sold;

                                backgroundColors.push(getRandomColor(0.2));
                                borderColors.push(getRandomColor(1));
                            });

                            var ctx = document.getElementById('brandSalesChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: brandNames,
                                    datasets: [{
                                        data: totalSold,
                                        backgroundColor: backgroundColors,
                                        borderColor: borderColors,
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
                        },
                        error: function(error) {
                            console.error('Error fetching data', error);
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
