$(function() {
	var calendar = $('#calendar');

	// To prevent errors when the element doesn't exist
	if (calendar.length > 0) {
		calendar.fullCalendar({
			nowIndicator: true,
			header: {
				left: 'prev, today, next',
				center: 'title',
				right: 'agendaDay, agendaWeek, month'
			},
			defaultView: 'agendaWeek',
			axisFormat: 'HH:mm',
			timeFormat: 'HH:mm',
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
	}

	function getAppointments(start, end) {
		ajax({
			destination: '/appointments/get?start=' + start + '&end=' + end,
			method: 'GET',
			loader: true,
		}, function(res) {
			var data = JSON.parse(res);
			for (var i = 0; i < data.length; i++) {
				var event = {
					id: data[i].id,
					title: data[i].name,
					allDay: false,
					start: data[i].scheduled_at,
					end: data[i].closed ? moment(data[i].to) : moment(data[i].scheduled_at).add(data[i].appointment_type.time, 'minutes'),
					className: ['event']
				}

				if (data[i].closed) {
				    event.className.push('closed');
				}

				calendar.fullCalendar('renderEvent', event);
			}
		});
	}
});
