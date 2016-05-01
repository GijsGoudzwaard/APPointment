@extends('layouts.layout', ['page' => 'Appointments'])
@section('content')

	<div id="calendar"></div>

@stop

@section('js')
	<script type="text/javascript">
		$(function() {
			var calendar = $('#calendar');
			calendar.fullCalendar({
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
				},
				viewRender: function(view, element) {
					getAppointments(moment(view.start).unix(), moment(view.end).unix());
				}
			});

			function getAppointments(start, end) {
				$('#loader').fadeIn();
				$.ajax({
					url: "/appointments/get?start=" + start + "&end=" + end,
					type: 'GET',
					success: function(data) {
						for (var i = 0; i < data.length; i++) {
							calendar.fullCalendar('renderEvent', {
								title: data[i].name,
								allDay: false,
								start: data[i].scheduled_at,
								end: moment(data[i].scheduled_at).add(data[i].appointment_type.time, 'minutes')
							});
						}
						$('#loader').fadeOut();
					},
					error: function(data) {
						console.log(data);
						$('#loader').fadeOut();
					}
				});
			}
		});
	</script>
@stop
