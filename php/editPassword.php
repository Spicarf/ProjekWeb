<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$userId = $user['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordLama = $_POST['password_lama'];
    $passwordBaru = $_POST['password_baru'];
    $konfirmasiBaru = $_POST['konfirmasi_password'];

    $stmt = $conn->prepare("SELECT password FROM user WHERE id_user = ?");
    $stmt->execute([$userId]);
    $dataUser = $stmt->fetch();

    if (!$dataUser || $dataUser['password'] !== md5($passwordLama)) {
        echo "<script>alert('Password lama salah!'); window.location.href = 'editPassword.php';</script>";
        exit();
    }

    if ($passwordBaru !== $konfirmasiBaru) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href = 'editPassword.php';</script>";
        exit();
    }

    $passwordBaruMd5 = md5($passwordBaru);
    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id_user = ?");
    $stmt->execute([$passwordBaruMd5, $userId]);

    echo "<script>alert('Password berhasil diperbarui.'); window.location.href = 'profile.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
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
        <a href="editPassword.php">Edit Password</a>
        <a href="../index.php">Beranda</a>
        <a href="logout.php">Logout</a>
    </div>
    <!-- Menu End -->

    <!-- Edit Password Start -->
    <div class="edit-profile-container">
        <h2>Ubah Password</h2>
        <form method="POST">
            <label>Password Lama:</label>
            <input type="password" name="password_lama" required>

            <label>Password Baru:</label>
            <input type="password" name="password_baru" required>

            <label>Konfirmasi Password Baru:</label>
            <input type="password" name="konfirmasi_password" required><br><br>

            <button type="submit">Simpan Password Baru</button>
            <a href="profile.php" class="batal-btn">Batal</a>
        </form>
    </div>
    <!-- Edit Password End -->
</div>
</body>
</html>
