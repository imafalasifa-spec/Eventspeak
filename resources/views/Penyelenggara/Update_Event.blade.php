<?php
include '../koneksi.php';

$id = $_GET['id'];

$Harga = $_POST['harga'];

mysqli_query($conn, "UPDATE penyelenggara SET
    harga='$Harga'
    WHERE id=$id
");

header("Location: dashboard.php");
?>