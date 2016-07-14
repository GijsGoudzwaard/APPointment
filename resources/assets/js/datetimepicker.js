$('.datetimepicker input[type="checkbox"]').on("click", function() {
	var picker = elem('.picker', '.' + this.parentNode.className);

	for (var i = 0; i < picker.length; i++) {
		var attr = picker[i].getAttribute("disabled");

		if (attr || attr === '') {
			picker[i].removeAttribute("disabled");
		} else {
			picker[i].setAttribute("disabled", true);
		}
	}
});

// To prevent errors when the element doesn't exist
if ($('.date.from').length > 0) {
	$('.date.from').datetimepicker({
		format: 'HH:mm',
		defaultDate: moment('08:00', 'HH:mm'),
		allowInputToggle: true
	});
}

// To prevent errors when the element doesn't exist
if ($('.date.to').length > 0) {
	$('.date.to').datetimepicker({
		format: 'HH:mm',
		defaultDate: moment('17:00', 'HH:mm'),
		allowInputToggle: true
	});
}
