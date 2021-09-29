<?php
require "koneksi.php";
if ($_GET['user']) {
    $user = $_GET['user'];
    $getDong =  query("SELECT * FROM user WHERE username='$user'");
    $id = $getDong[0]['id'];
    mysqli_query($conn, "UPDATE user SET email_actived=1 WHERE id=$id");
    echo "EMAIL SUDAH AKTIF" . $id;
}
