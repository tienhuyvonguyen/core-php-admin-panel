<?php
require_once './config/config.php';
require 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = filter_input(INPUT_POST, 'username');
	$passwd = filter_input(INPUT_POST, 'passwd');

	$client = new Client();
	$headers = [
		'Content-Type' => 'application/json',
		'Cookie' => 'ARRAffinity=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f; ARRAffinitySameSite=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f'
	];
	$body = '{
  "userName": "' . $username . '",
  "password": "' . $passwd . '"
}';
	$request = new Request('POST', BASE_URL . '/api/customers/login', $headers, $body);
	$res = $client->sendAsync($request)->wait();
	if ($res->getStatusCode() === 200) {
		$response = $res->getBody();
		$response = json_decode($response);
		$_SESSION['user_logged_in'] = TRUE;
		$_SESSION['username'] = $username;
		header('Location: index.php');
	} else {
		$_SESSION['login_failure'] = 'Invalid username or password';
		header('Location:login.php');
	}
	// echo status code
} else {
	die('Method Not allowed');
}