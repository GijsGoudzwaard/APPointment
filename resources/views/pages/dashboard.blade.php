@extends('layouts.layout', ['page' => null])

@section('content')

	<h4>Total appointments</h4>

    <div class="charts clearfix">
        <div class="item">
            <canvas id="line" width="500" height="200"></canvas>
        </div>

        <div class="item col-md-4 col-sm-4">
            <canvas id="doughnut" width="400" height="400"></canvas>
        </div>
    </div>

@stop

@section('js')
    <script src="{{ asset('assets/dist/charts/line.js') }}"></script>
    <script src="{{ asset('assets/dist/charts/doughnut.js') }}"></script>
@stop