@extends('layouts.layout', ['page' => 'Create company'])

@section('content')

	<h1>Create company</h1>

	{{ Form::open(['url' => action('CompanyController@store'), 'method' => 'post', 'files' => true]) }}

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
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autofocus required />
				</div>

				<div class="form-group">
					<label for="subdomain">Subdomain</label>
					<input type="text" class="form-control" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" placeholder="Subdomain" required />
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
				</div>

				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Address" required />
				</div>

				<div class="form-group">
					<label for="phonenumber">Phonenumber</label>
					<input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}" placeholder="Phonenumber" required />
				</div>

				<div class="form-group">
					<label for="logo">Logo</label>
					<input type="file" class="form-control" id="logo" name="logo">
				</div>
			</div>

			<div id="opening-hours" class="tab-pane">
				<div class="form-group">
					<div class="form-inline datetimepicker">
						@foreach($days as $key => $day)
							<div class="{{ $key }}">
								<label for="from[{{ $key }}]">
									{{ get_day_name($key) }}
								</label>
								<input type="checkbox" name="enabled[{{ $key }}]" checked />
								<div class="input-group date from form-group">
					                <input type="text" class="form-control picker" id="from[{{ $key }}]" value="{{ old('from[' . $key . ']') }}" name="from[{{ $key }}]" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
								<label for="to[{{ $key }}]">To</label>
								<div class="input-group date to form-group">
					                <input type="text" class="form-control picker" id="to[{{ $key }}]" value="{{ old('to[' . $key . ']') }}" name="to[{{ $key }}]" />
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
