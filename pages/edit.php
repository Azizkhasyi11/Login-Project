<?php
session_start();
require '../assets/php/functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

$id_sess = $_SESSION["data"];

$rows = query("SELECT * FROM users WHERE id = '$id_sess'")[0];
// var_dump($rows);


if (isset($_POST["edit"])) {
    // var_dump($_POST);
    // die;
    // cek
    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil di ubah!');
            document.location.href = '../index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal di ubah!');
            document.location.href = '../index.php';
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/edit.css">
    <title>Edit User Information</title>
</head>

<body>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $rows["id"] ?>">
        <input type="hidden" name="tanggal_dibuat" value="<?= $rows["tanggal_dibuat"] ?>">
        <li>
            <label for="username">Nama :</label><br>
            <input type="text" name="username" id="username" value="<?= $rows["nama"] ?>">
        </li>
        <li>
            <label for="gender">Gender :</label><br>
            <select name="gender" id="gender">
                <option value="male" <?php echo ($rows["gender"] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($rows["gender"] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </li>
        <li>
            <label for="hobi">Hobi :</label><br>
            <input type="text" name="hobi" id="hobi" value="<?= $rows["hobi"] ?>">
        </li>
        <li>
            <label for="umur">Umur :</label><br>
            <input type="text" name="umur" id="umur" value="<?= $rows["umur"] ?>">
        </li>
        <li>
            <label for="alamat">Alamat :</label><br>
            <input type="text" name="alamat" id="alamat" value="<?= $rows["alamat"] ?>">
        </li>
        <li>
            <label for="password">Password :</label><br>
            <input type="text" name="password" id="password" required>
        </li>
        <li>
            <button type="submit" name="edit" onclick="return confirm('Apakah yakin ingin di ubah?')">Edit!</button>
        </li>
    </form>
</body>

</html>