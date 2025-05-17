<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST["nama"];
    $kategori_produk = $_POST["kategori"];
    $harga_produk = $_POST["harga"];

    $name = $_FILES["foto"]["name"];
    $tmp_name = $_FILES["foto"]["tmp_name"];
    move_uploaded_file($tmp_name, "../images/produk/" . $name);

    $sql = "INSERT INTO produk(nama_produk, harga_produk, foto, kategori) VALUES (?,?,?,?)";
    $statement = $conn->prepare($sql);
    $statement -> execute([$nama_produk,$harga_produk,$name,$kategori_produk]);
    echo "<script>alert('Berhasil Menambahkan Produk');</script>";
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>

        <a href="admin.php" class="navbar-logo">
            <img src="../images/logo.png" alt="logo">
            <p>Sayur<span>in</span></p>
        </a>

        <div class="navbar-nav">   
            <a href="#"><i data-feather="plus"></i>Tambah Produk</a>
            <a href="#"><i data-feather="settings"></i>Kelola Produk</a>
            <a href="#"><i data-feather="users"></i>Lihat Pelanggan</a>
        </div>

        <?php if(!isset($_SESSION['user'])) { ?>
            <a href="login.php" class="akun">Login</a>
        <?php } else { ?>
            <a href="logout.php" class="akun-login">
                <img src="../images/profile.jpg" alt="foto">
                <p><?php echo $_SESSION['user']['username'] ?></p>
            </a>
        <?php }  ?>
    </nav>
    <!-- Navbar End -->

    <!-- Tambah Produk Start -->
    <section class="tambah-produk">
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <label>Nama Produk: </label>
            <input type="text" id="nama" name="nama"><br>
            <label>Kategori Produk: </label>
            <input type="text" id="kategori" name="kategori"><br>
            <label>Harga Produk: </label>
            <input type="text" id="harga" name="harga"><br>
            <label>Foto Produk: </label>
            <input type="file" id="foto" name="foto"><br>
            <input type="submit" value="Tambah">
        </form>
    </section>
    <!-- Tambah Produk End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>