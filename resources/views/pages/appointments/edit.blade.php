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

		<div class="open {{ $appointment->closed ? 'hide' : '' }}">
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

		<div class="closed {{ ! $appointment->closed ? 'hide' : '' }}">
			<div class="form-group">
				<label for="to">{{ trans('forms.to') }} *</label>
				<div class="input-group date form-group">
					<input type="text" class="form-control" name="to" id="to" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label for="repeat">{{ trans('forms.repeat') }}</label>
				<input type="checkbox" class="form-control" id="repeat" name="repeat" {{ (old('repeat') || $appointment->repeated_id) ? 'checked' : '' }} />
			</div>

			<div class="repeat {{ $appointment->repeated_id ? '' : 'hide' }}">
				<div class="form-group">
					<label for="end">{{ trans('forms.end') }}</label>
					<div class="input-group repeat_date form-group">
						<input type="text" class="form-control" name="end" id="end" />
						<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
					</div>
				</div>
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
		$('.scheduled_at').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', strtotime($appointment->scheduled_at)) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true,
			widgetPositioning: {
				vertical: 'bottom',
				horizontal: 'left'
			}
		});

		$('.date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm',
			defaultDate: moment("{{ date('d/m/Y H:i', $appointment->to ? strtotime($appointment->to) : strtotime('+30 minutes', strtotime($appointment->scheduled_at))) }}", 'DD/MM/YYYY HH:mm'),
			allowInputToggle: true,
			widgetPositioning: {
				vertical: 'bottom',
				horizontal: 'left'
			}
		});

		$('.repeat .repeat_date').datetimepicker({
			format: 'DD-MM-YYYY',
			@if ($appointment->repeat && $appointment->repeat->end)
				defaultDate: moment("{{ date('d/m/Y H:i', strtotime($appointment->repeat->end)) }}", 'DD/MM/YYYY HH:mm'),
			@endif
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

		$('input[name="repeat"]').on('change', function() {
			$('.repeat').toggleClass('hide');
		});
	</script>
@stop
