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
    return '';
}

function old($name, $default = null)
{
    if (isset($_POST[$name])) {
        echo sanitize($_POST[$name]);
    }

    echo $default;
}
