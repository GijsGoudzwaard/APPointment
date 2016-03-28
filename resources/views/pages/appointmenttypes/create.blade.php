@extends('layouts.layout', ['page' => 'Create new appointment type'])

@section('content')

	<h1>Create new appointment type</h1>

	{{ Form::open(['url' => action('AppointmentTypeController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="time">Time (minutes) *</label>
			<input type="text" class="form-control" id="time" name="time" value="{{ old('time') }}" placeholder="Time" required>
		</div>

		<div class="form-group">
			<label for="price">Price *</label>
			<input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Price" required>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('appointmenttypes') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop
