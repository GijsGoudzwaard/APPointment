<?php

/**
 * Get the environment based on the user that is logged in
 *
 * @return App\Models\Environment
 */
function get_environment() {
	return User::find(Auth::user()->id)->environment;
}
