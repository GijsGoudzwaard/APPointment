@extends('layouts.layout', ['page' => $appointment_type->name])

@section('content')

	<h1>Modify appointment type '{{ $appointment_type->name }}'</h1>

	{{ Form::open(['url' => action('AppointmentTypeController@update', $appointment_type), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $appointment_type->name }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="time">Time (minutes) *</label>
			<input type="text" class="form-control" id="time" name="time" value="{{ old('time') ?? $appointment_type->time }}" placeholder="Time" required>
		</div>

		<div class="form-group">
			<label for="price">Price *</label>
			<input type="text" class="form-control" id="price" name="price" value="{{ old('price') ?? $appointment_type->price }}" placeholder="Price" required>
		</div>

		<div class="form-group multiselect">
			<label>Eligible employees *</label>
			@foreach ($employees as $id => $employee)
				<label><input type="checkbox" name="employees[{{ $id }}]" class="form-control" value="{{ old('employees['.$id.']') ?? $id }}" {{ in_array($id, $active_employees) ? 'checked': '' }}>{{ $employee }}</label>
			@endforeach
		</div>

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ route('appointmenttypes.index') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop
