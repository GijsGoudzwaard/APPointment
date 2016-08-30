@extends('layouts.layout', ['page' => trans('forms.create_a_new') . ' ' . trans('forms.appointment')])

@section('content')

	<h1>{{ trans('forms.create_a_new') }} {{ strtolower(trans('forms.appointment')) }}</h1>

	{{ Form::open(['url' => action('AppointmentController@store'), 'method' => 'post']) }}

		<div class="form-group">
			<label for="name">{{ trans('forms.name') }} *</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans('forms.name') }}" autofocus required>
		</div>

		<div class="form-group">
			<label for="closed">{{ trans('forms.closed') }}</label>
			<input type="checkbox" class="form-control" id="closed" name="closed" value="1" {{ old('closed') ? 'checked' : '' }} />
		</div>

		<div class="open">
			<div class="form-group appointment_type_id">
				<label for="appointment_type_id">{{ trans('forms.appointment_type') }} *</label>
				{{ Form::select('appointment_type_id', $appointment_types, null, [
					'id' => 'appointment_type_id',
					'class' => 'form-control select2'
				]) }}
			</div>

			<div class="form-group user_id">
				<label for="user">{{ trans('forms.employee') }} *</label>
				{{ Form::select('user_id', $users, null, [
					'id' => 'user_id',
					'class' => 'form-control select2'
				]) }}
			</div>
		</div>

		<div class="form-group">
			<label for="scheduled_at">{{ trans('forms.scheduled_at') }} *</label>
			<div class="input-group date scheduled_at form-group">
				<input type="text" class="form-control" name="scheduled_at" id="scheduled_at" />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>

		<div class="closed hide">
			<div class="form-group">
				<label for="to">{{ trans('forms.to') }} *</label>
				<div class="input-group date form-group">
					<input type="text" class="form-control" name="to" id="to" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary">{{ trans('forms.submit') }}</button>
		<a href="{{ route('appointments.index') }}" class="btn btn-default">{{ trans('forms.back') }}</a>

	{{ Form::close() }}

@stop

@section('js')
	<script type="text/javascript">
		$('.scheduled_at').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime($date)) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true,
			widgetPositioning: {
				vertical: 'bottom',
				horizontal: 'left'
			}
		});

		$('.date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime('+30 minutes', strtotime($date))) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true,
			widgetPositioning: {
				vertical: 'bottom',
				horizontal: 'left'
			}
		});

		$('input[name="closed"]').on('change', function() {
			var context;

			if (! $(this).is(':checked')) {
				context = $('.open');
				$('.closed').toggle();
			} else {
				context = $('.closed');
				$('.open').toggle();
			}

			if (context.hasClass('hide')) {
				context.removeClass('hide');

				// Reinitalize the select2 to fix the broken styles
				$('.select2').select2({
					placeholder: function(){
						$(this).data('placeholder');
					}
				});
			} else {
				context.toggle();
			}
		});
	</script>
@stop
