<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home | Mahasiswa</title>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/all.css">
</head>
<body class="bg-primary">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="card" style="margin-top: 7.5em;">
					<div class="card-header bg-primary">
						<h5>Register | Aplikasi Mahasiswa</h5>
					</div>
					<div class="card-body">
						<?php
						if (isset($_SESSION['msg'])) {
						?>
						<div class="alert alert-<?php echo $_SESSION['msg_type']?>" role="alert">
						    <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Tutup">
						        <span aria-hidden="true">&times;</span>
						    </button>
						    <?php echo $_SESSION['msg']; ?> registrasi! <?php echo "<a href='login.php'><b>".$_SESSION['msg_text']."</b></a>"; ?>
						    <?php unset($_SESSION['msg']) ?>
						</div>
						<?php } ?>
						<form action="register.php" method="POST" class="mb-2">
							<label>Username</label>
							<div class="form-group">
								<input type="text" class="form-control" required name="username">
							</div>
							<label>Password</label>
							<div class="form-group">
								<input type="password" class="form-control" required name="password">
							</div>
							<button type="submit" name="register" class="btn btn-primary btn-block"><span class="fa fa-check-circle"></span> Register</button>
						</form>
						<a href="login.php" class="btn btn-primary btn-block">Login</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	include ('connection.php');
	if (isset($_POST['register'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$s = sprintf("INSERT INTO tbl_user (username, password) VALUES ('%s', '%s')", $username, $password);
		$a = mysqli_query($con, $s);
		if ($a) {
			$_SESSION['msg'] = "Sukses";
			$_SESSION['msg_type'] = "success";
			$_SESSION['msg_text'] = "klik disini";
		}
		else
		{
			$_SESSION['msg'] = "Gagal";
			$_SESSION['msg_type'] = "danger";
			$_SESSION['msg_text'] = "";
		}
	}
	?>
	<script src="assets/jquery-3.5.1.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>