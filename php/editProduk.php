<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user']['username'] != "admin" && $_SESSION['user']['email'] != "adminsayurin@gmail.com") {
    header("Location: ../index.php");
    exit();
}

// Pastikan ada ID produk yang dikirim via GET
if (!isset($_GET['id'])) {
    header("Location: kelolaProduk.php");
    exit();
}

$id = $_GET['id'];

// Ambil data produk dari database
$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga_produk'];
    $kategori = $_POST['kategori'];
    $fotoLama = $produk['foto'];

    // Cek apakah ada file baru yang diupload
    if ($_FILES['foto']['name']) {
        $namaFileBaru = uniqid() . '-' . basename($_FILES['foto']['name']);
        $targetDir = "../images/produk/";
        $targetFile = $targetDir . $namaFileBaru;

        // Upload file
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            // Hapus foto lama jika ada
            if (file_exists($targetDir . $fotoLama)) {
                unlink($targetDir . $fotoLama);
            }
        } else {
            echo "Gagal mengupload gambar.";
            exit();
        }
    } else {
        $namaFileBaru = $fotoLama; // Tidak mengubah foto
    }

    // Update data produk
    $updateSQL = "UPDATE produk SET nama_produk = ?, harga_produk = ?, kategori = ?, foto = ? WHERE id_produk = ?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->execute([$nama, $harga, $kategori, $namaFileBaru, $id]);

    header("Location: kelolaProduk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/editProduk.css">
</head>
<body>
    <!-- Edit Produk Start -->
    <div class="edit-produk-container">
        <h2>Edit Produk</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>

            <label>Harga Produk:</label>
            <input type="number" name="harga_produk" value="<?php echo $produk['harga_produk']; ?>" required>

            <label>Kategori:</label>
            <input type="text" name="kategori" value="<?php echo htmlspecialchars($produk['kategori']); ?>" required>

            <label>Foto Produk Saat Ini:</label><br>
            <img src="../images/produk/<?php echo htmlspecialchars($produk['foto']); ?>" alt="foto-produk" width="150"><br><br>

            <label>Ganti Foto Produk (Opsional):</label>
            <input type="file" name="foto" accept="image/*">

            <button type="submit">Simpan Perubahan</button>
            <a href="kelolaProduk.php" class="batal-btn">Batal</a>
        </form>
    </div>
    <!-- Edit Produk End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>