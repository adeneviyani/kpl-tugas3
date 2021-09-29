<?php
//setting default timezone
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');

//start session
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpnative");

if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}

// FUNCTION LOGIN
function login($data)
{
    global $conn;
    $email = $_POST["email"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' ") or die(mysqli_error($conn));
    // CEK USERNAME APAKAH ADA PADA TABEL TB_REGIS_MHS
    if (mysqli_num_rows($result) === 1) {
        // CEK APAKAH PASSWORD BENAR 
        $row = mysqli_fetch_assoc($result);
        if ($row['email_actived'] == 0) {
            return false;
        }
        if (password_verify($password, $row["password"])) {
            $id = $row["id"];
            $created_at = time();
            // SET SESSION LOGIN
            $_SESSION["login"] = true;
            mysqli_query($conn, "INSERT INTO log VALUES(null,$id,$created_at)");
            // SET SESSION USER
            $_SESSION["id_user"] = $row["id"];
        } else {
            return false;
        }
    }
    return $result;
}

// FUNCTION REGISTER
function registrasi($data)
{
    global $conn;

    $username = strtolower(stripcslashes($data["username"]));
    $email = strtolower(stripcslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $emailActived = 0;
    $role = $data['role'];
    $created_at = time();

    // CEK EMAIL SUDAH ADA ATAU BELUM
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email' ");

    // CHECK EMAIL
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
		alert('Email sudah terdaftar !');
		</script>";

        return false;
    }

    // ENSKRIPSI PASSWORD
    $passwordValid =  password_hash($password, PASSWORD_DEFAULT);

    // TAMBAHKAN USER BARU KEDATABASE
    $query = "INSERT INTO user 
	VALUES(null,'$username','$role','$email','$passwordValid',$emailActived,'$created_at')";
    mysqli_query($conn, $query);
    //   email sending
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "userweb456@gmail.com";
    $mail->Password = "456userweb@#";
    $mail->SetFrom("userweb456@gmail.com");
    $mail->Subject = "ACTIVATION";
    $mail->Body = "http://localhost/ade/activate.php?user=$username
                    Klik tautan untuk melakukan activasi email";
    $mail->AddAddress($email);
    $mail->Send();

    return mysqli_affected_rows($conn);
}

// MEMBUAT FUNCTION SHOW DATA (READ)
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $boxs = [];

    // AMBIL DATA (FETCH) DARI VARIABEL RESULT DAN MASUKKAN KE ARRAY
    while ($box = mysqli_fetch_assoc($result)) {
        $boxs[] = $box;
    }
    return $boxs;
}
