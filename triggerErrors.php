<?php
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../private/php-errors.log');

echo "<h1>Testing Error Logging</h1>";
$calculation = $undefined_variable + 10;
include('missing_file.php');
non_existent_function();