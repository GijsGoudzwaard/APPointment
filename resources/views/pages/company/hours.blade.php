@extends('layouts.layout', ['page' => $company->name ?? get_environment()->name])

@section('content')

	<h1>Modify company '{{ $company->name ?? get_environment()->name }}'</h1>

	@if (!empty($company))
		{{ Form::open(['url' => action('CompanyController@update', $company->id), 'method' => 'put', 'files' => true]) }}
	@else
		{{ Form::open(['url' => action('CompanyController@store'), 'method' => 'post', 'files' => true]) }}
	@endif

		<ul class="nav nav-tabs">
			<li role="presentation"><a href="{{ url('company/info') }}">Info</a></li>
			<li role="presentation" class="active"><a href="{{ url('company/hours') }}">Opening hours</a></li>
		</ul>

		<div class="form-group">
			<h3>Opening hours</h3>
			<div class="form-inline datetimepicker">
				@foreach($company->openingHours() as $key => $day)
					<div class="{{ $key }}">
						<label for="from[{{ $key }}]">
							{{ get_day_name($key) }}
						</label>
						<input type="checkbox" name="enabled[{{ $key }}]" checked />
						<div class="input-group date form-group">
			                <input type="text" class="form-control picker from" id="from[{{ $key }}]" value="{{ $day->from ?? '' }}" name="from[{{ $key }}]" />
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
						<label for="to[{{ $key }}]">To</label>
						<div class="input-group date form-group">
			                <input type="text" class="form-control picker to" id="to[{{ $key }}]" value="{{ $day->to ?? '' }}" name="to[{{ $key }}]" />
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
					</div>
				@endforeach
			</div>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
