<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$id = $_POST['id'];
$status = $_POST['status'];
$feedback = mysqli_real_escape_string($koneksi, $_POST['feedback']);

$query = "UPDATE aspirasi SET status='$status', feedback='$feedback' WHERE id='$id'";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Status berhasil diperbarui');window.location='dashboard_admin.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
