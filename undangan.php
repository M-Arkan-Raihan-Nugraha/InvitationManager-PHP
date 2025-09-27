<?php
include "function.php";

// Tambah Undangan
if (isset($_POST['tambah'])) {
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal   = $_POST['tanggal'];
    $lokasi    = $_POST['lokasi'];
    tambahUndangan($judul, $deskripsi, $tanggal, $lokasi);
    header("Location: undangan.php");
    exit;
}

// Update Undangan
if (isset($_POST['update'])) {
    $id        = $_POST['id_undangan'];
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal   = $_POST['tanggal'];
    $lokasi    = $_POST['lokasi'];
    updateUndangan($id, $judul, $deskripsi, $tanggal, $lokasi);
    header("Location: undangan.php");
    exit;
}

// Hapus Undangan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    hapusUndangan($id);
    header("Location: undangan.php");
    exit;
}

$data = getUndangan();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola Undangan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <h1>📅 Kelola Undangan</h1>
    <a href="index.php" class="btn-home">🏠 Kembali ke Home</a>

    <h3>Tambah Undangan Baru</h3>
    <form method="post">
        <label>Judul</label>
        <input type="text" name="judul" required>
        
        <label>Deskripsi</label>
        <textarea name="deskripsi" required></textarea>
        
        <label>Tanggal</label>
        <input type="date" name="tanggal" required>
        
        <label>Lokasi</label>
        <input type="text" name="lokasi" required>
        
        <button type="submit" name="tambah" class="btn">Simpan</button>
    </form>

    <h3>Daftar Undangan</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $no=1; 
        while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['judul'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['lokasi'] ?></td>
                <td>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="id_undangan" value="<?= $row['id_undangan'] ?>">
                        <input type="text" name="judul" value="<?= $row['judul'] ?>" required>
                        <input type="text" name="deskripsi" value="<?= $row['deskripsi'] ?>" required>
                        <input type="date" name="tanggal" value="<?= $row['tanggal'] ?>" required>
                        <input type="text" name="lokasi" value="<?= $row['lokasi'] ?>" required>
                        <button type="submit" name="update" class="btn btn-edit">Edit</button>
                        <a href="undangan.php?hapus=<?= $row['id_undangan'] ?>" class="btn btn-danger" onclick="return confirm('Hapus undangan ini?')">Hapus</a>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>