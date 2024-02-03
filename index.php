<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

//Get Dashboard information
include_once('includes/header.php');
$client = new Client();
$headers = [
    'Accept' => 'text/plain',
    'Cookie' => 'ARRAffinity=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87; ARRAffinitySameSite=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87'
];
$request = new Request('GET', BASE_URL . '/api/campaigns?page=1&size=100&status=0&name=&location=', $headers);
$res = $client->sendAsync($request)->wait();
$pendingCamp = 0;
if ($res->getStatusCode() === 200) {
    $response = $res->getBody();
    $response = json_decode($response);
    $pendingCamp = count($response);
} else {
    $pendingCamp = 0;
}
$client = new Client();
$headers = [
    'Accept' => 'text/plain',
    'Cookie' => 'ARRAffinity=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87; ARRAffinitySameSite=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87'
];
$request = new Request('GET', BASE_URL . '/api/campaigns?page=1&size=100&status=1&name=&location=', $headers);
$res = $client->sendAsync($request)->wait();
$runningCamp = 0;
if ($res->getStatusCode() === 200) {
    $response = $res->getBody();
    $response = json_decode($response);
    $runningCamp = count($response);
} else {
    $runningCamp = 0;
}
$client = new Client();
$headers = [
    'Accept' => 'text/plain'
];
$request = new Request('GET', BASE_URL . '/api/organizations', $headers);
$res = $client->sendAsync($request)->wait();
if ($res->getStatusCode() === 200) {
    $response = $res->getBody();
    $response = json_decode($response);
    $organizations = count($response);
} else {
    $organizations = 0;
}


?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Admin Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php echo $pendingCamp; ?>
                            </div>
                            <div>Pending Campaigns</div>
                        </div>
                    </div>
                </div>
                <a href="pending_camp.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php echo $runningCamp ?>
                            </div>
                            <div>Running Campaigns</div>
                        </div>
                    </div>
                </div>
                <a href="running_camp.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php echo $organizations; ?>
                            </div>
                            <div> Organizations</div>
                        </div>
                    </div>
                </div>
                <a href="all_org.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">

        </div>
        <div class="col-lg-3 col-md-6">

        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>