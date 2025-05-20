<?php
session_start();
require_once __DIR__ . "/getConnection.php";

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id'];
$id_user = $_SESSION['user']['id_user']; // pastikan session ini menyimpan id_user
date_default_timezone_set('Asia/Makassar');
$tanggal = date("Y-m-d H:i:s");

$conn = getConnection();

// Cek apakah produk ada
$cekProduk = $conn->prepare("SELECT * FROM produk WHERE id_produk = :id");
$cekProduk->execute(['id' => $id_produk]);
$produk = $cekProduk->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Insert ke tabel transaksi
$sql = "INSERT INTO transaksi (id_user, id_produk, tanggal) VALUES (:id_user, :id_produk, :tanggal)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'id_user' => $id_user,
    'id_produk' => $id_produk,
    'tanggal' => $tanggal
]);

// Tutup koneksi
$conn = null;

// Redirect ke halaman sukses atau tampilkan pesan
echo "<script>
    alert('Pembelian berhasil!');
    window.location.href = 'produk.php';
</script>";
?>
