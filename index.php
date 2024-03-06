<?php
session_start();
require 'assets/php/functions.php';
if (!isset($_SESSION['login'])) {
    header("Location: pages/login.php");
    exit;
}

$query = "SELECT * FROM users WHERE id = '{$_SESSION['data']}'";

$rows = query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Web Tugas Login</title>
    <script>
        const weekdayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

        function updateClock() {
            const clockElement = document.getElementById('clock');
            const dayElement = document.getElementById('day');
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const day = String(now.getDay());
            const currentDay = weekdayNames[day];
            const time = hours + ':' + minutes + ':' + seconds;
            clockElement.textContent = time;
            dayElement.textContent = currentDay;
        }

        setInterval(updateClock, 100);
    </script>
</head>

<body>
    <div class="header">
        <h1>Selamat Datang, <span><?= $rows[0]["nama"] ?></span>!</h1>
        <div class="utility">
            <a href="logout.php" class="logout" onclick="return confirm('Ingin keluar dari akun?')">Log Out</a>
            <a href="pages/edit.php" class="edit">Edit Information</a>
        </div>
    </div>
    <div class="clockDisplay">
        <div id="day"></div>
        <div id="clock"></div>
    </div>

    <div class="content">
        <?php if (is_array($rows) && !empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
                <table border="1" cellpadding="10" cellspacing="0" align="center">
                    <tr>
                        <th colspan="2" class="title-bio"><i class="bi bi-person-fill"></i> User Information</th>
                    </tr>
                    <tr>
                        <th style="width: 30%">Nama</th>
                        <td><?= $row["nama"] ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?= $row["gender"] ?></td>
                    </tr>
                    <tr>
                        <th>Hobi</th>
                        <td><?= $row["hobi"] ?></td>
                    </tr>
                    <tr>
                        <th>Umur</th>
                        <td><?= $row["umur"] ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?= $row["alamat"] ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?= date('l, j F Y', $row["tanggal_dibuat"]) ?></td>
                    </tr>
                </table>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No data available.</p>
        <?php endif; ?>
    </div>

    <?php require 'assets/template/footer.php' ?>
</body>

</html>