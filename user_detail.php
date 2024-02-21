<?php
session_start();
require_once './config/config.php';
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
    header('location: all_org.php');
    exit();
}
$client = new Client();
$headers = [
    'Accept' => 'text/plain',
    'Cookie' => 'ARRAffinity=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87; ARRAffinitySameSite=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87'
];
$request = new Request('GET', BASE_URL . '/api/customers/' . $id, $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
$joinedCamp = $response->joinedCampaigns;
include_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Customer Details</h2>
    </div>
    <form class="" action="" method="POST" enctype="multipart/form-data" id="contact_form">
        <fieldset>
            <div class="form-group">
                <label for="f_name">User Name</label>
                <input type="text" name="f_name"
                    value="<?php echo htmlspecialchars($response->custName, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="First Name" class="form-control" required="required" id="f_name" readonly>
            </div>

            <div class="form-group">
                <label>Create Date </label>
                <input name="date"
                    value="<?php echo htmlspecialchars($response->custCreateDate, ENT_QUOTES, 'UTF-8'); ?>"
                    class="form-control" type="text" readonly>
            </div>

            <div class="form-group">
                <label for="l_name">Email</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->custEmail, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>

            <div class="form-group">
                <label for="l_name">Phone</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->custPhone, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>

            <div>
                <!-- show all organizations campaigns in a table -->
                <h3>Joined Campaigns</h3>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Campaign Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($joinedCamp); $i++) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td><a href="camp_detail.php?id=' . $joinedCamp[$i]->campId . '">' . $joinedCamp[$i]->campName . '</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group text-center">
                <label></label>
                <button href="./pending_camp.php" type="submit" class="btn btn-warning">Back <span
                        class="glyphicon glyphicon glyphicon-arrow-left"></span></button>
            </div>
        </fieldset>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>