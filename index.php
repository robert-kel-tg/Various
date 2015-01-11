<?php
namespace test1;

use test1\Src\LogDetails;
use test1\Src\User;
use test1\Src\Log;

require 'vendor/autoload.php';

$log_details = new LogDetails();
$log_get_details = $log_details->getDetails(
    new User('Jonas'),
    new Log('metinis')
);

echo '<pre>';die(print_r($log_get_details));echo '</pre>';