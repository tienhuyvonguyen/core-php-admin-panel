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
    header('location: pending_camp.php');
    exit();
}
$client = new Client();
$headers = [
    'Accept' => 'text/plain',
    'Cookie' => 'ARRAffinity=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87; ARRAffinitySameSite=36ae3f6c623e7840df1db49ef792657ca1b1561c3130f830afaf34b847cdec87'
];
$request = new Request('GET', BASE_URL . '/api/campaigns/' . $id, $headers);
$res = $client->sendAsync($request)->wait();
$response = json_decode($res->getBody()->getContents());
$id = $response->campId;
$members = $response->members;
include_once 'includes/header.php';
?>

<div id="page-wrapper">
    <input type="hidden" name="id" value="<?php echo $response->campId; ?>">
    <div class="row">
        <h2 class="page-header">Campaign Details</h2>
    </div>
    <form class="" action="" method="POST" enctype="multipart/form-data" id="contact_form">
        <fieldset>
            <div class="form-group">
                <label for="f_name">Campaign Name</label>
                <input type="text" name="f_name"
                    value="<?php echo htmlspecialchars($response->campName, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="First Name" class="form-control" required="required" id="f_name" readonly>
            </div>

            <div class="form-group">
                <label for="l_name">Organization</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->campHost, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>

            <div class="form-group">
                <label>Approval Status</label>
                <label class="radio-inline">
                    <input type="radio" name="status" value="Approved" <?php echo ($response->campStatus == 1) ? "checked" : ""; ?> required="required" id="Approved" />
                    Approved
                </label>
                <label class="radio-inline">
                    <input type="radio" name="status" value="Denied" <?php echo ($response->campStatus == 0) ? "checked" : ""; ?> required="required" id="Denied" /> Pending
                </label>
            </div>

            <div class="form-group">
                <label for="l_name">Location</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($response->campLocation, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name" readonly>
            </div>

            <div class="form-group">
                <label for="date">Start Date</label>
                <input name="date"
                    value="<?php echo htmlspecialchars($response->campStartDate, ENT_QUOTES, 'UTF-8'); ?>"
                    class="form-control" type="text" id="date" readonly>
            </div>

            <div class="form-group">
                <label>Create Date </label>
                <input name="date"
                    value="<?php echo htmlspecialchars($response->campCreateDate, ENT_QUOTES, 'UTF-8'); ?>"
                    class="form-control" type="text" readonly>
            </div>
            <div>
                <!-- show all organizations campaigns in a table -->
                <h3>Campaign Member Joined</h3>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">User Name</th>
                            <th width="10%">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($members); $i++) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td><a href="user_detail.php?id=' . $members[$i]->id . '">' . $members[$i]->member . '</a></td>';
                            echo '<td>' . $members[$i]->joinTime . '</td>';
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