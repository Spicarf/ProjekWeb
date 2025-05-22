<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$id_user = $_SESSION['user']['id_user'] ?? null;
$id_produk = isset($_GET['id_produk']) ? (int)$_GET['id_produk'] : 0;
$conn = getConnection();

if (!$id_produk) {
    die("Produk tidak valid.");
}

$stmt = $conn->prepare("SELECT nama_produk FROM produk WHERE id_produk = :id_produk");
$stmt->execute(['id_produk' => $id_produk]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);
$success = false;
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_user) {
    $komentar = trim($_POST['komentar'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);

    if ($komentar === '') {
        $pesan = "Komentar tidak boleh kosong.";
    } elseif ($rating < 1 || $rating > 5) {
        $pesan = "Silakan pilih rating antara 1 sampai 5.";
    } else {
        date_default_timezone_set('Asia/Makassar');
        $tanggal = date("Y-m-d H:i:s");
        try {
            $stmt = $conn->prepare("INSERT INTO komentar (id_user, id_produk, komentar, rating, tanggal) VALUES (:id_user, :id_produk, :komentar, :rating, :tanggal)");
            $stmt->execute([
                ':id_user' => $id_user,
                ':id_produk' => $id_produk,
                ':komentar' => $komentar,
                ':rating' => $rating,
                ':tanggal' => $tanggal
            ]);
            $success = true;
        } catch (PDOException $e) {
            $pesan = "Gagal mengirim komentar: " . $e->getMessage();
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pesan = "Silakan login terlebih dahulu.";
}
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Komentar Produk</title>
    <link rel="stylesheet" href="../css/komentar.css">
</head>
<body data-success="<?= $success ? 'true' : 'false' ?>">

<div class="container-komentar">
    <h2>Berikan Komentar untuk <?= htmlspecialchars($produk['nama_produk']) ?></h2>

    <?php if (!empty($pesan)): ?>
        <div class="error-message"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="komentar">Komentar</label>
        <textarea name="komentar" rows="5" maxlength="500" required></textarea>

        <label for="rating">Rating</label>
        <div class="rating-group">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" 
                    <?= (isset($_POST['rating']) && (int)$_POST['rating'] === $i) ? 'checked' : '' ?>
                    <?= $success ? 'disabled' : '' ?>
                >
                <label for="rating<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>

        <?php if (!$success): ?>
            <button type="submit" class="btn-submit">Kirim Komentar</button>
            <a href="pesanan.php">Batal</a>
        <?php endif; ?>
    </form>
</div>

<!-- Popup success -->
<div class="popup-success" id="popup-success">
    <div class="popup-box">
        Komentar berhasil dikirim!
    </div>
</div>

<script src="../js/komentar.js"></script>
</body>
</html>
