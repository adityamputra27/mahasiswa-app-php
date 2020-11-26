<?php
include 'connection.php'; 

function form($con)
{
	if (isset($_GET['id'])) {
        $query = mysqli_query($con, "SELECT * FROM tbl_siswa WHERE id = '".$_GET['id']."'");
        $row = mysqli_fetch_array($query);
        $nik = $row['nik'];
        $nama = $row['nama'];
        $email = $row['email'];
        $foto = $row['foto'];
        $level = $row['level'];
        $status = $row['status'];
        $title = "Form Update Data";
        $button = "<button type='submit' name='update' class='btn btn-block btn-primary'>
        <span class='fa fa-check-circle'></span> Selesai</button>";
      } else {
        $nik = '';
        $nama = '';
        $email = '';
        $foto = '';
        $level = '';
        $status = '';
        $title = "Form Tambah Data";
        $button = "<button type='submit' name='insert' class='btn btn-block btn-primary'>
        <span class='fa fa-check-circle'></span> Selesai</button>";
      }
?>
<div class="container">
	<div class="row justify-content-center mt-3">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h3><?php echo $title; ?></h3>
				</div>
				<div class="card-body">
					<form action="?q=siswa" method="POST" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="">NIK Siswa</label>
					    <input type="text" name="nik" class="form-control" placeholder="Enter NIK"
					    value="<?php echo $nik ?>">
					  </div>
					  <div class="form-group">
					    <label for="">Nama Lengkap Siswa</label>
					    <input type="text" name="nama" class="form-control" placeholder="Enter Name"
					    value="<?php echo $nama; ?>">
					  </div>
					  <div class="form-group">
					  	<label for="">Email Siswa</label>
					  	<input type="emal" name="email" class="form-control" placeholder="Enter e-mail" value="<?php echo $email; ?>">
					  </div>
					  <div class="form-group">
					  	<label>Foto Siswa</label>
					  	<img width="130" />
                        <input type="file" class="uploads form-control" name="foto" value="<?php echo $foto; ?>">
					  </div>
					  <div class="form-group">
					  	<label for="">Level Siswa</label>
					  	<select name="level" class="form-control">
					  		<option>Select Level</option>
					  		<option value="JUNIOR"<?php echo $level; ?>>JUNIOR</option>
					  		<option value="SENIOR"<?php echo $level; ?>>SENIOR</option>
					  	</select>
					  </div>
					  <div class="form-group">
					  	<label for="">Status Siswa</label>
					  	<select name="status" class="form-control">
					  		<option>Select Status</option>
					  		<option value="Siswa Lama" <?php echo $status; ?>>Siswa Lama</option>
					  		<option value="Siswa Baru" <?php echo $status; ?>>Siswa Baru</option>
					  	</select>
					  </div>
					  <?php echo $button; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	} 
	function insert($con)
	{
		$foto = $_FILES['foto']['name'];
		$tmp = $_FILES['foto']['tmp_name'];
		$fotobaru = date('dmYHis').$foto;
		$path = "uploads/".$fotobaru;
		if (move_uploaded_file($tmp, $path)) {	
			$query = sprintf("INSERT INTO tbl_siswa (nik, nama, email, foto, level, status)
				VALUES ('%s', '%s', '%s', '%s', '%s', '%s') 
				", $_POST['nik'], $_POST['nama'], $_POST['email'], $fotobaru, $_POST['level'], $_POST['status']);
			$act = mysqli_query($con, $query);
			if ($act) {
				header('location:?q=siswa');
			} else {
				echo "Gagal".mysqli_error($con);
			}
		} else {
			echo "<div class='alert alert-danger' role='alert'><span class='fa fa-close'></span> Gagal Upload Foto!</div>";
		}
	}
	function delete($con)
	{

		$sql = sprintf("DELETE FROM tbl_siswa WHERE id = '" .$_GET['id']. "'");
		$act = mysqli_query($con, $sql);

		if ($act) {
			header('location:?q=siswa');
		} else {
			echo "Gagal".mysqli_error($con);
		}
	}

	function update($con)
	{
		$foto = $_FILES['foto']['name'];
		$tmp = $_FILES['foto']['tmp_name'];
		$fotobaru = date('dmYHis').$foto;
		$path = "uploads/".$fotobaru;
		if (move_uploaded_file($tmp, $path)) {	
			$sql = sprintf("UPDATE tbl_siswa SET nik = '%s', nama = '%s', email = '%s',
			foto = '%s', level = '%s', status = '%s'", $_POST['nik'], $_POST['nama']
			, $_POST['email'], $fotobaru, $_POST['level'], $_POST['status']);
			$act = mysqli_query($con, $sql);
			if ($act) {
				header('location:?q=siswa');
			} else {
				echo "Gagal".mysqli_error($con);
			}
		} else {
			echo "<div class='alert alert-danger' role='alert'><span class='fa fa-close'></span> Gagal Upload Foto!</div>";
		}
		
	}

	function showData($con)
	{
?>
		<div class="container">
			<div class="data mt-4">
				<div class="d-flex justify-content-between mb-4">
			      	<div>
			         	<a href="?q=siswa&add" class="btn btn-primary"><span class="fa fa-plus-circle"></span> Tambah Data</a>
			      	</div>
			      	<div>
			      		<form class="form-inline" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
				      		<input class="form-control mr-sm-2" type="text" name="cari" placeholder="Cari NIK / Nama Siswa" aria-label="Search">
				      		<button class="btn btn-success my-2 my-sm-0" name="submit" type="submit">Search</button>
				   		</form>
			    	</div>
				</div>
		<?php if (isset($_SESSION['message'])) {
		  ?>
		  <div class="alert alert-<?php echo $_SESSION['message_type']; ?>" role="alert">
		    <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Tutup">
		        <span aria-hidden="true">&times;</span>
		    </button>
		    <?php echo "<span class='fa fa-check-circle'></span> <b>". $_SESSION['message']."</b> Silahkan <b><u><a href='index.php'>klik disini</a></u></b> untuk melihat informasi";
		    unset($_SESSION['message']);
		    ?>
		  </div>
		  <?php
		}
		?>
				<table class="table table-bordered tabled-hovered">
					<thead>
						<tr>
							<th>No</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Email</th>
							<th>Foto</th>
							<th>Level</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<?php
					if (isset($_POST['submit']) && ($_POST['cari']) <> "") {
						$cari = $_POST['cari'];
						echo "<h4>Hasil Pencarian : <span class='badge badge-primary'>".$cari."</span></h4>";
						$query = mysqli_query($con, "SELECT * FROM tbl_siswa WHERE nama LIKE
							'%".$cari."%'");
					}
					else
					{
						$query = mysqli_query($con, "SELECT * FROM tbl_siswa");
					}
					$no = 1;
					$rowCount = mysqli_num_rows($query);
					if ($rowCount > 0) {
						while ($r = mysqli_fetch_assoc($query)) {
							echo "<tbody>";
							echo "<tr>";
							echo "<td>".$no++."</td>";
							echo "<td>".$r['nik']."</td>";
							echo "<td>".$r['nama']."</td>";
							echo "<td>".$r['email']."</td>";
							echo "<td><img src='uploads/".$r['foto']."' width='30'></td>";
							echo "<td>".$r['level']."</td>";
							echo "<td>".$r['status']."</td>";
							echo "<td>
							<a class='fa fa-edit btn btn-outline-primary' href='?q=siswa&add=edit&id=".$r['id']."'></a>
							<a class='fa fa-trash btn btn-outline-danger' href='?q=siswa&aksi=hapus&id=".$r['id']."'></a>
							</td>";
							echo "</tr>";
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="8" class="text-center">
							<div class="alert alert-danger" role="alert">
								<h4><i>BELUM ADA DATA!</i></h4>
							</div>
						</td>
					</tr>
					<?php } ?>
			</div>
		</div>
<?php
	}

	if (isset($_GET['add'])) {
		form($con);
		?>
		<script type="text/javascript">
			function readURL() {
			    var input = this;
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function (e) {
			            $(input).prev().attr('src', e.target.result);
			        }
			        reader.readAsDataURL(input.files[0]);
			    }
			}

			$(function () {
			    $(".uploads").change(readURL)
			    $("#f").submit(function(){
			        return false;
			    });
			});
		</script>
		<?php
	}
	else
	{
		showData($con);
		if (isset($_GET['aksi']) == 'hapus') {
	    delete($con);
	    $_SESSION['message'] = "Data Berhasil Di Hapus!";
	    $_SESSION['message_type'] = "success";
	  }
	}
	if (isset($_POST['insert'])) {
	  insert($con);
	  $_SESSION['message'] = "Data Berhasil Ditambahkan!";
	  $_SESSION['message_type'] = "success";
	}
	if (isset($_POST['update'])) {
	  update($con);
	  $_SESSION['message'] = "Data Berhasil Di Update!";
	  $_SESSION['message_type'] = "success";
	}
?>