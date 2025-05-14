<?php
session_start();
include "../config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $gambar_path = $upload_dir . basename($gambar);

    if (move_uploaded_file($tmp_name, $gambar_path)) {
        $query = "INSERT INTO produk (nama_produk, kategori_produk, gambar, harga, deskripsi, stok) 
                  VALUES ('$nama_produk', '$kategori_produk', '$gambar', '$harga', '$deskripsi', '$stok')";

        if (mysqli_query($conn, $query)) {
            $success_message = "Produk berhasil ditambahkan!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Gagal upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .bg-biru-tua {
        background-color: #003366 !important;
        color: white !important;
    }

    .table-header-biru-tua th {
        background-color: #003366;
        color: white;
    }
</style>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-biru-tua">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Admin Toko</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white">👤 <?php echo '( ' . $_SESSION['username'] . ' )' ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-4">Halaman Admin</h1>
        <h4 class="text-center mb-5">Halo, <strong><?php echo $_SESSION['username'] . '!' ?></strong></h4>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Form Tambah Produk -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">Tambah Produk</div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Produk</label>
                        <select name="kategori_produk" class="form-select" required>
                            <option value="Sejarah">Buku Islam</option>
                            <option value="MaPel">Mapel</option>
                            <option value="Novel">Novel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Tambah Produk</button>
                </form>
            </div>
        </div>

        <!-- Data Produk -->
        <h2 class="mb-3">Data Produk</h2>
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped">
                <thead class="table-header-biru-tua">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $result_produk = mysqli_query($conn, "SELECT * FROM produk");
                    if (mysqli_num_rows($result_produk) > 0) :
                        while ($row = mysqli_fetch_assoc($result_produk)) :
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_produk'] ?></td>
                                <td><?= $row['kategori_produk'] ?></td>
                                <td><img src="uploads/<?= $row['gambar'] ?>" width="50"></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= $row['deskripsi'] ?></td>
                                <td><?= $row['stok'] ?></td>
                                <td>
                                    <a href="edit_produk.php?id=<?= $row['id_produk'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="hapus_produk.php?id=<?= $row['id_produk'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus produk ini?');">Hapus</a>
                                </td>
                            </tr>
                    <?php endwhile;
                    else :
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada data produk.</td></tr>";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Data User -->
        <h2 class="mb-3">Data User</h2>
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped">
                <thead class="table-header-biru-tua">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $result_user = mysqli_query($conn, "SELECT * FROM user");
                    if (mysqli_num_rows($result_user) > 0) :
                        while ($row = mysqli_fetch_assoc($result_user)) :
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['nama_lengkap'] ?></td>
                                <td><?= $row['no_telepon'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                            </tr>
                    <?php endwhile;
                    else :
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data user.</td></tr>";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Data Pesanan -->
        <h2 class="mb-3">Data Pesanan</h2>
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped">
                <thead class="table-header-biru-tua">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_pesanan = "SELECT pesanan.*, user.username 
                                  FROM pesanan 
                                  JOIN user ON pesanan.id_user = user.id_user
                                  ORDER BY pesanan.created_at DESC";
                    $result_pesanan = mysqli_query($conn, $query_pesanan);

                    if (mysqli_num_rows($result_pesanan) > 0) :
                        while ($row = mysqli_fetch_assoc($result_pesanan)) :
                    ?>
                            <tr>
                                <td><?= $row['id_pesanan'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                <td>
                                    <form action="update_status.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="pending" <?= ($row['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="diproses" <?= ($row['status'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                            <option value="dikirim" <?= ($row['status'] == 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                                            <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                <td><a href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>" class="btn btn-info btn-sm">Detail</a></td>
                            </tr>
                    <?php
                        endwhile;
                    else :
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada pesanan.</td></tr>";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>


</body>

</html>