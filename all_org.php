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
    'Cookie' => 'ARRAffinity=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f; ARRAffinitySameSite=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f'
];
$request = new Request('GET', BASE_URL . '/api/organizations', $headers);
$response = $client->sendAsync($request)->wait();
$response = json_decode($response->getBody()->getContents());
include_once BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">All Organizations</h1>
        </div>
    </div>
    <?php include_once BASE_PATH . '/includes/flash_messages.php'; ?>


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
                <th width="35%">Organization Name</th>
                <th width="10%">Organization Email</th>
                <th width="10%">Organization Phone</th>

                <th width="10%">Status</th>
                <th width="6%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($response); $i++) {
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
                echo '<a href="org_camp_detail.php?id=' . $response[$i]->orgId . '" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a> ';
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