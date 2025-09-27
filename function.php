<?php
// Koneksi
$host = "localhost";
$user = "root";
$pass = "";
$db   = "app_undangan";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set Zona Waktu
date_default_timezone_set('Asia/Jakarta');

// Fungsi Undangan
function getUndangan() {
    global $koneksi;
    $sql = "SELECT * FROM undangan ORDER BY tanggal DESC";
    return mysqli_query($koneksi, $sql);
}

function getUndanganById($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $sql = "SELECT * FROM undangan WHERE id_undangan='$id'";
    return mysqli_query($koneksi, $sql);
}

function tambahUndangan($judul, $deskripsi, $tanggal, $lokasi) {
    global $koneksi;
    $judul = mysqli_real_escape_string($koneksi, $judul);
    $deskripsi = mysqli_real_escape_string($koneksi, $deskripsi);
    $tanggal = mysqli_real_escape_string($koneksi, $tanggal);
    $lokasi = mysqli_real_escape_string($koneksi, $lokasi);
    $sql = "INSERT INTO undangan (judul, deskripsi, tanggal, lokasi) 
            VALUES ('$judul', '$deskripsi', '$tanggal', '$lokasi')";
    return mysqli_query($koneksi, $sql);
}

function updateUndangan($id, $judul, $deskripsi, $tanggal, $lokasi) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $judul = mysqli_real_escape_string($koneksi, $judul);
    $deskripsi = mysqli_real_escape_string($koneksi, $deskripsi);
    $tanggal = mysqli_real_escape_string($koneksi, $tanggal);
    $lokasi = mysqli_real_escape_string($koneksi, $lokasi);
    $sql = "UPDATE undangan SET 
                judul='$judul', deskripsi='$deskripsi',
                tanggal='$tanggal', lokasi='$lokasi'
            WHERE id_undangan='$id'";
    return mysqli_query($koneksi, $sql);
}

function hapusUndangan($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    mysqli_query($koneksi, "DELETE FROM kehadiran WHERE id_undangan='$id'");
    $sql = "DELETE FROM undangan WHERE id_undangan='$id'";
    return mysqli_query($koneksi, $sql);
}

// Fungsi Tamu
function getTamu() {
    global $koneksi;
    $sql = "SELECT * FROM tamu ORDER BY nama ASC";
    return mysqli_query($koneksi, $sql);
}

function tambahTamu($nama, $alamat, $kontak) {
    global $koneksi;
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $alamat = mysqli_real_escape_string($koneksi, $alamat);
    $kontak = mysqli_real_escape_string($koneksi, $kontak);
    $sql = "INSERT INTO tamu (nama, alamat, kontak) 
            VALUES ('$nama', '$alamat', '$kontak')";
    return mysqli_query($koneksi, $sql);
}

function updateTamu($id, $nama, $alamat, $kontak) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $alamat = mysqli_real_escape_string($koneksi, $alamat);
    $kontak = mysqli_real_escape_string($koneksi, $kontak);
    $sql = "UPDATE tamu SET 
                nama='$nama', alamat='$alamat',
                kontak='$kontak'
            WHERE id_tamu='$id'";
    return mysqli_query($koneksi, $sql);
}

function hapusTamu($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    mysqli_query($koneksi, "DELETE FROM kehadiran WHERE id_tamu='$id'");
    $sql = "DELETE FROM tamu WHERE id_tamu='$id'";
    return mysqli_query($koneksi, $sql);
}

// Fungsi Kehadiran
function getKehadiran() {
    global $koneksi;
    $sql = "SELECT k.id_kehadiran, u.judul, t.nama, k.status_kehadiran, k.waktu_respon
            FROM kehadiran k
            JOIN undangan u ON k.id_undangan = u.id_undangan
            JOIN tamu t ON k.id_tamu = t.id_tamu
            ORDER BY k.waktu_respon DESC";
    return mysqli_query($koneksi, $sql);
}

function tambahKehadiran($id_undangan, $id_tamu, $status) {
    global $koneksi;
    $allowed = ['pending','hadir','tidak_hadir'];
    if (!in_array($status, $allowed)) $status = 'pending';

    $id_undangan = mysqli_real_escape_string($koneksi, $id_undangan);
    $id_tamu = mysqli_real_escape_string($koneksi, $id_tamu);
    $status = mysqli_real_escape_string($koneksi, $status);

    if ($status === 'pending') {
        $sql = "INSERT INTO kehadiran (id_undangan, id_tamu, status_kehadiran, waktu_respon)
                VALUES ('$id_undangan', '$id_tamu', '$status', NULL)";
    } else {
        $waktu = date("Y-m-d H:i:s");
        $sql = "INSERT INTO kehadiran (id_undangan, id_tamu, status_kehadiran, waktu_respon)
                VALUES ('$id_undangan', '$id_tamu', '$status', '$waktu')";
    }
    return mysqli_query($koneksi, $sql);
}

function updateKehadiran($id, $status) {
    global $koneksi;
    $allowed = ['pending','hadir','tidak_hadir'];
    if (!in_array($status, $allowed)) $status = 'pending';

    $id = mysqli_real_escape_string($koneksi, $id);
    $status = mysqli_real_escape_string($koneksi, $status);

    if ($status === 'pending') {
        $sql = "UPDATE kehadiran SET status_kehadiran='$status', waktu_respon=NULL WHERE id_kehadiran='$id'";
    } else {
        $waktu = date("Y-m-d H:i:s");
        $sql = "UPDATE kehadiran SET status_kehadiran='$status', waktu_respon='$waktu' WHERE id_kehadiran='$id'";
    }
    return mysqli_query($koneksi, $sql);
}

function hapusKehadiran($id) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id);
    $sql = "DELETE FROM kehadiran WHERE id_kehadiran='$id'";
    return mysqli_query($koneksi, $sql);
}

// Fungsi Laporan
function laporanUndanganDenganTamu() {
    global $koneksi;

    $queryUndangan = "SELECT * FROM undangan ORDER BY tanggal ASC";
    $resUndangan = mysqli_query($koneksi, $queryUndangan);

    $hasil = [];
    while ($u = mysqli_fetch_assoc($resUndangan)) {
        $id_undangan = $u['id_undangan'];

        $queryTamu = "SELECT t.nama, t.alamat, t.kontak, k.status_kehadiran, k.waktu_respon
                      FROM tamu t
                      INNER JOIN kehadiran k ON t.id_tamu = k.id_tamu
                      WHERE k.id_undangan = $id_undangan";
        $resTamu = mysqli_query($koneksi, $queryTamu);

        $tamuList = [];
        while ($t = mysqli_fetch_assoc($resTamu)) {
            $tamuList[] = $t;
        }

        $u['tamu'] = $tamuList;
        $hasil[] = $u;
    }

    return $hasil;
}
?>
