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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT foto FROM produk WHERE id_produk = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $produk = $stmt->fetch();

    if ($produk) {
        $foto = $produk['foto'];
        $filePath = __DIR__ . "/../images/produk/" . $foto;

        $delete = "DELETE FROM produk WHERE id_produk = :id";
        $stmt = $conn->prepare($delete);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    header("Location: kelolaProduk.php");
    exit;
} else {
    echo "ID produk tidak ditemukan.";
}
$conn = null;
?>