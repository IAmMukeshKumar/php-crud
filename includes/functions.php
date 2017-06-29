<?php
/**
 * @param $input
 * @return string
 */

function sanitize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;

}

function getError($name)
{
    global $errors;
    if (isset($errors[$name])) {
        return $errors[$name];
    }
    return null;
}

function old($name, $default = null)
{
    if (isset($_POST[$name])) {
        return sanitize($_POST[$name]);
    }

    return $default;
}

// Function for creating random password

//function random_password($size) {
//
//    $alpha_key = '';
//    $keys = range('A', 'Z');
//
//    for ($i = 0; $i < 2; $i++) {
//        $alpha_key .= $keys[array_rand($keys)];
//    }
//
//    $length = $size - 6;
//
//    $key = '';
//    $keys = range(0, 9);
//
//    for ($i = 0; $i < $length; $i++) {
//        $key .= $keys[array_rand($keys)];
//    }
//
//    $alpha_key_2_last = '';
//    $keys = range('A', 'Z');
//
//    for ($i = 0; $i < 2; $i++) {
//        $alpha_key_2_last .= $keys[array_rand($keys)];
//    }
//
//
//    $alpha_key_last = '';
//    $keys = range(0, 9);
//
//    for ($i = 0; $i < 2; $i++) {
//        $alpha_key_last .= $keys[array_rand($keys)];
//    }
//
//    return $alpha_key . $key . $alpha_key_2_last . $alpha_key_last;
//}
