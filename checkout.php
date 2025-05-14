<?php
session_start();
include "config.php";

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data user
$user_query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$_SESSION['user_id']}");
$user_data = mysqli_fetch_assoc($user_query);

// Ambil data keranjang user
$cart_query = mysqli_query($conn, "
    SELECT produk.*, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

// Hitung total harga
$total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($cart_query)) {
    $total += $row['harga'] * $row['jumlah'];
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .checkout-section {
            padding: 50px 0;
        }

        .card {
            border-radius: 10px;
        }

        .btn-custom {
            font-weight: bold;
            text-transform: uppercase;
        }

        .bank-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }

        .order-summary {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select,
        .btn {
            border-radius: 8px;
        }

        .card-body {
            padding: 20px;
        }

        h3 {
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container checkout-section">
        <h2 class="text-center mb-5"><i class="fas fa-credit-card me-2"></i> Proses Checkout</h2>

        <!-- Ringkasan Pesanan -->
        <div class="order-summary mb-4">
            <h3><i class="fas fa-boxes me-2"></i> Ringkasan Pesanan</h3>
            <?php foreach ($items as $item): ?>
                <p><?= htmlspecialchars($item['nama_produk']) ?> (<?= $item['jumlah'] ?>x) -
                    Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?>
                </p>
            <?php endforeach; ?>
            <hr>
            <p><strong>Total Harga: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
        </div>

        <!-- Form Checkout -->
        <form action="proses_checkout.php" method="POST" enctype="multipart/form-data">

            <!-- Data Pengiriman -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5><i class="fas fa-user me-2"></i> Data Pengiriman</h5>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user_data['nama_lengkap'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="<?= htmlspecialchars($user_data['no_telepon'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($user_data['alamat'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <input type="hidden" name="metode_pembayaran" value="transfer_bank">

            <!-- Instruksi Transfer Bank -->
            <div class="bank-info">
                <h5><i class="fas fa-info-circle me-2"></i> Instruksi Pembayaran</h5>
                <p>Silakan transfer ke rekening berikut:</p>
                <p><strong>Bank ABC</strong></p>
                <p>Nomor Rekening: <strong>1234 5678 9012</strong></p>
                <p>Atas Nama: <strong>Nama Toko Anda</strong></p>
                <p>Jumlah: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
                <p>Kode Referensi: <strong>ORDER-<?= time() ?></strong></p>
            </div>

            <!-- Upload Bukti Transfer -->
            <div class="mb-3">
                <label for="bukti_transfer" class="form-label">Upload Bukti Transfer (Format: JPG/PNG, max 2MB)</label>
                <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept="image/jpeg, image/png" required>
            </div>

            <!-- Tombol Konfirmasi -->
            <button type="submit" class="btn btn-success btn-custom w-100">
                <i class="fas fa-check-circle me-2"></i> Konfirmasi Pesanan
            </button>
        </form>

        <!-- Link Kembali -->
        <div class="mt-3 text-center">
            <a href="index.php" class="btn btn-outline-info btn-custom">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>