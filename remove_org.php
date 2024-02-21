<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = filter_input(INPUT_GET, 'id');
    $client = new Client();
    $request = new Request('GET', BASE_URL . '/api/organizations/delete/' . $id);
    $res = $client->sendAsync($request)->wait();
    // alert message
    $_SESSION['info'] = "Remove organization successfully!";
    header('Location: pending_org.php');
}
