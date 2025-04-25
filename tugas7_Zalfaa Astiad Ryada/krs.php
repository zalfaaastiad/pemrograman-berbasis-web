<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KRS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
<h4 class="mb-4">Data KRS</h4>

<form method="post" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <select name="npm" class="form-select">
                <?php
                $mhs = $conn->query("SELECT * FROM mahasiswa");
                while ($row = $mhs->fetch_assoc()) {
                    echo "<option value='{$row['npm']}'>{$row['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <select name="kodemk" class="form-select">
                <?php
                $mk = $conn->query("SELECT * FROM matakuliah");
                while ($row = $mk->fetch_assoc()) {
                    echo "<option value='{$row['kodemk']}'>{$row['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" name="ambil" class="btn btn-primary">Mengambil mata kuliah</button>
        </div>
    </div>
</form>

<?php
//  menyimpan mata kuliah
if (isset($_POST['ambil'])) {
    $npm = $conn->real_escape_string($_POST['npm']);
    $kodemk = $conn->real_escape_string($_POST['kodemk']);
    $query = $conn->query("INSERT INTO krs (mahasiswa_npm, matakuliah_kodemk) VALUES ('$npm', '$kodemk')");
    if ($query) {
        echo "<div class='alert alert-success'>Mata kuliah berhasil diambil!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal mengambil mata kuliah: " . $conn->error . "</div>";
    }
}


// menghapus data
if (isset($_GET['hapus'])) {
    $id = $conn->real_escape_string($_GET['hapus']); 
    $query = $conn->query("DELETE FROM krs WHERE id='$id'");
    if ($query) {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data: " . $conn->error . "</div>";
    }
    echo "<script>location='krs.php'</script>";
}
?>

<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>Mata Kuliah</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $result = $conn->query("SELECT k.id, m.nama AS nama_mhs, mk.nama AS nama_mk, mk.jumlah_sks FROM krs k
                                JOIN mahasiswa m ON m.npm = k.mahasiswa_npm
                                JOIN matakuliah mk ON mk.kodemk = k.matakuliah_kodemk");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['nama_mhs']}</td>
                    <td>{$row['nama_mk']}</td>
                    <td><span class='text-muted'>{$row['nama_mhs']}</span> Mengambil Mata Kuliah <span class='text-primary'>{$row['nama_mk']}</span> ({$row['jumlah_sks']} SKS)</td>
                    <td>
                        <a href='?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                    </td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>


<div class="text-center mt-4">
    <a href="index.php" class="btn btn-secondary"> Kembali ke beranda</a>
</div>


</body>
</html>