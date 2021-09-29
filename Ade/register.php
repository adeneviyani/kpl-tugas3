<?php
// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi.php";

// JIKA SUDAH LOGIN MASUKKAN KEDALAM INDEX
if (isset($_SESSION["login"])) {
	header('location: index-user.php');
	exit;
}
?>

<?php
// APABILA TOMBOL CONFIRM DITEKAN
if (isset($_POST["register"])) {
	if (registrasi($_POST) > 0) {
		echo "<script>
			alert ('User baru berhasil ditambahkan');
		 	document.location.href = 'login.php';
        </script>";
	} else {
		echo mysqli_error($conn);
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Form Login</title>
	<link rel="stylesheet" type="text/css" href="login.css">

</head>

<body>
	<div class="hero">
		<div class="form-box">
			<div class="button-box">
				<div id="btn"></div>
				<button type="button" class="toggle-btn" onclick="login">Register</button>
			</div>
			<form id="login" class="input-group" action="register.php" method="POST">
				<input type="text" class="input-field" placeholder="Username" required name="username">
				<input type="email" class="input-field" placeholder="Email" required name="email">
				<input type="Password" class="input-field" placeholder="Enter Password" required name="password">
				<select name="role" id="">
					<option value="mahasiswa">Mahasiswa</option>
					<option value="dosen">Dosen</option>
					<option value="staf">Staf</option>
				</select>
				<div class="chech-box">
					<span>Sudah punya akun? <a href="login.php">Login</a></span>
				</div>
				<button type="submit" class="submit-btn" name="register">Register</button>
			</form>
		</div>
	</div>
	</div>
</body>

</html>