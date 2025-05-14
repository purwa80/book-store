<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav>
  <a href="index.php" class="d-flex align-items-center text-decoration-none">
    <img src="img/logo2.jpg" alt="Logo" width="50" height="50" style="border-radius: 30%; margin-right: 10px;">
    <span class="fw-bold text-dark">Toko Buku Online</span>
  </a>
  <ul class="nav justify-content-center">
    <li class="nav-item"><a class="nav-link active" href="index.php">Produk</a></li>
    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
  </ul>

</nav>