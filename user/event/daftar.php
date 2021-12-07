<?php error_reporting(0); ?>
<?php include '../akses_user.php' ?>
<?php include '../../inc/koneksi.php'; ?>

<?php
$idEvent = $_GET['id'];
$email = $_SESSION['user'];
$sql = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($sql);
$userId = $user['id'];

if (isset($idEvent)) {
	$sql = mysqli_query($koneksi, "SELECT * FROM events WHERE id='$idEvent'");
	$row = mysqli_fetch_assoc($sql);
}

$userEvent = mysqli_query($koneksi, "SELECT * FROM user_event WHERE user_id='$userId' AND event_id='$idEvent' LIMIT 1");
$userRegistered = mysqli_fetch_assoc($userEvent);
?>

<?php if (isset($_GET['id']) == $row['id']) : ?>
	<?php include '../layouts/header.php'; ?>
	<?php include '../layouts/sidebar.php'; ?>
	<?php

	if (isset($_POST['daftar'])) {
		function generateRandomString($length = 10)
		{
			return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
		}

		if (!$userId == isset($userRegistered['user_id'])) {
			$target_dir = "uploads/bukti_transfer/";
			$bukti_transfer = basename($_FILES["bukti_transfer"]['name']);
			$imageFileType = strtolower(pathinfo($bukti_transfer, PATHINFO_EXTENSION));
			$fileName = $target_dir . date('dmy') . '_' . generateRandomString(20) . '.' . $imageFileType;
			$allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

			if ($_FILES["bukti_transfer"]["size"] > 1000000) {
				echo '<div class="alert alert-danger alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>File size terlalu besar, Maksimal 1MB.</div>';
			} else {
				if (!$_FILES['bukti_transfer']['name']) {
					$insert = mysqli_query($koneksi, "INSERT INTO user_event(user_id,event_id) VALUES('$userId','$idEvent') ");
				} else {
					if (in_array($imageFileType, $allowTypes) == false) {
						echo '<div class="alert alert-warning alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Diizinkan jika extensi file .jpg, .png, .jpeg</div>';
					} else {
						move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $fileName);
						$insert = mysqli_query($koneksi, "INSERT INTO user_event(user_id,event_id,bukti_transfer,status) VALUES('$userId','$idEvent','$fileName','proses') ");
					}
				}

				if ($insert) {
					echo '<div class="alert alert-success alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Berhasil mendaftar event.</div>';
				} else {
					echo '<div class="alert alert-danger alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Gagal mendaftar event, silahkan coba lagi.</div>';
				}
			}
		}

		if ($userId == isset($userRegistered['user_id'])) {
			echo '<div class="alert alert-warning alert-dismissable m-2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Anda sudah mendaftar pada event ini.</div>';
		}
	}
	?>

	<?php
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["bukti_transfer"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if (isset($_POST["submit"])) {
		$check = getimagesize($_FILES["bukti_transfer"]["tmp_name"]);
		if ($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
		} else {
			echo "File is not an image.";
		}
	}
	?>
	<section class="content">
		<div class="row">
			<div class="col-md">
				<div class="card">
					<div class="card-header">
						<h2>Daftar Event</h2>
					</div>
					<form method="POST" action="" enctype="multipart/form-data">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mt-4">
										<label>Judul Event</label>
										<input type="text" class="form-control" value="<?= $row['judul'] ?>" disabled>
									</div>
									<div class="form-group mt-4">
										<label>Nama Pembicara</label>
										<input type="text" class="form-control" value="<?= $row['nama'] ?>" disabled>
									</div>
									<div class="row">
										<div class="col-md-7 col-sm">
											<div class="form-group mt-3">
												<label>Tanggal</label>
												<input type="text" class="form-control" value="<?= date('d F Y', strtotime($row['tanggal_mulai'])) ?>" disabled>
											</div>
										</div>
										<div class="col-md-5 col-sm">
											<div class="form-group mt-3">
												<label>Jam Mulai <code><small>s/d</small></code> Selesai</label>
												<input type="text" class="form-control" value="<?= substr($row['jam_mulai'], 0, 5) . ' - ' . substr($row['jam_selesai'], 0, 5) ?>" disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mt-4">
										<label for="deskripsi">Deskripsi</label>
										<textarea class="form-control" rows="10" disabled><?= $row['deskripsi'] ?></textarea>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col">
									<div class="form-group mt-2">
										<label for="nama">Nama Lengkap</label>
										<input type="text" class="form-control" id="nama" value="<?= $user['nama'] ?>" disabled>
									</div>
								</div>
								<div class="col">
									<div class="form-group mt-2">
										<label for="email">Email</label>
										<input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" disabled>
									</div>
								</div>
							</div>
							<div class="form-group mt-2">
								<label for="bukti_transfer">Upload Bukti Transfer</label>
								<code><small>(untuk mendapatkan e-sertifikat, materi dan video rekaman)</small></code>
								<input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
								<p><br>
								Untuk Proses Pembayaran dapat dilakukan Melalui transfer ke bank berikut:
								<br><img src="logo/cimb.png"  width="120" height="50">
								CIMB : <b>706528853200</b>
								<br>A.N : Muhammad Ikhsan
								<br><img src="logo/mandiri.png"  width="120" height="50">
								Mandiri : <b>1080010672138</b>
								<br>A.N : Muhammad Ikhsan
								<br>-——————————
								<br>Atau Bisa Juga Dilakukan Pembayaran Melalui :
								<br><img src="logo/ovo.png"  width="90" height="50">
								OVO : <b>085271737949</b>
								<br><img src="logo/gopay.png"  width="100" height="70">
								Gopay : <b>085271737949</b>
								<br>A.N : Muhammad Ikhsan
								</p>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary" name="daftar">Daftar Event</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php include '../layouts/footer.php'; ?>
<?php endif; ?>

<?php if ($_GET['id'] != $row['id']) {
	header('Location: https://event.lokerprogrammer.com/user/event/404.php');
}
?>