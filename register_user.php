<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register User</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="fontawesome/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Arial', sans-serif;
    }

    .card {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #007bff;
      color: white;
      text-align: center;
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    .btn-custom {
      background-color: #007bff;
      color: white;
      width: 100%;
      padding: 10px;
      font-size: 1.1rem;
      border-radius: 5px;
    }

    .btn-custom:hover {
      background-color: #0056b3;
    }

    .alert {
      display: none;
    }
  </style>
</head>

<body>

  <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
    <strong>Error!</strong> Username sudah digunakan atau ada kesalahan lainnya.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> -->

  <div class="card register-box">
    <div class="logo text-center mb-1">
      <img src="img/logo2.jpg" alt="Logo" class="rounded-circle" width="80">
    </div>
    <h3 class="form-title text-center" style="font-weight: bold;">Form Registrasi Akun</h3>
    <p class="text-center">Silakan isi data di bawah ini untuk mendaftar sebagai pengguna.</p>

  </div>

  <div class="card">
    <div class="card-header">
      <h4>Form Registrasi</h4>
    </div>
    <div class="card-body">
      <form action="proses_register_user.php" method="POST" id="register-form">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan username">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
        </div>

        <div class="mb-3">
          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
        </div>

        <div class="mb-3">
          <label for="no_telepon" class="form-label">No Telepon</label>
          <input type="number" class="form-control" id="no_telepon" name="no_telepon" required>
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea class="form-control" id="alamat" name="alamat" required></textarea>
        </div>

        <button type="submit" class="btn btn-custom"><i class="fas fa-user-plus me-1"></i> Daftar</button>

      </form>
    </div>
    <div class="mt-3 text-center">
      Sudah punya akun? <a href="login_user.php">Login di sini</a>
    </div>
  </div>


  <!-- Bootstrap JS, Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>