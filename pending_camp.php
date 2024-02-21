<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;


$client = new Client();
$headers = [
    'Accept' => 'text/plain',
    'Cookie' => 'ARRAffinity=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87; ARRAffinitySameSite=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87'
];
$request = new Request('GET', BASE_URL . '/api/campaigns', $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
include_once BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Pending Campaigns</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_camp.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>
    <?php include_once BASE_PATH . '/includes/flash_messages.php'; ?>

    <!-- Filter -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="search_string">Search</label>
            <input type="text" class="form-control" id="search_string" name="search_string">
            <input type="submit" value="Go" class="btn btn-primary">
            <?php $search_string = filter_input(INPUT_GET, 'search_string'); ?>
        </form>
    </div>

    <!-- Export -->
    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i
                    class="glyphicon glyphicon-export"></i></button></a>
    </div>
    <!-- //Export -->

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="20%">Campaign Name</th>
                <th width="10%">Host</th>
                <th width="10%">Location</th>
                <th width="10%">Create Date</th>
                <th width="10%">Status</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($response); $i++) {
                if ($response[$i]->campStatus == 1) {
                    continue;
                }
                if ($search_string && !stristr($response[$i]->campName, $search_string)) {
                    continue;
                }
                echo '<tr>';
                echo '<td>' . $response[$i]->campId . '</td>';
                echo '<td>' . $response[$i]->campName . '</td>';
                echo '<td>' . $response[$i]->campHost . '</td>';
                echo '<td>' . $response[$i]->campLocation . '</td>';
                echo '<td>' . $response[$i]->campCreateDate . '</td>';
                if ($response[$i]->campStatus == 0) {
                    $response[$i]->campStatus = 'Pending Approval';
                }
                echo '<td>' . $response[$i]->campStatus . '</td>';
                echo '<td>';
                echo '<a href="camp_detail.php?id=' . $response[$i]->campId . '"class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a> ';
                echo '<a href="valid_camp.php?id=' . $response[$i]->campId . '" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a> ';
                echo '<a href="remove_camp.php?id=' . $response[$i]->campId . '" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a> ';
                // alert message approved successfully
                if (isset($_SESSION['info'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['info'] . '</div>';
                    unset($_SESSION['info']);
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <!-- //Table -->
</div>
<!-- //Main container -->
<?php include_once BASE_PATH . '/includes/footer.php'; ?>