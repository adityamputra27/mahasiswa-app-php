<?php
session_start();
  include ('connection.php');
  if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    session_destroy();
    echo "<div class='alert alert-success' role='alert'><span class='fa fa-check-circle'></span> Anda telah logout dari Aplikasi!</div>
         <script>document.location:login.php</script>";
  }
  if (!isset($_SESSION['username'])) {
      if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = sprintf("SELECT * FROM tbl_user WHERE username = '%s' AND password = '%s'", $username, $password);
        $jml = mysqli_num_rows(mysqli_query($con, $query));
        if ($jml == 1) {
          $_SESSION['username'] = $username;
          header('location: index.php');
        } else {
          echo "<div class='alert alert-danger' role='alert'><span class='fa fa-close'></span> Username atau Password salah!</div>";
        }
      }
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
						<h5>Login | Aplikasi Mahasiswa</h5>
					</div>
					<div class="card-body">
						<form action="login.php" method="POST" class="mb-2">
							<label>Username</label>
							<div class="form-group">
								<input type="text" class="form-control" name="username">
							</div>
							<label>Password</label>
							<div class="form-group">
								<input type="password" class="form-control" name="password">
							</div>
							<button type="submit" name="login" class="btn btn-primary btn-block"><span class="fa fa-check-circle"></span> Login</button>
						</form>
						<a href="register.php" class="btn btn-primary btn-block">Register</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	} else {
	  header('location: index.php');
	}
	?>
	<script src="assets/jquery-3.5.1.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>