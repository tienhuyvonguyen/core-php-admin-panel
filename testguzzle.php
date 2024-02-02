<?php
require_once './config/config.php';
require 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

$username = "adminadmin";
$passwd = "adminadmin";


$client = new Client();
$headers = [
  'Content-Type' => 'application/json'
];
$body = '{
  "userName": "' . $username . '",
  "password": "' . $passwd . '"
}';
$request = new Request('POST', 'https://exe20240123205125.azurewebsites.net/api/customers/login', $headers, $body);
$res = $client->sendAsync($request)->wait();
$response = $res->getBody();
// echo status code 
echo $res->getStatusCode();
$response = json_decode($response);
echo $response;