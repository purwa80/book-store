<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login User</title>
    <!-- CSS Bootstrap5 di Lokal KomputerS  -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg p-4 rounded-4">
                    <div class="card-body">
                        <div class="logo text-center mb-1">
                            <img src="img/logo2.jpg" alt="Logo" class="rounded-4" width="100">
                        </div>
                        <h3 class="text-center mb-4 mt-2">Login Pengguna</h3>

                        <!-- Tampilkan alert jika ada error -->
                        <?php if (isset($_SESSION['login_error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $_SESSION['login_error'];
                                unset($_SESSION['login_error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>


                        <!-- Form Login -->
                        <form method="POST" action="proses_login_user.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Masuk</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <small>Belum punya akun? <a href="register_user.php">Daftar di sini</a></small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>