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
$request = new Request('GET', BASE_URL . '/api/organizations/' . $id, $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
$campList = $response->campaignList;
include_once 'includes/header.php';
?>

<div id="page-wrapper">
    <input type="hidden" name="id" value="<?php echo $response->campId; ?>">
    <div class="row">
        <h2 class="page-header">Organization Details</h2>
    </div>
    <form class="" action="" method="POST" enctype="multipart/form-data" id="contact_form">
        <fieldset>
            <div class="form-group">
                <label for="f_name">Campaign Name</label>
                <input type="text" name="f_name"
                    value="<?php echo htmlspecialchars($response->orgName, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="First Name" class="form-control" required="required" id="f_name" readonly>
            </div>

            <div class="form-group">
                <label>Approval Status</label>
                <label class="radio-inline">
                    <input type="radio" name="status" value="Approved" <?php echo ($response->orgStatus == 1) ? "checked" : ""; ?> required="required" id="Approved" />
                    Approved
                </label>
                <label class="radio-inline">
                    <input type="radio" name="status" value="Denied" <?php echo ($response->orgStatus == 0) ? "checked" : ""; ?> required="required" id="Denied" /> Pending
                </label>
            </div>

            <div class="form-group">
                <label>Create Date </label>
                <input name="date"
                    value="<?php echo htmlspecialchars($response->orgCreateDate, ENT_QUOTES, 'UTF-8'); ?>"
                    class="form-control" type="text" readonly>
            </div>

            <div class="form-group">
                <label for="l_name">Email</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->orgEmail, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>
            <div class="form-group">
                <label for="l_name">Phone</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->orgPhone, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>

            <div>
                <!-- show all organizations campaigns in a table -->
                <h3>Organization Campaigns</h3>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Campaign Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($campList); $i++) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td><a href="camp_detail.php?id=' . $campList[$i]->campId . '">' . $campList[$i]->campName . '</a></td>';
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