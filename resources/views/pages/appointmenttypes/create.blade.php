@extends('layouts.layout', ['page' => trans('forms.create_a_new') . ' ' . trans('forms.appointment_type')])

@section('content')

	<h1>{{ trans('forms.create_a_new') }} {{ strtolower(trans('forms.appointment_type')) }}</h1>

	{{ Form::open(['url' => action('AppointmentTypeController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans('forms.name') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="time">{{ trans('forms.time') }} ({{ trans('forms.minutes') }}) *</label>
			<input type="text" class="form-control" id="time" name="time" value="{{ old('time') }}" placeholder="{{ trans('forms.time') }}" required>
		</div>

		<div class="form-group">
			<label for="price">{{ trans('forms.price') }} *</label>
			<input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="{{ trans('forms.price') }}" required>
		</div>

		<div class="form-group multiselect">
			<label for="employees">{{ trans('forms.eligable_employees') }} *</label>
			@foreach ($employees as $id => $employee)
				<label><input type="checkbox" name="employees[{{ $id }}]" class="form-control" value="{{ old('employees['.$id.']') ?? $id }}">{{ $employee }}</label>
			@endforeach
		</div>

		<button type="submit" class="btn btn-primary">{{ trans('forms.submit') }}</button>
		<a href="{{ route('appointmenttypes.index') }}" class="btn btn-default">{{ trans('forms.back') }}</a>

	{{ Form::close() }}

@stop
