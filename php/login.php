<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = MD5($_POST["password"]);

  $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
  $statement = $conn->prepare($sql);
  $statement->execute([$username, $password]);

  $user = $statement->fetch();
  if ($user) {
      $_SESSION["user"] = $user;
      echo "<script>alert('Berhasil Login'); window.location.href = '../index.php';</script>";
      exit();
  } else {
      echo "<script>alert('Password atau Username Salah');</script>";
  }
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
  <!-- Form Login Start -->
  <form action="login.php" method="POST" class="login-form">
    <h1>Login</h1>

    <div class="input-group">
      <i data-feather="user"></i>
      <input type="text" id="username" name="username" placeholder="Username" required />
    </div>

    <div class="input-group">
      <i data-feather="lock"></i>
      <input type="password" id="password" name="password" placeholder="Password" required />
    </div>

    <input type="submit" value="Login" class="btn-submit" />
    <a href="signin.php" class="link-signin">Don't have an account? Sign-in</a>
  </form>
  <!-- Form Login End -->

  <!-- Feather Icons Replace -->
  <script>
    feather.replace();
  </script>

  <!-- My Script -->
  <script src="js/script.js"></script>
</body>
</html>