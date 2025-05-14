<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login_user.php");
  exit;
}

$query = mysqli_query($conn, "
    SELECT keranjang.id_keranjang, produk.nama_produk, produk.harga, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

$total = 0;
$item_count = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h2>

    <div id="alert-container"></div>

    <?php if ($item_count > 0): ?>
      <form action="update_jumlah.php" method="POST">
        <div class="table-responsive">
          <table class="table table-bordered align-middle bg-white shadow-sm">
            <thead class="table-light text-center">
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($query)):
                $subtotal = $row['harga'] * $row['jumlah'];
                $total += $subtotal;
              ?>
                <tr>
                  <td><?php echo $row['nama_produk']; ?></td>
                  <td class="text-end">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                  <td class="text-center" style="max-width: 100px;">
                    <input type="number" name="jumlah[<?php echo $row['id_keranjang']; ?>]" value="<?php echo $row['jumlah']; ?>" min="1" class="form-control text-center">
                  </td>
                  <td class="text-end">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                  <td class="text-center">
                    <a href="hapus_item.php?id=<?php echo $row['id_keranjang']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini dari keranjang?')">
                      <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h4>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></h4>
          <div>
            <a href="index.php" class="btn btn-outline-info me-2">
              <i class="fas fa-arrow-left me-1"></i> Lanjut Belanja
            </a>
            <button type="submit" class="btn btn-warning me-2">
              <i class="fas fa-sync-alt me-1"></i> Perbarui Jumlah
            </button>
            <a href="checkout.php" onclick="return <?php echo $item_count == 0 ? 'false' : 'true'; ?>" class="btn btn-success">
              <i class="fas fa-credit-card me-1"></i> Checkout
            </a>
          </div>
        </div>
      </form>
    <?php else: ?>
      <div class="alert alert-info text-center">
        <i class="fas fa-info-circle me-2"></i> Keranjang kamu masih kosong.
      </div>
      <div class="text-center">
        <a href="index.php" class="btn btn-primary">
          <i class="fas fa-store me-2"></i> Belanja Sekarang
        </a>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>