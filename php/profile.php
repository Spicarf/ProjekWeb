<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
  <div class="container">
    <!-- Menu Start -->
    <div class="menu">
      <h3>Menu</h3>
      <a href="profile.php">My Profile</a>
      <a href="pesanan.php">Riwayat Pesanan</a>
      <a href="editProfile.php">Edit Profile</a>
      <a href="../index.php">Beranda</a>
      <a href="logout.php">Logout</a>
    </div>
    <!-- Menu End -->

    <!-- My Profile Start -->
    <div class="content">
      <h2>Profil Saya</h2>
      <?php if(!isset($user['profile'])) { ?>
          <img src="../images/profile.jpg" alt="Foto Profil" class="profile-photo"/>
      <?php } else { ?>
          <img src="../images/profile/<?= htmlspecialchars($user['profile']) ?>" alt="Foto Profil" class="profile-photo"/>
      <?php } ?>
      <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($user['nama']) ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>
    <!-- My Profile End -->
  </div>

  <!-- Icons -->
  <script>
    feather.replace();
  </script>

  <!-- My Script -->
  <script src="js/script.js"></script>
</body>
</html>
