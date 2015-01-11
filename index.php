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


use Symfony\Component\HttpFoundation\Response;

$response = new Response();
$response->setContent(json_encode(array(
    'User' => (new User('Jonas'))->getName(),
    'Log' => (new Log('metinis'))->getName()
)));
$response->headers->set('Content-Type', 'application/json');
$response->send();