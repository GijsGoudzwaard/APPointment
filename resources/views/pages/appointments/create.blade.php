@extends('layouts.layout', ['page' => trans('forms.create_a_new') . ' ' . trans('forms.appointment')])

@section('content')

	<h1>{{ trans('forms.create_a_new') }} {{ strtolower(trans('forms.appointment')) }}</h1>

	{{ Form::open(['url' => action('AppointmentController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans('forms.name') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="appointment_type_id">{{ trans('forms.appointment_type') }} *</label>
			{{ Form::select('appointment_type_id', $appointment_types, null, [
				'id' => 'appointment_type_id',
				'class' => 'form-control'
			]) }}
		</div>

		<div class="form-group">
			<label for="user">{{ trans('forms.employee') }} *</label>
			<select name="user" id="user" class="form-control select2">
				@foreach ($users as $id => $user)
					<option value="{{ $id }}">{{ $user }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="scheduled_at">{{ trans('forms.scheduled_at') }} *</label>
			<div class="input-group date form-group">
				<input type="text" class="form-control" name="scheduled_at" id="scheduled_at" />
				<span class="input-group-addon" for="scheduled_at">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>

		<button type="submit" class="btn btn-default">{{ trans('forms.submit') }}</button>
		<a href="{{ route('appointments.index') }}" class="btn btn-default">{{ trans('forms.back') }}</a>

	{{ Form::close() }}

@stop

@section('js')
	<script type="text/javascript">
		$('.date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime($date)) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true
		});
	</script>
@stop
