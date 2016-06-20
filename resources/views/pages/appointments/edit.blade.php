@extends('layouts.layout', ['page' => 'Create new appointment type'])

@section('content')

	<h1>Create a new appointment</h1>

	{{ Form::open(['url' => action('AppointmentController@update', $appointment->id), 'method' => 'put']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $appointment->name }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="appointment_type_id">Appointment type *</label>
			{{ Form::select('appointment_type_id', $appointment_types, $appointment->appointment_type_id, [
				'id' => 'appointment_type_id',
				'class' => 'form-control'
			]) }}
		</div>

		<div class="form-group">
			<label for="scheduled_at">Scheduled at *</label>
			<div class="input-group date form-group">
				<input type="text" class="form-control" name="scheduled_at" id="scheduled_at" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('appointments') }}" class="btn btn-default">Back</a>
		<a href="{{ url('appointments/' . $appointment->id . '/delete') }}" class="btn btn-danger right">Delete</a>

	{{ Form::close() }}

@stop

@section('js')
	<script type="text/javascript">
		$('.date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime($appointment->scheduled_at)) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true
		});
	</script>
@stop
