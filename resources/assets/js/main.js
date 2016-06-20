$(".hamburger-menu").on("click", function() {
	$("nav, .topbar, #content").toggleClass("expanded");

	if(getCookie("smallMenu")) {
		return deleteCookie("smallMenu");
	}

	return createCookie("smallMenu", true, 365);
});

$('.open-modal').on('click', function() {
	$('.modal .text').text($(this).data('title'));
	$('.modal form').attr('action', $(this).data('url'));
});