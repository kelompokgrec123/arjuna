<?php
session_start(); if (!isset($_SESSION['user'])|| $_SESSION['user']['role'] !=
'siswa'){
     header("Location: Login.php");
     exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>From Aspirasi</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
       <center>
        <h2>Form Aspirasi Sarana Sekolah</h2>
        <form action="proses_simpan.php" method="POST" enctype="multipart/form-data">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Sarana Kelas">Sarana Kelas</option>
                <option value="Laboratorium">Laboratorium</option>
                <option value="Perpustakaan">Perpustakaan</option>
                <option value="Toilet">Toilet</option>
                <option value="Lapangan">Lapangan</option>
                <option value="Keamanan">Keamanan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <label>Barang</label>
            <select name="barang" required>
                 <option value="">-- Pilih Kategori --</option>
                 <option value="Kursi">Kursi</option>
                 <option value="Meja">Meja</option>
                 <option value="Papan Tulis">Papan Tulis</option>
                 <option value="LCD Proyektor">LCD Proyektor</option>
                 <option value="Komputer">Komputer</option>
                 <option value="Pintu">Pintu</option>
                 <option value="Jendela">Jendela</option>
                 <option value="Lampu">Lampu</option>
                 <option value="Keran Air">Keran Air</option>
                 <option value="Toilet">Toilet</option>
                  <option value="Lainnya">Lainnya</option>
            </select>
            <label>Keterangan</label>
            <select name="judul" required>
                 <option value="">-- Pilih Keterangan --</option>
                 <option value="Rusak">Rusak</option>
                 <option value="Mampet">Mampet</option>
                 <option value="Bocor">Bocor</option>
                 <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                 <option value="Kotor">Kotor</option>
                 <option value="Hilang">Hilang</option>
                 <option value="Lainnya">Lainnya</option>
            </select>

            <label> Isi Aspirasi</label>

            <textarea name="isi" required></textarea>
            <label>Upload Foto Kerusakan</label>

            <input type="file" name="foto" accept="image/'">
            <button type="submit">Kirim Aspirasi</button>
        </form>
        <br>

        <a href="dashboard_siswa.php">Kembali Ke Dashboard</a>
       
    </body>
</html>