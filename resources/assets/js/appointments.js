$(function() {
	var calendar = $('#calendar');
	var start_date, end_date;

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
				start_date = moment(view.start).unix();
				end_date = moment(view.end).unix();

				getAppointments(moment(view.start).unix(), moment(view.end).unix(), true);
			}
		});

		// Refresh the appointments every 5 minutes
		// Do not show the load indicator seeing as it is a 'background' process
		setInterval(function() {
			getAppointments(start_date, end_date, false);
		}, 3000000);
	}

	function getAppointments(start, end, loader) {
		if (loader) {
            elem('#loader').className = 'active';
        }

		$.get({
            url: '/appointments/get?start=' + start + '&end=' + end,
            dataType: 'html',
        }).done(function (res) {
			var data = JSON.parse(res);

			// Remove all events so we won't get any duplicates
			calendar.fullCalendar('removeEvents');

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

				if (loader) {
					elem('#loader').className = '';
				}
			}
        });
	}
});
