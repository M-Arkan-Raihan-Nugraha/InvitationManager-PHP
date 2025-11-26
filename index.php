<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengelola Undangan</title>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="background-wrapper">
    <div class="menu">
      <h1>
        <i data-lucide="calendar-plus"></i> Pengelola Undangan
      </h1>

      <p>Selamat datang di aplikasi pengelola undangan. Silakan pilih menu di bawah ini:</p>

      <a href="undangan.php">
        <i data-lucide="calendar-days"></i> Kelola Undangan
      </a>

      <a href="tamu.php">
        <i data-lucide="users"></i> Kelola Tamu
      </a>

      <a href="kehadiran.php">
        <i data-lucide="check-circle"></i> Kehadiran
      </a>

      <a href="laporan.php">
        <i data-lucide="bar-chart-3"></i> Laporan
      </a>
    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
