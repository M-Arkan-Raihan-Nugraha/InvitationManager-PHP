<?php
include "function.php";

// Ambil data laporan gabungan
$laporan = laporanUndanganDenganTamu();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Aplikasi Undangan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <h1>📊 Laporan Aplikasi Undangan</h1>
    <a href="index.php" class="btn-home">🏠 Kembali ke Home</a>

    <?php foreach ($laporan as $undangan) { ?>
        <h2>📅 <?= $undangan['judul'] ?> (<?= $undangan['tanggal'] ?>)</h2>
        <p><?= $undangan['deskripsi'] ?> - <b><?= $undangan['lokasi'] ?></b></p>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Status Kehadiran</th>
                <th>Waktu Respon</th>
            </tr>
            <?php if (!empty($undangan['tamu'])) { 
                $no=1;
                foreach ($undangan['tamu'] as $t) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $t['nama'] ?></td>
                    <td><?= $t['alamat'] ?></td>
                    <td><?= $t['kontak'] ?></td>
                    <td><?= ucwords(str_replace('_',' ',$t['status_kehadiran'])) ?></td>
                    <td><?= $t['waktu_respon'] ?></td>
                </tr>
            <?php } } else { ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada tamu yang diundang</td>
                </tr>
            <?php } ?>
        </table>
        <br>
    <?php } ?>

</body>
</html>