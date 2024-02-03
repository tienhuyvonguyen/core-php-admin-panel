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
if ($id == null) {
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

include_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Campaign Details</h2>
    </div>
    <form class="" action="" method="POST" enctype="multipart/form-data" id="contact_form">
        <fieldset>
            <div class="form-group">
                <label for="f_name">Campaign Name</label>
                <input type="text" name="f_name"
                    value="<?php echo htmlspecialchars($response->campName, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="First Name" class="form-control" required="required" id="f_name">
            </div>

            <div class="form-group">
                <label for="l_name">Last name *</label>
                <input type="text" name="l_name"
                    value="<?php echo htmlspecialchars($edit ? $customer['l_name'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Last Name" class="form-control" required="required" id="l_name">
            </div>

            <div class="form-group">
                <label>Gender * </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" value="male" <?php echo ($edit && $customer['gender'] == 'male') ? "checked" : ""; ?> required="required" /> Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" value="female" <?php echo ($edit && $customer['gender'] == 'female') ? "checked" : ""; ?> required="required" id="female" /> Female
                </label>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" placeholder="Address" class="form-control"
                    id="address"><?php echo htmlspecialchars(($edit) ? $customer['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="form-group">
                <label>State </label>
                <?php $opt_arr = array("Maharashtra", "Kerala", "Madhya pradesh");
                ?>
                <select name="state" class="form-control selectpicker" required>
                    <option value=" ">Please select your state</option>
                    <?php
                    foreach ($opt_arr as $opt) {
                        if ($edit && $opt == $customer['state']) {
                            $sel = "selected";
                        } else {
                            $sel = "";
                        }
                        echo '<option value="' . $opt . '"' . $sel . '>' . $opt . '</option>';
                    }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email"
                    value="<?php echo htmlspecialchars($edit ? $customer['email'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="E-Mail Address" class="form-control" id="email">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input name="phone"
                    value="<?php echo htmlspecialchars($edit ? $customer['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="987654321" class="form-control" type="text" id="phone">
            </div>

            <div class="form-group">
                <label>Date of birth</label>
                <input name="date_of_birth"
                    value="<?php echo htmlspecialchars($edit ? $customer['date_of_birth'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Birth date" class="form-control" type="date">
            </div>

            <div class="form-group text-center">
                <label></label>
                <button href="./pending_camp.php" type="submit" class="btn btn-warning">Back <span
                        class="glyphicon glyphicon-back"></span></button>
            </div>
        </fieldset>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>