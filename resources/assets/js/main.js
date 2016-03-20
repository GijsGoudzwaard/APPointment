$(".hamburger-menu").on("click", function() {
	$("nav, .topbar, #content").toggleClass("expanded");

	if(getCookie("smallMenu")) {
		return deleteCookie("smallMenu");
	}

	return createCookie("smallMenu", true, 365);
});
