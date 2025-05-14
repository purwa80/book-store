<?php
session_start();
include "../config.php";
// Fungsi pengecekan login
// Pastikan session admin_id sudah ada
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

if (!isset($_GET['id'])) {
  echo "ID tidak ditemukan!";
  exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek jika data tidak ditemukan
if (!$data) {
  echo "Produk tidak ditemukan!";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <!-- Link Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2>Edit Produk</h2>

    <form action="proses_edit.php" method="POST" enctype="multipart/form-data" class="mt-4">
      <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
      <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">

      <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $data['nama_produk']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="kategori_produk" class="form-label">Kategori</label>
        <select class="form-select" name="kategori_produk" required>
          <option value="MaPel" <?php echo ($data['kategori_produk'] == 'MaPel') ? 'selected' : ''; ?>>Mapel</option>
          <option value="Sejarah" <?php echo ($data['kategori_produk'] == 'Sejarah') ? 'selected' : ''; ?>>Buku Islam</option>
          <option value="Novel" <?php echo ($data['kategori_produk'] == 'Novel') ? 'selected' : ''; ?>>Novel</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $data['harga']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" required><?php echo $data['deskripsi']; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $data['stok']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="gambar_lama" class="form-label">Gambar Saat Ini</label><br>
        <img src="uploads/<?php echo $data['gambar']; ?>" alt="Gambar Produk" width="100"><br><br>
      </div>

      <div class="mb-3">
        <label for="gambar" class="form-label">Gambar Baru</label>
        <input type="file" class="form-control" id="gambar" name="gambar">
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary flex-fill">Batal</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>