<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['id_pesanan'])) {
  header("Location: index.php");
  exit;
}

$id_pesanan = (int)$_GET['id_pesanan'];
$query = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE id_pesanan = $id_pesanan 
    AND id_user = {$_SESSION['user_id']}
");
$pesanan = mysqli_fetch_assoc($query);

if (!$pesanan) {
  die("Pesanan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Pesanan Berhasil Dibuat!</h2>
        <p class="fs-5">ID Pesanan: <strong><?php echo $pesanan['id_pesanan']; ?></strong></p>
        <p class="fs-5">Total: <strong>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></strong></p>
        <p class="fs-5">Status: <span class="badge bg-<?php echo ($pesanan['status'] == 'selesai') ? 'success' : 'warning'; ?>">
            <?php echo ucfirst(str_replace('_', ' ', $pesanan['status'])); ?>
          </span>
        </p>
        <p class="fs-5">Metode Pembayaran: <strong><?php echo strtoupper($pesanan['metode_pembayaran']); ?></strong></p>

        <?php if ($pesanan['metode_pembayaran'] == 'transfer_bank'): ?>
          <div class="alert alert-info mt-4">
            <h4 class="alert-heading">Instruksi Pembayaran</h4>
            <p>Transfer ke: <strong>BANK ABC (1234567890)</strong></p>
            <p>Jumlah: <strong>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></strong></p>
            <p>Kode Referensi: <strong>ORDER-<?php echo $pesanan['id_pesanan']; ?></strong></p>
          </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mt-4">
          <a href="index.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
          </a>
          <!-- <a href="checkout.php" class="btn btn-success">
            <!-- <i class="fas fa-credit-card me-1"></i> Lanjut Pembayaran -->
          </a> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>