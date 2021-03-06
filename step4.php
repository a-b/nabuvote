<?php

require("system/__init__.php");

require_test_pass('captcha', 'step1.php');
require_test_pass('email',   'step2.php');
require_test_pass('mobile',  'step3.php');
next_if_test_pass('vote',    'step5.php');


/**
 * Handle form data
 */
if ($_POST) {
    $keys = array();
    if (is_array($_POST['id']))
        $keys = array_keys($_POST['id']);
    if (count($keys) < 1) {
        append_error("Ви не обрали жодного кандидата.");
    } elseif (count($keys) > get_selected_limit()) {
        append_error("Ви обрали більше ніж дозволено кандидатів.");
    } else {
        if (safe_save_vote($keys)) {
            set_test_passed('vote');
            redirect('step5.php');
        }
    }
}

require(get_template('step4'));