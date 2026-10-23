<?php
function validateName(&$errors, $list, $name)
{
    if (empty($list[$name]))
        $errors[$name] = 'required';
    elseif (!preg_match("/^[a-zA-Z'-]+$/", $list[$name]))
        $errors[$name] = 'invalid';
}

function validateEmail(&$errors, $list, $name)
{
    if (empty($list[$name]))
        $errors[$name] = 'required';
    elseif (!filter_var($list[$name], FILTER_VALIDATE_EMAIL))
        $errors[$name] = 'invalid';
}

function validateAddress(&$errors, $list, $name)
{
    if (empty($list[$name]))
        $errors[$name] = 'required';
}

function validateState(&$errors, $list, $name)
{
    if (empty($list[$name]))
        $errors[$name] = 'required';
}
?>
