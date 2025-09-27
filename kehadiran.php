<?php
include "function.php";

// Tambah Kehadiran
if (isset($_POST['tambah'])) {
    $id_undangan = $_POST['id_undangan'];
    $id_tamu     = $_POST['id_tamu'];
    $status      = $_POST['status_kehadiran'];
    tambahKehadiran($id_undangan, $id_tamu, $status);
    header("Location: kehadiran.php");
    exit;
}

// Update Kehadiran
if (isset($_POST['update'])) {
    $id     = $_POST['id_kehadiran'];
    $status = $_POST['status_kehadiran'];
    updateKehadiran($id, $status);
    header("Location: kehadiran.php");
    exit;
}

// Hapus Kehadiran
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    hapusKehadiran($id);
    header("Location: kehadiran.php");
    exit;
}

$undangan   = getUndangan();
$tamu       = getTamu();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola Kehadiran</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <h1>✅ Kelola Kehadiran</h1>
    <a href="index.php" class="btn-home">🏠 Kembali ke Home</a>

    <h3>Tambah Kehadiran</h3>
    <form method="post">
        <label>Undangan</label>
        <select name="id_undangan" required>
            <option value="">-- Pilih Undangan --</option>
            <?php while ($u = mysqli_fetch_assoc($undangan)) { ?>
                <option value="<?= $u['id_undangan'] ?>"><?= $u['judul'] ?> (<?= $u['tanggal'] ?>)</option>
            <?php } ?>
        </select>

        <label>Tamu</label>
        <select name="id_tamu" required>
            <option value="">-- Pilih Tamu --</option>
            <?php mysqli_data_seek($tamu, 0); while ($t = mysqli_fetch_assoc($tamu)) { ?>
                <option value="<?= $t['id_tamu'] ?>"><?= $t['nama'] ?></option>
            <?php } ?>
        </select>

        <label>Status Kehadiran</label>
        <select name="status_kehadiran" required>
            <option value="pending">Pending</option>
            <option value="hadir">Hadir</option>
            <option value="tidak_hadir">Tidak Hadir</option>
        </select>

        <button type="submit" name="tambah" class="btn">Simpan</button>
    </form>

    <h3>Daftar Kehadiran</h3>

    <?php 
    $undanganAll = getUndangan();
    while ($u = mysqli_fetch_assoc($undanganAll)) { 
        $idU = $u['id_undangan'];
        $kehadiran = mysqli_query($koneksi, 
            "SELECT k.*, t.nama 
             FROM kehadiran k 
             JOIN tamu t ON k.id_tamu=t.id_tamu 
             WHERE k.id_undangan='$idU'
             ORDER BY k.waktu_respon DESC");
    ?>
        <h2>📌 <?= $u['judul'] ?> (<?= $u['tanggal'] ?>)</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Status</th>
                <th>Waktu Respon</th>
                <th>Aksi</th>
            </tr>
            <?php 
            $no=1;
            if (mysqli_num_rows($kehadiran) > 0) {
                while ($row = mysqli_fetch_assoc($kehadiran)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= ucwords(str_replace('_',' ',$row['status_kehadiran'])) ?></td>
                        <td><?= $row['waktu_respon'] ? $row['waktu_respon'] : '-' ?></td>
                        <td>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="id_kehadiran" value="<?= $row['id_kehadiran'] ?>">
                                <select name="status_kehadiran">
                                    <option value="pending" <?= $row['status_kehadiran']=='pending'?'selected':'' ?>>Pending</option>
                                    <option value="hadir" <?= $row['status_kehadiran']=='hadir'?'selected':'' ?>>Hadir</option>
                                    <option value="tidak_hadir" <?= $row['status_kehadiran']=='tidak_hadir'?'selected':'' ?>>Tidak Hadir</option>
                                </select>
                                <button type="submit" name="update" class="btn btn-edit">Update</button>
                                <a href="kehadiran.php?hapus=<?= $row['id_kehadiran'] ?>" class="btn btn-danger" onclick="return confirm('Hapus data kehadiran ini?')">Hapus</a>
                            </form>
                        </td>
                    </tr>
                <?php } 
            } else { ?>
                <tr><td colspan="5">Belum ada data kehadiran</td></tr>
            <?php } ?>
        </table>
    <?php } ?>

</body>
</html>
