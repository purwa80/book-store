<?php
include "../config.php";

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Validasi input tidak boleh kosong
  if (empty($username) || empty($password)) {
    header("Location: register.php?error=Harap isi semua kolom.");
    exit;
  }

  // Cek apakah username sudah digunakan
  $check = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
  if (mysqli_num_rows($check) > 0) {
    header("Location: register.php?error=Username sudah terdaftar.");
    exit;
  }

  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Simpan ke database
  $insert = mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')");

  if ($insert) {
    header("Location: login.php?success=Registrasi berhasil. Silakan login.");
  } else {
    header("Location: register.php?error=Gagal mendaftar. Coba lagi.");
  }
}
