<?php
include '../koneksi.php'; 

$nama_pembicara  = $_POST['nama'];
$email_pembicara = $_POST['email'];
$linkedin        = $_POST['linkedin'];
$bidang_keahlian = $_POST['keahlian'];
$jenis_event     = $_POST['jenis_event'];
$topik_event     = $_POST['topik_event'];
$pengalaman      = $_POST['pengalaman'];

// Upload file
$nama_file = $_FILES['portofolio']['name'];
$tmp_name  = $_FILES['portofolio']['tmp_name'];

$folder = "../Penyelenggara/uploads/";
move_uploaded_file($tmp_name, $folder . $nama_file);

// Query
$sql = "INSERT INTO pembicara 
(nama_pembicara, email_pembicara, linkedin, bidang_keahlian, jenis_event, topik_event, pengalaman, portofolio) 
VALUES 
('$nama_pembicara', '$email_pembicara', '$linkedin', '$bidang_keahlian', '$jenis_event', '$topik_event', '$pengalaman', '$nama_file')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Pendaftaran berhasil!');
            window.location.href = '../Pengguna/index.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>