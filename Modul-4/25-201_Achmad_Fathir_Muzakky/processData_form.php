<?php
require 'validate.inc';

$errors = array();

if (isset($_POST['submit']))
{
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    
    if ($errors)
    {
        foreach ($errors as $field => $error)
            echo "$field: $error<br />";
        echo "<hr />";
        // tampilkan kembali form
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    // tampilkan kembali form
    include 'form.inc';
}
?>
