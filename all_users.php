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
$request = new Request('GET', BASE_URL . '/api/customers?page=1&size=100', $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
include_once BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">All Customers</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_user.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
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

    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i
                    class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="40%">Customer Name</th>
                <th width="20%">Customer Email</th>
                <th width="20%">Status</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($response); $i++) {
                if ($search_string && !stristr($response[$i]->custName, $search_string)) {
                    continue;
                }
                echo '<tr>';
                echo '<td>' . $response[$i]->custId . '</td>';
                echo '<td>' . $response[$i]->custName . '</td>';
                echo '<td>' . $response[$i]->custEmail . '</td>';
                echo '<td>' . $response[$i]->custStatus . '</td>';
                echo '<td>';
                echo '<a href="org_detail.php?id=' . $response[$i]->custId . '" class="btn btn-primary">View</a>';
                echo '</td>';
                echo '</tr>';
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['failure'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['failure'] . '</div>';
                    unset($_SESSION['failure']);
                }
            }
            ?>
        </tbody>
    </table>
    <!-- //Table -->
    <!-- Pagination -->
</div>
<!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include_once BASE_PATH . '/includes/footer.php'; ?>