$('.open-modal').on('click', function() {
	$('.modal .text').text($(this).data('title'));
	$('.modal form').attr('action', $(this).data('url'));
});

$('.select2').select2({
	placeholder: function(){
		$(this).data('placeholder');
	}
});

elem('.language-switcher').addEventListener('click', function() {
	this.classList.toggle('active');
});
