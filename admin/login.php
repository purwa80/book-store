<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style=" width: 100%; max-width: 400px;">
        <div class="logo text-center mb-1">
            <img src="../img/logo2.jpg" alt="Logo" class="rounded-4" width="100">
        </div>
        <h2 class="text-center mb-4 mt-1">Login Admin</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label" for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-grid mb-3">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            </div>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar dulu</a></p>
    </div>
    <!-- Bootstrap 5 JS (ini harus ada untuk interaksi seperti tombol close) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>