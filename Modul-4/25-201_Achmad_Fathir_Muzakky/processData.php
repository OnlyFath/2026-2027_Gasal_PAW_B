<?php
// 4.3 - tampilkan data form
echo "<h3>Posted Data:</h3>";

foreach ($_POST as $key => $value) {
    echo "($key) => ($value) <br>";
}

// validasi boolean
/*
require 'validate.inc';
if (validateName($_POST, 'surname'))
    echo 'Data OK!';
else
    echo 'Data invalid!';
*/

// validasi detail error
/*
require 'validate.inc';
$errors = array();
validateName($errors, $_POST, 'surname');
if ($errors)
{
    echo 'Errors:<br/>';
    foreach ($errors as $field => $error)
        echo "$field: $error<br/>";
}
else
    echo 'Data OK!';
*/
?>
