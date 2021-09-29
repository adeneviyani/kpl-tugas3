<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi.php";

// JIKA SUDAH LOGIN MASUKKAN KEDALAM INDEX
if (isset($_SESSION["login"])) {
    header('location: index.php');
    exit;
}

// TRY AND CATCH
if (isset($_POST["login"])) {
    try {
        //code...
        if (login($_POST) == false) {
            throw new Exception("email / password wrong !!!");
        }
        header('location: index.php');
        exit;
    } catch (Exception $error) {
        echo "<script>
        alert ('" . $error->getMessage() . "');
            document.location.href = 'login.php';
        </script>";
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
                <div class="social-icons">
                    <img src="gambar/fb.png">
                    <img src="gambar/tw3.png">
                    <img src="gambar/gg.png">
                </div>
            </div>
            <form id="login" class="input-group" action="login.php" method="POST">
                <input type="email" class="input-field" placeholder="Email" required name="email">
                <input type="Password" class="input-field" placeholder="Enter Password" required name="password">
                <div class="chech-box">
                    <span>Belum punya akun? <a href="register.php">Register</a> <a href="forgetpassword.php">Reset Password</a></span>       
                </div>
            
                <button type="submit" class="submit-btn" name="login">Log In</button>
            </form>
        </div>
    </div>
</body>

</html>