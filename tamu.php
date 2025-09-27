<?php
include "function.php";

// Tambah Tamu
if (isset($_POST['tambah'])) {
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    tambahTamu($nama, $alamat, $kontak);
    header("Location: tamu.php");
    exit;
}

// Update Tamu
if (isset($_POST['update'])) {
    $id     = $_POST['id_tamu'];
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    updateTamu($id, $nama, $alamat, $kontak);
    header("Location: tamu.php");
    exit;
}

// Hapus Tamu
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    hapusTamu($id);
    header("Location: tamu.php");
    exit;
}

$data = getTamu();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola Tamu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <h1>👤 Kelola Tamu</h1>
    <a href="index.php" class="btn-home">🏠 Kembali ke Home</a>

    <h3>Tambah Tamu Baru</h3>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>
        
        <label>Alamat</label>
        <textarea name="alamat" required></textarea>
        
        <label>Kontak</label>
        <input type="text" name="kontak" required>
        
        <button type="submit" name="tambah" class="btn">Simpan</button>
    </form>

    <h3>Daftar Tamu</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $no=1; 
        while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['kontak'] ?></td>
                <td>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="id_tamu" value="<?= $row['id_tamu'] ?>">
                        <input type="text" name="nama" value="<?= $row['nama'] ?>" required>
                        <input type="text" name="alamat" value="<?= $row['alamat'] ?>" required>
                        <input type="text" name="kontak" value="<?= $row['kontak'] ?>" required>
                        <button type="submit" name="update" class="btn btn-edit">Edit</button>
                        <a href="tamu.php?hapus=<?= $row['id_tamu'] ?>" class="btn btn-danger" onclick="return confirm('Hapus tamu ini?')">Hapus</a>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>