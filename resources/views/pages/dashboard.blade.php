@extends('layouts.layout', ['page' => null])

@section('content')

	<h1>Hello {{ Auth::user()->firstname }}!</h1>

    <div class="col-md-3">
        <canvas id="doughnut" width="400" height="400"></canvas>
    </div>

@stop

@section('js')
    <script>
        var data = {
            labels: [
                "Red",
                "Green",
                "Yellow"
            ],
            datasets: [
                {
                    data: [300, 50, 100],
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
                }]
        };

        console.log(elem('#doughnut'));
        var myDoughnutChart = new Chart(elem('#doughnut'), {
            type: 'doughnut',
            data: data,
//            options: options
        });
    </script>
@stop