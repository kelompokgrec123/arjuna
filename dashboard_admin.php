<?php
session_start();
session_regenerate_id(true);

// optional: timeout (5 menit)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['last_activity'] = time();

// cegah cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
include "koneksi.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .foto-preview{
            width: 80px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Dashboard Admin</h2>
    <p>Selamat Datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>
    <a href="logout.php">Logout</a>
    <table>
        <tr>
            <th><center>No</center> </th>
            <th><center>Tanggal</center></th>
            <th><center>Kategori</center></th>
            <th><center>Barang</center></th>
            <th><center>Keterangan</center></th>
            <th><center>Status</center></th>
            <th><center>Feedback</center></th>
            <th><center>Foto</center></th>
            <th><center>Aksi</center></th>
        </tr>
        <?php
        $no= 1;
        $query = "SELECT aspirasi.*, user.nama
        FROM aspirasi
        JOIN user ON aspirasi.id_user = user.id
        ORDER BY aspirasi.tanggal DESC";
        $result = mysqli_query($koneksi, $query);
        if(!$result){
            die("Querry error:" .mysqli_error($koneksi));
        }
        while ($d = mysqli_fetch_assoc($result)){
            if($d['foto']){
                $foto = "<img src='uploads/{$d['foto']}' class='foto-preview'>";
            }else{
                $foto = "-";
            }
            $status = !empty($d['status']) ? $d['status']: 'menunggu';
            if ($status == 'menunggu'){
                $warna='blue';
            }elseif($status == 'diajukan'){
                $warna = 'orange';
             }elseif($status == 'diproses'){
                $warna = 'green';
             }elseif($status == 'selesai'){
                $warna = 'gold';
             }else{
                $warna = 'gray';
            }
            echo "<tr>
            <td><center>{$no}</center></td>
            <td><center>{$d['tanggal']}</center></td>
            <td><center>{$d['kategori']}</center></td>
            <td><center>".(!empty($d['barang'])? $d['barang'] : '-'). "</center></td>
            <td><center>{$d['judul']}</center></td>
            <td><center>
            <span style='padding:4px 10px; border-radius:12px; color:white; font-weight:bold;
            background-color:$warna;'>
            $status
            </span>
            </center></td>
            <td>". (!empty($d['feedback']) ? $d['feedback'] : '-'). "</td>
            <td><center>$foto</center></td>
            <td><center><a href='detail_aspirasi.php?id={$d['id']}'>Detail</a></center></td>
            </tr>";
            $no++;
        }
        ?>
    </table>
    <script>
// isi banyak history sekaligus
for (let i = 0; i < 50; i++) {
    history.pushState(null, null, location.href);
}

// cegah back terus menerus
window.onpopstate = function () {
    history.go(1); // paksa maju lagi
};

// tambahan biar lebih kuat (handle cache)
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>
</body>
</html>