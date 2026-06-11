<?php
include '../koneksi.php';

// ambil data dari form
$nama = $_POST['nama_event'];
$jenis = $_POST['jenis_event'];
$deskripsi = $_POST['deskripsi'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$harga = $_POST['Harga'];
$pemateri = $_POST['pemateri'];

// query simpan ke database
$query = mysqli_query($conn, "INSERT INTO event 
(nama_event, jenis_event, deskripsi, tanggal, lokasi, harga, pemateri, gambar) 
VALUES 
('$nama','$jenis','$deskripsi','$tanggal','$lokasi','$harga','$pemateri', '$gambar')");

// 👉 TARUH DI SINI
if ($query) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Gagal menyimpan data";
}
?>