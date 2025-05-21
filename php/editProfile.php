<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$conn = getConnection();

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$userId = $user['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_user'];
    $email = $_POST['email_user'];
    $username = $_POST['username'];
    $fotoLama = $user['profile'];

    // Cek apakah ada foto baru diupload
    if (!empty($_FILES['profile']['name'])) {
        $namaFileBaru = uniqid() . '-' . basename($_FILES['profile']['name']);
        $targetDir = "../images/profile/";
        $targetFile = $targetDir . $namaFileBaru;

        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $validExt) && $_FILES['profile']['size'] <= 2 * 1024 * 1024) {
            if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFile)) {
                // Hapus foto lama jika bukan default
                if ($fotoLama && file_exists($targetDir . $fotoLama) && $fotoLama !== 'default.png') {
                    unlink($targetDir . $fotoLama);
                }
            } else {
                echo "Gagal mengunggah foto.";
                exit();
            }
        } else {
            echo "Format gambar tidak valid atau ukuran terlalu besar (maks. 2MB).";
            exit();
        }
    } else {
        $namaFileBaru = $fotoLama; // Tidak mengubah foto
    }
    
    if (isset($_POST['hapus_foto'])) {
        $fotoPath = "../images/profile/" . $user['profile'];

        // Hapus file jika bukan default
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        // Update ke database
        $stmt = $conn->prepare("UPDATE user SET profile = ? WHERE id_user = ?");
        $stmt->execute([NULL, $userId]);

        // Perbarui session
        $_SESSION['user']['profile'] = NULL;

        header("Location: editProfile.php");
        exit();
    }

    // Update ke database
    $stmt = $conn->prepare("UPDATE user SET nama = ?, email = ?, username = ?, profile = ? WHERE id_user = ?");
    $stmt->execute([$nama, $email, $username, $namaFileBaru, $userId]);

    // Perbarui session
    $_SESSION['user']['nama'] = $nama;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['profile'] = $namaFileBaru;

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

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

        <!-- Edit Profile Start -->
        <div class="edit-profile-container">
            <h2>Edit Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_user" value="<?= htmlspecialchars($user['nama']) ?>" required>

                <label>Email:</label>
                <input type="email" name="email_user" value="<?= htmlspecialchars($user['email']) ?>" required>

                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

                <label>Foto Profile Saat Ini:</label><br>
                <?php if(!isset($_SESSION['user']['profile'])) { ?>
                    <img src="../images/profile.jpg" alt="foto-profile" width="150"><br><br>
                <?php } else { ?>
                    <img src="../images/profile/<?= htmlspecialchars($user['profile']) ?>" alt="foto-profile" width="150"><br><br>
                <?php } ?>

                <button type="submit" name="hapus_foto" class="hapus-foto-btn" onclick="return confirm('Apakah kamu yakin ingin menghapus foto profile?')">Hapus Foto Profile</button>

                <label>Ganti Foto Profile (Opsional):</label>
                <input type="file" name="profile" accept="image/*"><br><br>
                <button type="submit">Simpan Perubahan</button>
                <a href="profile.php" class="batal-btn">Batal</a>
            </form>
        </div>
        <!-- Edit Profile End -->
    </div>

    <!-- Icons -->
    <script>
        feather.replace();
    </script>

    <!-- My Script -->
    <script src="js/script.js"></script>
</body>
</html>