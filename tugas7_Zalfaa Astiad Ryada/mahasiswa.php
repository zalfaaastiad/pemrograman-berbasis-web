<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
<h4 class="mb-4">Data Mahasiswa</h4>

<form method="post" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="npm" placeholder="NPM" class="form-control" 
                   value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>" 
                   <?php echo isset($_GET['edit']) ? 'readonly' : ''; ?> required>
        </div>
        <div class="col-md-6">
            <input type="text" name="nama" placeholder="Nama" class="form-control" 
                   value="<?php echo isset($dataMahasiswa) ? $dataMahasiswa['nama'] : ''; ?>" required>
        </div>
        <div class="col-md-6">
            <select name="jurusan" class="form-select">
                <option value="Teknik Informatika" <?php echo (isset($dataMahasiswa) && $dataMahasiswa['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                <option value="Sistem Informasi" <?php echo (isset($dataMahasiswa) && $dataMahasiswa['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
            </select>
        </div>
        <div class="col-md-6">
            <textarea name="alamat" placeholder="Alamat" class="form-control"><?php echo isset($dataMahasiswa) ? $dataMahasiswa['alamat'] : ''; ?></textarea>
        </div>
        <div class="col-12">
            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'simpan'; ?>" class="btn btn-primary">
                <?php echo isset($_GET['edit']) ? 'Update' : 'Simpan'; ?>
            </button>
        </div>
</div>
    </div>
</form>

<?php

// menyimpan data
if (isset($_POST['simpan'])) {
    $stmt = $conn->prepare("INSERT INTO mahasiswa VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['npm'], $_POST['nama'], $_POST['jurusan'], $_POST['alamat']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan data: " . $stmt->error . "</div>";
    }
}

// edit Data
if (isset($_GET['edit'])) {
    $npm = $conn->real_escape_string($_GET['edit']);
    $result = $conn->query("SELECT * FROM mahasiswa WHERE npm='$npm'");
    $dataMahasiswa = $result->fetch_assoc();
    
}


//  update Data
if (isset($_POST['update'])) {
    $npm = $conn->real_escape_string($_POST['npm']);
    $stmt = $conn->prepare("UPDATE mahasiswa SET nama=?, jurusan=?, alamat=? WHERE npm=?");
    $stmt->bind_param("ssss", $_POST['nama'], $_POST['jurusan'], $_POST['alamat'], $npm);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data: " . $stmt->error . "</div>";
    }
    echo "<script>location='mahasiswa.php'</script>";
}

// menghapus data
if (isset($_GET['hapus'])) {
    $npm = $conn->real_escape_string($_GET['hapus']); 
    $query = $conn->query("DELETE FROM mahasiswa WHERE npm='$npm'");
    if ($query) {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data: " . $conn->error . "</div>";
    }
    echo "<script>location='mahasiswa.php'</script>";
}
?>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>NPM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM mahasiswa");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['npm']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['jurusan']}</td>
                    <td>{$row['alamat']}</td>
                    <td>
                        <a href='?edit={$row['npm']}' class='btn btn-warning btn-sm me-2'>Edit</a>
                        <a href='?hapus={$row['npm']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>


<div class="text-center mt-4">
    <a href="index.php" class="btn btn-secondary"> Kembali ke beranda</a>
</div>


</body>
</html>