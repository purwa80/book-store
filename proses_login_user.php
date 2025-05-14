<?php
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  // Validasi awal
  if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Username dan password wajib diisi.";
    header("Location: login_user.php");
    exit;
  }

  // Gunakan prepared statement untuk mencegah SQL injection
  $stmt = $conn->prepare("SELECT id_user, username, password FROM user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Verifikasi password
  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['user_id'] = $user['id_user'];
    header("Location: index.php");
    exit;
  } else {
    $_SESSION['login_error'] = "Username atau password salah.";
    header("Location: login_user.php");
    exit;
  }
}
