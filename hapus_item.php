<?php
session_start();
include "config.php";

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = $id AND id_user = {$_SESSION['user_id']}");
}

header("Location: keranjang.php");
