@extends('layouts.layout', ['page' => $company->name ?? get_environment()->name])

@section('content')

	<h1>Modify company '{{ $company->name ?? get_environment()->name }}'</h1>

	{{ Form::open(['url' => action('CompanyController@update', $company->id), 'method' => 'put', 'files' => true]) }}

		<ul class="nav nav-tabs" id="guide-tabs">
			<li class="active">
				<a href="#info" data-toggle="tab">Info</a>
			</li>
			<li>
				<a href="#opening-hours" data-toggle="tab">Opening hours</a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="info" class="tab-pane active">
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
					<label for="logo">Logo</label>
					<input type="file" class="form-control" id="logo" name="logo">
				</div>

				@if (isset($company->logo))
					<img src="{{ url($company->logo) }}" alt="{{ $company->name }}" class="logo">
				@endif
			</div>

			<div id="opening-hours" class="tab-pane">
				<div class="form-group">
					<div class="form-inline datetimepicker">
						@foreach($company->days as $key => $day)
							<div class="{{ $key }}">
								<label for="from[{{ $key }}]">
									{{ get_day_name($key) }}
								</label>
								<input type="checkbox" name="enabled[{{ $key }}]" {{ (isset($company->openingHours()->$key)) ? 'checked' : '' }} />
								<div class="input-group date form-group">
					                <input type="text" class="form-control picker from" id="from[{{ $key }}]" value="{{ $company->openingHours()->$key->from ?? '' }}" name="from[{{ $key }}]" {{ (!isset($company->openingHours()->$key)) ? 'disabled' : '' }} />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
								<label for="to[{{ $key }}]">To</label>
								<div class="input-group date form-group">
					                <input type="text" class="form-control picker to" id="to[{{ $key }}]" value="{{ $company->openingHours()->$key->to ?? '' }}" name="to[{{ $key }}]" {{ (!isset($company->openingHours()->$key)) ? 'disabled' : '' }} />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
							</div>
						@endforeach
					</div>
				</div>
			</div>

		</div>
		<button type="submit" class="btn btn-default">Submit</button>

	{{ Form::close() }}

@stop
