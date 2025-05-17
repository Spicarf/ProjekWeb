<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
  <!-- Section Profile Start -->
  <section class="profile">
    <div class="menu">
        <a href="#">My Profile</a>
        <a href="edit-profile.php">Edit Profile</a>
        <a href="pesanan.php">Pesanan</a>
        <a href="edit-password.php">Edit Password</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Welcome, <?= htmlspecialchars($user['nama']) ?></h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    </div>
  </section>
  <!-- Section Profile End -->

  <!-- Feather Icons Replace -->
  <script>
    feather.replace();
  </script>
</body>
</html>