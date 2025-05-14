<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tentang Kami - Toko Buku Online</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .about-section {
            padding: 60px 20px;
            background: #f4f9ff;
        }

        .about-section h2 {
            font-weight: bold;
            color: #2c3e50;
        }

        .about-section p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.7;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; // pastikan file navbar.php berisi navbar yang sudah kamu buat 
    ?>

    <div class="container about-section">
        <h2 class="text-center mb-4">Tentang Toko Buku Online</h2>
        <p class="text-center">
            Toko Buku Online adalah platform yang menyediakan berbagai macam buku berkualitas, mulai dari fiksi, non-fiksi,
            buku pelajaran, hingga buku pengembangan diri. Kami hadir untuk memberikan kemudahan bagi Anda dalam mencari
            dan membeli buku favorit dari mana saja, kapan saja.
        </p>
        <p class="text-center">
            Didirikan oleh tim yang mencintai literasi dan teknologi, kami berkomitmen untuk terus menghadirkan
            pengalaman belanja buku yang cepat, aman, dan menyenangkan.
        </p>
    </div>
</body>

</html>