<?php
session_start();
	include ('connection.php');
	if (isset($_SESSION['password'])) {
		session_destroy();
	}

	$password = $_GET['id'];

	if (isset($_POST['password'])) {
		$password = stripslashes($password);
		$password = addslashes($password);
		$password = mysqli_real_escape_string($con, $password);
		$str = "SELECT * FROM tbl_user WHERE password = '$password'";
		$result = mysqli_query($con,$str);
		if((mysqli_num_rows($result))!=1) 
		{
			$_SESSION['msg'] = 'Username Atau Password Salah!';
			$_SESSION['msg_type'] = 'danger';
			header("refresh:1;url=login.php");
		}
		else
		{
			$_SESSION['logged']=$password;
			$row=mysqli_fetch_array($result);
			$_SESSION['username']=$row[2];
			$_SESSION['password']=$row[3];
			$_SESSION['id_user']=$row[0];
			$_SESSION['foto']=$row[4];
			header('location:index.php'); 					
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
	<style type="text/css">
		#loader {
		    position: fixed;
		    left: 0px;
		    top: 0px;
		    width: 100%;
		    height: 100%;
		    z-index: 9999;
		    background: url('assets/25.gif') 50% 50% no-repeat rgb(249,249,249);
		    opacity: .8;
		}
	</style>
</head>
<body class="bg-primary">
	<div class="container">
		<div class="row justify-content-center">
			<!-- LOADING -->
			<div id="loader">s</div>
			<!-- END LOADING -->
			<!-- MODAL -->

			<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-body">
			      	<?php
			      	if (isset($_SESSION['msg'])) {
			      	?>
			      	<div class="alert alert-<?php echo $_SESSION['msg_type']?>" role="alert">
			      		<?php echo $_SESSION['msg']; ?>
			      	</div>
			      	<?php
			      	}
			      	?>
			        <form method="POST" action="login.php?q=check">
			        	<label><b>Masukkan Password!</b></label>
			        	<div class="input-group mb-3">
						  <input type="password" name="password" class="form-control" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon1">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye" style="cursor: pointer;"></i></span>
						  </div>
						</div>
			        	<div class="form-group">
			        		<button type="submit" class="btn btn-primary btn-block" name="login">
			        			<span class="fa fa-sign-in"></span> Login
			        		</button>
			        	</div>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- END MODAL -->

			<div class="col-md-4">
				<div class="card" style="margin-top: 10em;">
					<div class="card-header bg-primary">
						<h5 id="title" class="text-center">Silahkan Pilih Foto untuk Login!</h5>
					</div>
					<div class="card-body">
						<?php
							if (isset($_GET['id'])) {
								?>
								<div id="form">
									<form method="POST" action="login.php">
							        	<label><b>Masukkan Password!</b></label>
							        	<div class="input-group mb-3">
										  <input type="password" name="password" class="form-control" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon1">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye" style="cursor: pointer;"></i></span>
										  </div>
										</div>
							        	<div class="form-group">
							        		<button type="submit" class="btn btn-primary btn-block" name="login">
							        			<span class="fa fa-sign-in"></span> Login
							        		</button>
							        	</div>
							        </form>
								</div>
								<?php
							}
							else
							{
								$s = mysqli_query($con, "SELECT * FROM tbl_user");
								foreach ($s as $r) {
									echo "<a href='login.php?id=".$r['password']."'>
											<img src='uploads/".$r['foto']."' width='100'>
										</a>
										";
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	// } else {
	//  header('location: index.php');
	//}
	//?>
	<script src="assets/jquery-3.5.1.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
	    setTimeout(function () {
	    	$("#loader").fadeOut("slow");
	    }, 1000);
	</script>
</body>
</html>