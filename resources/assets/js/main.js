if(getCookie('smallMenu')) {
	$("nav, .topbar, #content").toggleClass("toggle");
}

$(".hamburger-menu").on("click", function() {
	$("nav, .topbar, #content").toggleClass("toggle");

	if(getCookie('smallMenu')) {
		return deleteCookie('smallMenu');
	}

	return createCookie('smallMenu', true, 365);
});


/**
 * Get cookie by name
 *
 * @param String name
 * @return String
 */
function getCookie(name) {
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) return parts.pop().split(";").shift();
}

/**
 * Create a cookie
 *
 * @param String name
 * @param String value
 * @param Int days
 */
function createCookie(name, value, days) {
    var date, expires;

    date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();

    document.cookie = name + "=" + value + expires + "; path=/";
}

/**
 * Delete cookie by name
 *
 * @param  {String} name
 */
function deleteCookie(name) {
	document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
