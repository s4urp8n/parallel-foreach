<?php
ob_implicit_flush(true);
ini_set('implicit_flush', 1);
error_reporting(E_ALL);

echo passthru('phpunit --bootstrap="tests/bootstrap.php"');