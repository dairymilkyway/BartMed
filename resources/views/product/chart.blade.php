@extends('layouts.master')
@section('content')
<div class="row">
    <!-- Sidenav -->
    @include('layouts.sidenav')
    <!-- Main Content -->
    <div class="col-md-10">
        <div class="container pt-7">
            <h2 class=" text-4xl pb-5 text-center">Products Sold Chart</h2>
            <canvas id="productsChart"></canvas>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '/api/product/chartdata',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var productNames = [];
                            var totalSold = [];
                            
                            data.forEach(function(product) {
                                productNames.push(product.product_name);
                                totalSold.push(product.total_sold);
                            });
            
                            var ctx = document.getElementById('productsChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: productNames,
                                    datasets: [{
                                        label: 'Total Sold Products',
                                        data: totalSold,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 3
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
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
