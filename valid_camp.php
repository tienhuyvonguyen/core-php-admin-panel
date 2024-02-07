<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = filter_input(INPUT_GET, 'id');
} else {
    $id = filter_input(INPUT_POST, 'id');
}
if (empty($id)) {
    header('location: pending_camp.php');
    exit();
}


