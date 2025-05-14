<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hubungi Kami - Toko Buku Online</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contact-section {
            padding: 60px 20px;
            background-color: #fefefe;
        }

        .contact-section h2 {
            font-weight: bold;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .form-control,
        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container contact-section">
        <h2 class="text-center">Hubungi Kami</h2>
        <form method="POST" action="#">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="message">Pesan</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tulis pesan Anda..."
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
    </div>
</body>

</html>