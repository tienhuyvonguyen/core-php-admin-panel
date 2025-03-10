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
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $orgname = filter_input(INPUT_POST, 'orgname');
    $orgphone = filter_input(INPUT_POST, 'phone');
    $orgbio = filter_input(INPUT_POST, 'bio');

    $client = new Client();
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'text/plain',
        'Cookie' => 'ARRAffinity=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f; ARRAffinitySameSite=92ca53ad8db4fbb93d4d3b7d8ab54dcf8ffecb2d731f25b0e91ad575d7534c3f'
    ];
    $body = '{
  "orgName": "' . $orgname . '",
  "orgPassword": "",
  "orgEmail": "' . $email . '",
  "orgCreateDate": "' . $currentTime . '"
}';
    $request = new Request('POST', BASE_URL . '/api/organizations', $headers, $body);
    $res = $client->sendAsync($request)->wait();
    echo $res->getBody();
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add Organization</h2>
        </div>

    </div>
    <form class="form" action="" method="post" id="customer_form" enctype="multipart/form-data">
        <?php include_once('./forms/org_form.php'); ?>
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