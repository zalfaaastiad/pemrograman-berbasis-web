<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
<h4 class="mb-4">Data Mata Kuliah</h4>

<form method="post" class="mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="kodemk" placeholder="Kode MK" class="form-control" 
                   value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>" 
                   <?php echo isset($_GET['edit']) ? 'readonly' : ''; ?> required>
        </div>
        <div class="col-md-4">
            <input type="text" name="nama" placeholder="Nama Mata Kuliah" class="form-control" 
                   value="<?php echo isset($dataMK) ? $dataMK['nama'] : ''; ?>" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="jumlah_sks" placeholder="Jumlah SKS" class="form-control" 
                   value="<?php echo isset($dataMK) ? $dataMK['jumlah_sks'] : ''; ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'simpan'; ?>" class="btn btn-primary">
                <?php echo isset($_GET['edit']) ? 'Update' : 'Simpan'; ?>
            </button>
        </div>
    </div>
</form>

<?php
// menyimpan data
if (isset($_POST['simpan'])) {
    $stmt = $conn->prepare("INSERT INTO matakuliah VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $_POST['kodemk'], $_POST['nama'], $_POST['jumlah_sks']);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan data: " . $stmt->error . "</div>";
    }
}

// edit Data
if (isset($_GET['edit'])) {
    $kodemk = $conn->real_escape_string($_GET['edit']);
    $result = $conn->query("SELECT * FROM matakuliah WHERE kodemk='$kodemk'");
    $dataMK = $result->fetch_assoc();
}

//  update data
if (isset($_POST['update'])) {
    $kodemk = $conn->real_escape_string($_POST['kodemk']);
    $stmt = $conn->prepare("UPDATE matakuliah SET nama=?, jumlah_sks=? WHERE kodemk=?");
    $stmt->bind_param("sii", $_POST['nama'], $_POST['jumlah_sks'], $kodemk);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data: " . $stmt->error . "</div>";
    }
    echo "<script>location='matakuliah.php'</script>";
}

// menghapus data
if (isset($_GET['hapus'])) {
    $kodemk = $conn->real_escape_string($_GET['hapus']); // Sanitize input
    $query = $conn->query("DELETE FROM matakuliah WHERE kodemk='$kodemk'");
    if ($query) {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data: " . $conn->error . "</div>";
    }
    echo "<script>location='matakuliah.php'</script>";
}
?>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>Kode MK</th>
            <th>Nama</th>
            <th>Jumlah SKS</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM matakuliah");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['kodemk']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['jumlah_sks']}</td>
                    <td>
                        <a href='?hapus={$row['kodemk']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                        <a href='?edit={$row['kodemk']}' class='btn btn-warning btn-sm me-2'>Edit</a>
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