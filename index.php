<?php
session_start();
include "config.php";

// untuk nampilin produk
$query = "SELECT * FROM produk";

// untuk search produk
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
  $query .= " WHERE nama_produk LIKE '%$keyword%' OR kategori_produk LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

// Ambil riwayat pesanan jika user sudah login
$riwayat_pesanan = [];
if (isset($_SESSION['user_id'])) {
  $query_pesanan = mysqli_query($conn, "
        SELECT * FROM pesanan 
        WHERE id_user = {$_SESSION['user_id']}
        ORDER BY created_at DESC
    ");
  while ($row = mysqli_fetch_assoc($query_pesanan)) {
    $riwayat_pesanan[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko Online</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .status-pending {
      color: #f39c12;
    }

    .status-processing {
      color: #3498db;
    }

    .status-shipped {
      color: #2ecc71;
    }

    .status-completed {
      color: #27ae60;
    }

    .carousel-item img {
      height: 400px;
      object-fit: cover;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: rgba(29, 56, 114, 0.75);
      border-radius: 30%;
    }

    /* .fade-in {
      opacity: 0;
      animation: fadeIn 1.5s ease-in forwards;
    } */

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }

    .carousel-caption {
      background-color: rgba(86, 61, 228, 0.51);
      /* semi-transparan */
      padding: 20px;
      border-radius: 10px;
    }

    .fade-in {
      animation: fadeInUp 1s ease-in-out forwards;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo2.jpg" alt="Logo" width="50" height="50" style="border-radius: 20%;"> Toko Buku Online
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>
        <div class="d-flex ms-3">
          <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['user'])): ?>
              <span class="text-white d-flex align-items-center">
                <i class="fas fa-user me-1"></i>
                <?php echo 'Welcome, ' . htmlspecialchars($_SESSION['user']); ?>
              </span>

              <a href="keranjang.php" class="btn btn-primary btn-sm">
                <i class="fas fa-shopping-cart me-1"></i> Keranjang
              </a>

              <a href="logout.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
              </a>
            <?php else: ?>
              <a href="login_user.php" class="btn btn-primary btn-sm">
                <i class="fas fa-sign-in-alt me-1"></i> Login
              </a>
              <a href="login_user.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-shopping-cart me-1"></i> Keranjang
              </a>
            <?php endif; ?>

          </div>
        </div>
      </div>
  </nav>

  <!-- Search Bar -->
  <nav class="navbar navbar-light bg-body-tertiary">
    <div class="container-fluid">
      <form class="d-flex w-50 mx-auto" method="GET" action="">
        <input class="form-control me-2" type="text" name="keyword" placeholder="Cari produk atau kategori..." aria-label="Cari" value="<?php echo htmlspecialchars($keyword); ?>">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
      </form>
    </div>
  </nav>

  <!-- Carousel -->
  <?php include "carousel.php"; ?>

  <!-- Produk List -->
  <h2 class="text-center mt-5 mb-4">Daftar Produk</h2>
  <div class="row row-cols-1 row-cols-md-3 g-4 mx-4">

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="admin/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" style="height: 300px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
              <p class="card-text">Kategori: <?php echo htmlspecialchars($row['kategori_produk']); ?></p>
              <p class="card-text">Harga: Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
              <p class="card-text">Stok: <?php echo $row['stok']; ?></p>
              <button class="btn btn-primary w-100" onclick="addToCart(<?php echo $row['id_produk']; ?>)">Add to Cart</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">Tidak ada produk tersedia.</p>
    <?php endif; ?>
  </div>

  <!-- Riwayat Pemesanan -->
  <?php if (isset($_SESSION['user_id']) && !empty($riwayat_pesanan)): ?>
    <div class="container mt-5">
      <h2>Riwayat Pemesanan Anda</h2>
      <table class="table table-striped table-hover mt-3">
        <thead class="table-light">
          <tr>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayat_pesanan as $pesanan): ?>
            <tr>
              <td><?php echo $pesanan['id_pesanan']; ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
              <td>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></td>
              <td class="status-<?php echo str_replace('_', '-', $pesanan['status']); ?>">
                <?php
                $status = [
                  'pending' => 'Pending',
                  'diproses' => 'Diproses',
                  'dikirim' => 'Dikirim',
                  'selesai' => 'Selesai'
                ];
                echo $status[$pesanan['status']] ?? $pesanan['status'];
                ?>
              </td>
              <td>
                <a href="detail_pesanan_user.php?id=<?php echo $pesanan['id_pesanan']; ?>" class="btn btn-info btn-sm">Detail</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <!-- Bootstrap JS Bundle -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    function addToCart(productId) {
      <?php if (!isset($_SESSION['user_id'])): ?>
        alert("Silakan login terlebih dahulu!");
        window.location.href = "login_user.php";
      <?php else: ?>
        fetch("add_to_cart.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_produk=" + productId
          })
          .then(response => response.json())
          .then(data => {
            alert(data.message);
            if (data.status === "success") {
              window.location.reload();
            }
          });
      <?php endif; ?>
    }
  </script>
</body>

</html>