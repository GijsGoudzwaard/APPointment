@extends('layouts.layout', ['page' => $company->name ?? get_environment()->name])

@section('content')

	<h1>Modify company '{{ $company->name ?? get_environment()->name }}'</h1>

	@if (!empty($company))
		{{ Form::open(['url' => action('CompanyController@update', $company->id), 'method' => 'put', 'files' => true]) }}
	@else
		{{ Form::open(['url' => action('CompanyController@store'), 'method' => 'post', 'files' => true]) }}
	@endif

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $company->name ?? get_environment()->name }}" placeholder="Name" autofocus>
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ $company->email ?? '' }}" placeholder="Email">
		</div>

		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" class="form-control" id="address" name="address" value="{{ $company->address ?? '' }}" placeholder="Address">
		</div>

		<div class="form-group">
			<label for="phonenumber">Phonenumber</label>
			<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ $company->phonenumber ?? '' }}" placeholder="Phonenumber">
		</div>

		<div class="form-group">
			<h3>Opening hours</h3>
			<div class="form-inline datetimepicker">
				<?php $days = [
					'mo' => 'Monday',
					'tu' => 'Tuesday',
					'we' => 'Wednesday',
					'thu' => 'Thursday',
					'fr' => 'Friday',
					'sa' => 'Saturday',
					'su' => 'Sunday'
				]; ?>
				@foreach($days as $key => $day)
					<div class="{{ $key }}">
						<label for="from[{{ $key }}]">
							{{ $day }}
						</label>
						<input type="checkbox" name="enabled[{{ $key }}]" checked />
						<div class="input-group date form-group">
			                <input type="text" class="form-control picker from" id="from[{{ $key }}]" name="from[{{ $key }}]" />
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
						<label for="to[{{ $key }}]">To</label>
						<div class="input-group date form-group">
			                <input type="text" class="form-control picker to" id="to[{{ $key }}]" name="to[{{ $key }}]" />
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
					</div>
				@endforeach
			</div>
		</div>

		<div class="form-group">
			<label for="logo">Logo</label>
			<input type="file" class="form-control" id="logo" name="logo">
		</div>

		@if (isset($company->logo))
			<img src="{{ url($company->logo) }}" alt="{{ $company->name }}" class="logo">
		@endif

		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
