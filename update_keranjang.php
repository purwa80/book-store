<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login_user.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST['jumlah'] as $id_produk => $jumlah) {
    $jumlah = (int)$jumlah;

    // Ambil stok dari database
    $result = mysqli_query($conn, "SELECT stok FROM produk WHERE id_produk = $id_produk");
    $produk = mysqli_fetch_assoc($result);

    // Validasi apakah jumlah yang dimasukkan tidak melebihi stok
    if ($jumlah <= $produk['stok'] && $jumlah > 0) {
      // Update jumlah di keranjang
      $update_query = "
                UPDATE keranjang 
                SET jumlah = $jumlah 
                WHERE id_produk = $id_produk 
                AND id_user = {$_SESSION['user_id']}
            ";
      mysqli_query($conn, $update_query);
    }
  }

  // Kembali ke halaman keranjang setelah pembaruan
  header("Location: keranjang.php");
  exit;
}
