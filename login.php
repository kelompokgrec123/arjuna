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
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h2>Login Pengguna</h2>
        <form method="post">
            <label>Username</label>
        <input type="text" name="username" required>
        
            <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = ($_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);
    
    if(!$result){
        die("SQL Error:" . mysqli_error($koneksi));
    }

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $data;

        if($data['role'] == 'admin'){
            header("Location: dashboard_admin.php");
        }else{
            header("Location: dashboard_siswa.php");
        }
        exit();
    }else{
        echo"<p style='color:red;'>Username atau password salah!</p>";
    }
    
}
?>
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
        