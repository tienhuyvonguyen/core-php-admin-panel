<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = filter_input(INPUT_GET, 'id');
    $status = 1;
    $client = new Client();
    $request = new Request('GET', BASE_URL . '/api/campaigns/update-campaign-status?id=' . $id . '&status=' . $status);
    $res = $client->sendAsync($request)->wait();
    // alert message
    $_SESSION['info'] = "Campaign approved successfully!";
    header('Location: pending_camp.php');
}
