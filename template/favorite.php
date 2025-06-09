<?php
require 'koneksi.php';
session_start();
header('Content-Type: application/json');

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Produk tidak valid']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User belum login']);
    exit;
}

$id = $_POST['id'];
$user_id = $_SESSION['user_id'];

try {
    // Cek apakah produk ada
    $cekProduk = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $cekProduk->execute([$id]);

    $produk = $cekProduk->fetch(PDO::FETCH_ASSOC);
    if (!$produk) {
        echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        exit;
    }
    

    // Cek apakah sudah difavoritkan
    $cekFavorit = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND product_id = ?");
    $cekFavorit->execute([$user_id, $id]);

    $favorit = $cekFavorit->fetch(PDO::FETCH_ASSOC);
if ($favorit) {
    // Sudah ada di favorit
}
    // Simpan ke favorit
    $conn->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)")->execute([$user_id, $id]);

    echo json_encode(['status' => 'success', 'message' => 'Produk ditambahkan ke favorit']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem']);
}
