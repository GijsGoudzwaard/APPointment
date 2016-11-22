@extends('layouts.layout')

@section('content')

	<h4>{{ trans('base.total_appointments') }}</h4>

    <div class="charts clearfix">
        <div class="item col-lg-8 col-md-12">
            <canvas id="line"></canvas>
        </div>

        <div class="wrapper col-lg-4 col-md-12">
            <div class="item col-lg-12 col-md-12 col-sm-12">
                <canvas id="doughnut" height="250"></canvas>
            </div>

            <div class="item earnings col-md-12 col-sm-12">
                <h2>{{ trans('base.monthly_income') }}</h2>
                <h3>{{ trans('base.currency') }} <span class="number">0</span><span class="decimal"></span></h3>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="{{ asset('assets/dist/charts/line.js') }}"></script>
    <script src="{{ asset('assets/dist/charts/doughnut.js') }}"></script>
    <script src="{{ asset('assets/dist/charts/income.js') }}"></script>
@stop
