<?php
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Ambil data dari form
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
  $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

  // Validasi jika username sudah ada
  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  if (mysqli_num_rows($result) > 0) {
    // Username sudah terdaftar
    echo "<script>alert('Username sudah digunakan!'); window.location.href='register_user.php';</script>";
    exit;
  }

  // Enkripsi password
  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  // Query untuk memasukkan data ke tabel user
  $query = "INSERT INTO user (username, password, nama_lengkap, no_telepon, alamat) 
              VALUES ('$username', '$password_hash', '$nama_lengkap', '$no_telepon', '$alamat')";

  if (mysqli_query($conn, $query)) {
    // Registrasi berhasil, redirect ke halaman login
    echo "<script>alert('Registrasi berhasil!'); window.location.href='login_user.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mendaftar!'); window.location.href='register_user.php';</script>";
  }
}
