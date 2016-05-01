@extends('layouts.layout', ['page' => 'Create new appointment type'])

@section('content')

	<h1>Create a new appointment</h1>

	{{ Form::open(['url' => action('AppointmentController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">Name *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autofocus required>
		</div>

		<div class="form-group">
			<label for="appointment_type_id">Appointment type *</label>
			{{ Form::select('appointment_type_id', $appointment_types, null, [
				'id' => 'appointment_type_id',
				'class' => 'form-control'
			]) }}
		</div>

		<div class="form-group">
			<label for="scheduled_at">Scheduled at *</label>
			<div class="input-group form-group">
				<input type="text" class="form-control" name="scheduled_at" id="scheduled_at" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>
		<a href="{{ url('appointments') }}" class="btn btn-default">Back</a>

	{{ Form::close() }}

@stop

@section('js')
	<script type="text/javascript">
		$('#scheduled_at').datetimepicker({
			format: 'YYYY-MM-DD HH:mm',
			defaultDate: "{{ date('m/d/Y H:i', strtotime($date)) }}"
		});
	</script>
@stop
