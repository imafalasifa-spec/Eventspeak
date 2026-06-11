<?php
include '../koneksi.php';

$id = $_GET['id'];

// ambil gambar dulu
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM event WHERE id=$id"));

// hapus gambar dari folder
if(file_exists("upload/" . $data['Gambar'])){
    unlink("upload/" . $data['Gambar']);
}

// hapus dari database
mysqli_query($conn, "DELETE FROM event WHERE id=$id");

// balik ke dashboard
header("Location: dashboard.php");
exit;
?>