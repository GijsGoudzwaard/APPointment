$('.datetimepicker input[type="checkbox"]').on("click", function() {
	var picker = elem('.picker', '.' + this.parentNode.className);
	for (var i = 0; i < picker.length; i++) {
		var attr = picker[i].getAttribute("disabled");
		if (attr) {
			picker[i].removeAttribute("disabled");
		} else {
			picker[i].setAttribute("disabled", true);
		}
	}
});

$('.date .from').datetimepicker({
	format: 'HH:mm',
	defaultDate: moment('08:00', 'HH:mm')
});

$('.date .to').datetimepicker({
	format: 'HH:mm',
	defaultDate: moment('17:00', 'HH:mm')
});
