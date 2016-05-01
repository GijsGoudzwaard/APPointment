$(function() {
	var calendar = $('#calendar');
	calendar.fullCalendar({
		header: {
			left: 'prev, today, next',
			center: 'title',
			right: 'agendaDay, agendaWeek, month'
		},
		defaultView: 'agendaWeek',
		height: $(window).height() - $('.topbar').height() - 20 - $('.phpdebugbar').height(),
		views: {
			week: {
				titleFormat: 'MMM DD'
			},
			agendaDay: {
				titleFormat: 'dddd DD'
			}
		},
		dayClick: function(date, event, view) {
			window.location.href = "/appointments/create?date=" + moment(date).unix();
		},
		eventClick: function(date, event, view) {
			window.location.href = "/appointments/" + date.id + "/edit";
		},
		viewRender: function(view, element) {
			// Remove all events so we won't get any duplicates
			calendar.fullCalendar('removeEvents');
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
						id: data[i].id,
						title: data[i].name,
						allDay: false,
						start: data[i].scheduled_at,
						end: moment(data[i].scheduled_at).add(data[i].appointment_type.time, 'minutes'),
						// color: '#000'
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
