<?php
$conn = mysqli_connect("127.0.0.1:3307", "root", "", "db_eventspeak");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>