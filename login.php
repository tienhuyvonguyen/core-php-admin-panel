<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));
require_once BASE_PATH.'/includes/header.php';

?>
<!-- set background image -->
<style>
	body {
		background-image: url('images/z5074619982901_92481828b30087767b66cdab08383ddc.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
	}
</style>
<div id="page-" class="col-md-4 col-md-offset-4">
	<form class="form loginform" method="POST" action="authenticate.php">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">TheVolunty Admin Panel</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label">Username</label>
					<input type="text" name="username" class="form-control" required="required">
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<input type="password" name="passwd" class="form-control" required="required">
				</div>
				<?php if (isset($_SESSION['login_failure'])): ?>
					<div class="alert alert-danger alert-dismissable fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php
						echo $_SESSION['login_failure'];
						unset($_SESSION['login_failure']);
						?>
					</div>
				<?php endif; ?>
				<button type="submit" class="btn btn-success loginField">Login</button>
			</div>
		</div>
	</form>
</div>
<?php include_once BASE_PATH . '/includes/footer.php'; ?>