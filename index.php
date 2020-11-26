<?php
	include 'templates/header.php';
	include 'connection.php';
	session_start();
  	if (!isset($_SESSION['username'])) {
    echo "<script>alert('Access Denied');</script>";
    header('location: login.php');
  } else {    
	if (isset($_GET['q'])) {
		include ('page/'.$_GET['q'].'.php');
	}
	else
	{
?>
	<div class="jumbotron jumbotron-fluid">
	  <div class="container">
	    <h1 class="display-4">Selamat Datang <?php echo $_SESSION['username']; ?>!</h1>
	    <p class="lead">Anda dapat akses menginput, mengubah dan menghapus siswa!</p>
	  </div>
	</div>

	<div class="container">
		<div class="col-md-12 justify-content-center">
			<div class="card mt-3">
				<div class="card-header">
					<h3 class="text-center">INFORMASI</h3>
				</div>
				<div class="card-body">
					<h4 class="text-center">TOTAL SISWA SAAT INI : </h4>
					<?php
						$sql = mysqli_query($con, "SELECT COUNT(nama) AS total_siswa FROM tbl_siswa");
						$r = mysqli_fetch_assoc($sql);
					echo "<h1 class='text-center'><span class='badge badge-primary'>".$r['total_siswa']."</span></h1>";
					?>
					<h4 class="text-center"><span class="fa fa-user"></span> SISWA</h4>
				</div>
			</div>
		</div>
	</div>
	<br><br><br>
<?php 
	} }
	include 'templates/footer.php';
?>

	

