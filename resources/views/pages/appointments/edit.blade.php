@extends('layouts.layout', ['page' => trans('forms.edit_an') . ' ' . trans('forms.appointment')])

@section('content')

	<h1>{{ trans('forms.edit_an') }} {{ strtolower(trans('forms.appointment')) }}</h1>
	{{ Form::open(['url' => action('AppointmentController@update', $appointment->id), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $appointment->name }}" placeholder="{{ trans('forms.name') }}" autofocus required />
		</div>

		<div class="form-group">
			<label for="closed">{{ trans('forms.closed') }}</label>
			<input type="checkbox" class="form-control" id="closed" name="closed" value="1" {{ old('closed') || $appointment->closed ? 'checked' : '' }} />
		</div>

		<div class="form-group appointment_type_id">
			<label for="appointment_type_id">{{ trans('forms.appointment_type') }} *</label>
			{{ Form::select('appointment_type_id', $appointment_types, $appointment->appointment_type_id, [
				'id' => 'appointment_type_id',
				'class' => 'form-control select2'
			]) }}
		</div>

		<div class="form-group user_id">
			<label for="user">{{ trans('forms.employee') }} *</label>
			{{ Form::select('user_id', $users, $appointment->user_id, [
				'id' => 'user_id',
				'class' => 'form-control select2'
			]) }}
		</div>

		<div class="form-group">
			<label for="scheduled_at">{{ trans('forms.scheduled_at') }} *</label>
			<div class="input-group date form-group">
				<input type="text" class="form-control" name="scheduled_at" id="scheduled_at" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>

		<button type="submit" class="btn btn-primary">{{ trans('forms.submit') }}</button>
		<a href="{{ route('appointments.index') }}" class="btn btn-default">{{ trans('forms.back') }}</a>
		<a href="javascript:;" data-toggle="modal" class="open-modal btn btn-danger right" data-target="#delete-modal" data-title="{{ $appointment->name }}" data-url="{{ route('appointments.destroy', $appointment->id) }}">{{ trans('forms.delete') }}</a>

	{{ Form::close() }}

	@include('layouts.delete-modal')

@stop

@section('js')
	<script type="text/javascript">
		$('.date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime($appointment->scheduled_at)) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true
		});

		$('input[name="closed"]').on('change', function() {
			$('.appointment_type_id, .user_id').toggle();
		});

		if ($('input[name="closed"]').is(':checked')) {
			$('.appointment_type_id, .user_id').toggle();
		}
	</script>
@stop
