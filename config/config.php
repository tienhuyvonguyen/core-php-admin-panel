<?php

//Note: This file should be included first in every php page.
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'simpleadmin');
// define time zone for the whole application
date_default_timezone_set('Asia/Bangkok');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define('BASE_URL', 'https://exe20240123205125.azurewebsites.net/');
require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/helpers/helpers.php';

