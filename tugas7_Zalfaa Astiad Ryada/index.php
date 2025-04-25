<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            padding: 50px ;
        }
        .btn-lg {
            font-size: 1.25rem;
            padding: 15px 30px;
        }
    </style>
</head>
<body>
    <div class="container hero">
        <div class="text-center">
            <h1 class="mb-4 fw-bold text-dark">Sistem Pengambilan KRS</h1>
            <p class="lead text-secondary mb-5">Pilih menu untuk mengelola data:</p>
            <div class="d-grid gap-3 col-md-6 mx-auto">
                
                <a href="mahasiswa.php" class="btn btn-dark btn-lg shadow-sm p-3 rounded">Kelola Mahasiswa</a>
                
                <a href="matakuliah.php" class="btn btn-dark btn-lg shadow-sm p-3 rounded">Kelola Mata Kuliah</a>

                <a href="krs.php" class="btn btn-dark btn-lg shadow-sm p-3 rounded">Tampilkan KRS</a>
            </div>
        </div>
    </div>
</body>
</html>

