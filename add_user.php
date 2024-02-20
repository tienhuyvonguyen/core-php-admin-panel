<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    //Insert timestamp
    $currentTime = date('Y-m-d') . 'T' . date('H:i:s');
    $email = filter_input(INPUT_POST, 'email');
    $name = filter_input(INPUT_POST, 'name');
    $phone = filter_input(INPUT_POST, 'phone');
    $bio = filter_input(INPUT_POST, 'bio');

    $client = new Client();
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'text/plain',
        'Cookie' => 'ARRAffinity=f5a3c078cda30b7a72eb318a56bc22c3a7bd8720bca4f58a5a4d6f638aa015f2; ARRAffinitySameSite=f5a3c078cda30b7a72eb318a56bc22c3a7bd8720bca4f58a5a4d6f638aa015f2'
    ];
    $body = '{
      "custPasswd": "",
      "custEmail": "' . $email . '",
      "custName": "' . $name . '",
      "custCreateDate": "' . $currentTime . '"
    }';
    $request = new Request('POST', BASE_URL . '/api/customers', $headers, $body);
    $res = $client->sendAsync($request)->wait();
    if ($res->getStatusCode() == 200) {
        $_SESSION['success'] = "User added successfully!";
        header('location:  all_users.php');
    } else {
        $_SESSION['failure'] = "Failed to add user!";
        header('location:  all_users.php');
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add User</h2>
        </div>
    </div>
    <form class="form" action="" method="post" id="customer_form" enctype="multipart/form-data">
        <?php include_once('./forms/user_form.php');
        if (isset($_SESSION['failure'])) {
            echo '<div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Oops! </strong>' . $_SESSION['failure'] . '
            </div>';
            unset($_SESSION['failure']);
        } ?>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#customer_form").validate({
            rules: {
                f_name: {
                    required: true,
                    minlength: 3
                },
                l_name: {
                    required: true,
                    minlength: 3
                },
            }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>