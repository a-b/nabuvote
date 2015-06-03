<?php

require_once("functions.php");
require_once("settings.php");

/**
 * @todo debug_error_handler there should be a string, not a constant, anyway it isn't defined
 */
set_error_handler("debug_error_handler");
date_default_timezone_set("Europe/Kiev");

$_ERRORS = array();

/**
 * session starts only if cookie present
 */
if (isset($_COOKIE[session_name()])) {
    session_start();
}

/**
 * if session present check common restrictions
 */
if (!empty($_SESSION) && !check_session_limits()) {
    session_unset();
    session_destroy();
    $_SESSION = array();
}

/**
 * check total post limit
 */
if (!empty($_SESSION) && $_POST) {
    check_and_dec_limit('total_post_limit');
    check_csrf_token();
}

/**
 * verify HTTP Referer only for POST
 */
if (!empty($_SERVER['HTTP_REFERER']) && $_POST) {
    check_request_referer();
}
