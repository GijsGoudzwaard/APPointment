@extends('layouts.layout', ['page' => 'Appointments'])
@section('content')

	<div id="calendar"></div>

@stop

@section('js')
	<script type="text/javascript">
		$(function() {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev, today, next',
					center: 'title',
					right: 'agendaDay, agendaWeek, month'
				},
				defaultView: 'agendaWeek',
				height: $(window).height() - $('.topbar').height() - 20 {{ env('APP_DEBUG', false) ? ' - 30' : '' }},
				views: {
			        week: {
						titleFormat: 'MMM DD'
			        },
			        agendaDay: {
						titleFormat: 'dddd DD'
			        }
			    },
				dayClick: function(date, jsEvent, view) {
					window.location.href = "{{ url('appointments/create?date=') }}" + moment(date).unix();
				}
			});
		});
	</script>
@stop
