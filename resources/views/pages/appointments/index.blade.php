@extends('layouts.layout', ['page' => 'Appointments'])
@section('content')

	<div id="calendar"></div>

@stop

@section('js')
	<script type="text/javascript">
		$(function() {
			$('#calendar').fullCalendar({
				customButtons: {
			        provider: {
			            text: 'custom!',
			            click: function() {
			                alert('clicked the custom button!');
			            }
			        }
			    },
				header: {
					left: 'provider,month,agendaWeek,agendaDay',
					center: 'prev, title, next',
					right: 'today'
				},
				defaultView: 'agendaWeek',
				height: $(window).height() - $('.topbar').height() - 20,
				views: {
			        week: {
						titleFormat: 'MMM DD'
			        },
			        agendaDay: {
						titleFormat: 'dddd DD'
			        }
			    }
			});
		});
	</script>
@stop
