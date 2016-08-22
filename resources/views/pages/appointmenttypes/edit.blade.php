@extends('layouts.layout', ['page' => $appointment_type->name])

@section('content')

	<h1>{{ trans('forms.modify') }} '{{ $appointment_type->name }}'</h1>

	{{ Form::open(['url' => action('AppointmentTypeController@update', $appointment_type), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $appointment_type->name }}" placeholder="{{ trans('forms.name') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="time">{{ trans('forms.time') }} ({{ trans('forms.minutes') }}) *</label>
			<input type="text" class="form-control" id="time" name="time" value="{{ old('time') ?? $appointment_type->time }}" placeholder="{{ trans('forms.time') }}" required>
		</div>

		<div class="form-group">
			<label for="price">{{ trans('forms.price') }} *</label>
			<input type="text" class="form-control" id="price" name="price" value="{{ old('price') ?? $appointment_type->price }}" placeholder="Price" required>
		</div>

		<div class="form-group multiselect">
			<label for="employees">{{ trans('forms.eligable_employees') }} *</label>
			{{ Form::select('employees[]', $employees, $active_employees, [
				'class' => 'form-control select2',
				'id' => 'employees',
				'data-placeholder' => trans('forms.select_employees'),
				'multiple' => true
			]) }}
		</div>

		<button type="submit" class="btn btn-default">{{ trans('forms.submit') }}</button>
		<a href="{{ route('appointmenttypes.index') }}" class="btn btn-default">{{ trans('forms.back') }}</a>

	{{ Form::close() }}

@stop
