<?php
session_start();
include "config.php";

if (isset($_POST['jumlah'])) {
  foreach ($_POST['jumlah'] as $id_keranjang => $jumlah) {
    $id_keranjang = (int)$id_keranjang;
    $jumlah = (int)$jumlah;
    if ($jumlah > 0) {
      mysqli_query($conn, "UPDATE keranjang SET jumlah = $jumlah WHERE id_keranjang = $id_keranjang AND id_user = {$_SESSION['user_id']}");
    }
  }
}

header("Location: keranjang.php");
