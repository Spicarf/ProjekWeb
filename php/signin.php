<?php
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST["nama"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = MD5($_POST["password"]);

  try {
      $sql = "INSERT INTO user(nama, email, username, password) VALUES (?, ?, ?, ?)";
      $statement = $conn->prepare($sql);
      $statement->execute([$nama, $email, $username, $password]);
      echo "<script>alert('Berhasil Sign-up'); window.location.href = 'login.php';</script>";
      exit();
  } catch (PDOException $e) {
      echo "<script>alert('Email atau Username Sudah Terdaftar');</script>";
  }
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign-In</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="../css/signin.css" />
</head>
<body>
  <!-- Form Sign-in Start -->
  <form action="signin.php" method="POST" class="login-form">
    <h1>Sign-in</h1>

    <div class="input-group">
      <i data-feather="user"></i>
      <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required />
    </div>

    <div class="input-group">
      <i data-feather="mail"></i>
      <input type="email" id="email" name="email" placeholder="Email" required />
    </div>

    <div class="input-group">
      <i data-feather="user"></i>
      <input type="text" id="username" name="username" placeholder="Username" required />
    </div>

    <div class="input-group">
      <i data-feather="lock"></i>
      <input type="password" id="password" name="password" placeholder="Password" required />
    </div>

    <input type="submit" value="Sign In" class="btn-submit" />
    <a href="login.php" class="link-login">Already have an account? Login</a>
  </form>
  <!-- Form Sign-in End -->

  <!-- Feather Icons Replace -->
  <script>
    feather.replace();
  </script>
</body>
</html>