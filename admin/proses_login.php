<?php
session_start();
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Cek apakah input tidak kosong
  if (empty($username) || empty($password)) {
    header("Location: login.php?error=Username dan password wajib diisi.");
    exit;
  }

  // Query user dari database
  $query = "SELECT * FROM admin WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if ($admin = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $admin['password'])) {
      // Login berhasil
      $_SESSION['admin_id'] = $admin['id_admin'];
      $_SESSION['username'] = $admin['username'];
      header("Location: index.php");
      exit;
    }
  }

  // Jika gagal login
  header("Location: login.php?error=Username atau password salah.");
  exit;
}
