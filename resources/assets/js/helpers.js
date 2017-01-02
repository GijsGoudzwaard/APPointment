/**
 * Get cookie by name
 *
 * @param  {String} name
 * @return {String}
 */
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

/**
 * Create a cookie
 *
 * @param {String} name
 * @param {String} value
 * @param {int} days
 */
function createCookie(name, value, days) {
    var date, expires;

    date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();

    document.cookie = name + "=" + value + expires + "; domain=" + getHost();
}

/**
 * Delete cookie by name
 *
 * @param {String} name
 */
function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:01 GMT; domain=." + getHost();
}

/**
 * Get the host without the subdomain
 *
 * @return {String}
 */
function getHost() {
    var host = window.location.hostname;

    return host.split('.').splice(1).join('.');
}

/**
 * A small replacement for the jQuery $ for when jQuery isn't needed
 *
 * @param  {String} selector
 * @param  {Object} context
 * @return {Object}
 */
function elem(selector, context) {
    var query;

    if (context) {
        query = context + ' ' + selector;
    } else {
        query = selector;
    }

    var element = document.querySelectorAll(query);

    if (element.length == 1) {
        return element[0];
    }

    return element;
}

/**
 * An ajax request helper function
 *
 * @param   {Object} options
 * @param   {Function} callback
 * @returns {Function}
 */
function ajax(options, callback) {
    // Set the load animation
    if (options.loader) {
        elem('#loader').className = 'active';
    }

    var xhr = new XMLHttpRequest();
    xhr.open(options.method, options.destination, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            // After request is done remove the loader
            if (options.loader) {
                elem('#loader').className = '';
            }

            return callback(xhr.response);
        }
    };
}

/**
 * List an element from the array
 *
 * @param   {String} element
 * @returns {Array}
 */
Array.prototype.list = function (element) {
    return this.map(function (ctx) {
        return ctx[element];
    });
};
