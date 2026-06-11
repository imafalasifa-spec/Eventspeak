<?php
session_start();

// hapus semua data session
$_SESSION = [];

// redirect
header("Location: index.php");
exit;
?>