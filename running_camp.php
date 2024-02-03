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
$request = new Request('GET', BASE_URL . '/api/campaigns?page=1&size=100&status=1&name=&location=', $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
include_once BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Running Campaigns</h1>
        </div>
    </div>
    <?php include_once BASE_PATH . '/includes/flash_messages.php'; ?>
    <!-- Filter -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="search_string">Search</label>
            <input type="text" class="form-control" id="search_string" name="search_string"
                value="<?php echo $search_string; ?>">
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <!-- //Filter -->

    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i
                    class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="40%">Campaign Name</th>
                <th width="20%">Host</th>
                <th width="20%">Status</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($response); $i++) {
                echo '<tr>';
                echo '<td>' . $response[$i]->campId . '</td>';
                echo '<td>' . $response[$i]->campName . '</td>';
                echo '<td>' . $response[$i]->campHost . '</td>';
                if ($response[$i]->campStatus == 1) {
                    $response[$i]->campStatus = 'Campaign Running';
                }
                echo '<td>' . $response[$i]->campStatus . '</td>';
                echo '<td>';
                echo '<a href="camp_detail.php?id=' . $response[$i]->campId .'" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a> ';
                echo '</td>';
                echo '</tr>';
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