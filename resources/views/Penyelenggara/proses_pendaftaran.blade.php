<?php
session_start();
include '../koneksi.php';

// 1. CEK SESSION & AMBIL ID USER
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$email_session = $_SESSION['user'];

// Cari id_user dari tabel user berdasarkan email di session
$query_user = mysqli_query($conn, "SELECT id_user FROM user WHERE email_user = '$email_session'");
$data_user = mysqli_fetch_assoc($query_user);
$id_user_sekarang = $data_user['id_user'];

// 2. PROSES DATA FORM SAAT TOMBOL SUBMIT DIKLIK
if (isset($_POST['submit'])) {
    // Ambil data dari input form (atribut 'name' di HTML)
    $instansi   = mysqli_real_escape_string($conn, $_POST['instansi']);
    $peran      = mysqli_real_escape_string($conn, $_POST['peran']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi_instansi']);
    
    // 3. PROSES UPLOAD FILE
    $filename = $_FILES['portofolio_instansi']['name'];
    $tmp_name = $_FILES['portofolio_instansi']['tmp_name'];
    
    // Tentukan lokasi penyimpanan file
    $folder_tujuan = "uploads/" . $filename;
    
    if (move_uploaded_file($tmp_name, $folder_tujuan)) {
        
        // 4. QUERY INSERT (Memasukkan id_user agar tidak NULL lagi)
        $query = "INSERT INTO penyelenggara (id_user, instansi, peran, deskripsi_instansi, portofolio_instansi) 
                  VALUES ('$id_user_sekarang', '$instansi', '$peran', '$deskripsi', '$filename')";

        if (mysqli_query($conn, $query)) {
            // Jika berhasil, munculkan pesan dan pindah ke dashboard
            echo "<script>
                    alert('Pendaftaran Berhasil! Akun Anda kini terdaftar sebagai Penyelenggara.');
                    window.location.href = 'dashboard.php';
                  </script>";
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }

    } else {
        echo "Gagal mengunggah file portofolio. Pastikan folder 'uploads' sudah ada.";
    }
} else {
    // Jika mencoba akses file ini tanpa submit form, kembalikan ke pendaftaran
    header("Location: penyelenggara.php");
}
?>