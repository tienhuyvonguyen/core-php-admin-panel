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
    $name = filter_input(INPUT_POST, 'name');
    $phone = filter_input(INPUT_POST, 'phone');
    $bio = filter_input(INPUT_POST, 'bio');
    $description = filter_input(INPUT_POST, 'description');
    $location = filter_input(INPUT_POST, 'location');
    $startDate = filter_input(INPUT_POST, 'startDate');
    $endDate = filter_input(INPUT_POST, 'endDate');
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Add Campaign</h2>
        </div>
    </div>
    <form class="form" action="" method="post" id="customer_form" enctype="multipart/form-data">
        <?php include_once('./forms/camp_form.php'); ?>
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