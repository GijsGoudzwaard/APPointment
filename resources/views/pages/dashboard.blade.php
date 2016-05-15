@extends('layouts.layout', ['page' => null])

@section('content')

	<h1>Hello {{ Auth::user()->firstname }}!</h1>

    <div class="charts">
        {{--<div class="item col-md-12">--}}
            {{--<canvas id="line" width="400" height="400"></canvas>--}}
        {{--</div>--}}

        <div class="item col-md-4 col-sm-4">
            <canvas id="doughnut" width="400" height="400"></canvas>
        </div>
    </div>

@stop

@section('js')
    <script src="{{ asset('assets/dist/charts/line.js') }}"></script>
    <script src="{{ asset('assets/dist/charts/doughnut.js') }}"></script>
@stop