@extends('layouts.layout', ['page' => null])

@section('content')

	<h1>Hello {{ Auth::user()->firstname }}!</h1>

    <div class="col-md-3 col-sm-3">
        <canvas id="doughnut" width="400" height="400"></canvas>
    </div>

@stop

@section('js')
    <script>
        var data = {
            labels: [
                "data"
            ],
            datasets: [
                {
                    data: [100],
//                    backgroundColor: [
//                        "#FF6384",
//                        "#36A2EB",
//                        "#FFCE56"
//                    ],
//                    hoverBackgroundColor: [
//                        "#FF6384",
//                        "#36A2EB",
//                        "#FFCE56"
//                    ]
                }]
        };

        var doughnutChart = new Chart(elem('#doughnut'), {
            type: 'doughnut',
            data: data,
            animation: {
                animateScale: false
            }
        });

        ajax({
            method: 'GET',
            destination: '/api/appointmenttypes',
            loader: false,
        }, function(res) {
            setDoughnut(JSON.parse(res));
        });

        function setDoughnut(data) {
            doughnutChart.config.data = {
                labels: data.list('name'),
                datasets: [
                    {
                        data: data.list('amount'),
                        backgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56"
                        ],
                        hoverBackgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56"
                        ]
                    }
                ]
            }
            doughnutChart.update();
        }

    </script>
@stop