<?php
// Connect database
$conn = mysqli_connect("localhost", "root", "", "changeThis");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function signup($data)
{
    global $conn;
    $nama = strtolower(stripslashes($data["nama"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $repeatPass = mysqli_real_escape_string($conn, $data["repeat_password"]);
    $current_timestamp = time();

    // Cek duplicate username
    $cek = mysqli_query($conn, "SELECT nama FROM users WHERE nama = '$nama'");
    if (mysqli_fetch_assoc($cek)) {
        echo "
        <script>
            alert('Username sudah terdaftar');
        </script>
            ";
        return false;
    }

    if ($password !== $repeatPass) {
        echo "
        <script>
            alert('Password tidak sama');
        </script>
        ";
        return 0;
    }

    // Encrypt Pass
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users
                VALUES
                ('', '$nama', '', '', '', '', '', '$password', '$current_timestamp')";
    // Add the user
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function check($data)
{
    if (isset($data)) {
        echo "Guest";
    } else {
        return $data;
    }
}

function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nama = stripslashes(htmlspecialchars($data["username"]));
    $gender = ucfirst(htmlspecialchars($data["gender"]));
    $hobi = htmlspecialchars($data["hobi"]);
    $umur = htmlspecialchars($data["umur"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $tanggal_dibuat = $data["tanggal_dibuat"];

    // Cek if the nama is already in database
    $cekNama = mysqli_query($conn, "SELECT nama FROM users WHERE nama = '$nama' AND id != '$id'");
    if (mysqli_fetch_assoc($cekNama)) {
        echo "
        <script>
            alert('Nama sudah terdaftar');
        </script>
        ";
        return 0;
    } else {
        if ($id && $nama) {
            // Lanjutkan dengan perubahan data
        } else {
            echo "
            <script>
                alert('ID dan Nama harus diisi');
            </script>
            ";
            return 0;
        }
    }
    

    if ( !is_numeric($umur) ){
        echo "
        <script>
            alert('Umur harus angka!');
        </script>
        ";
        return 0;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET
            nama = '$nama',
            gender = '$gender',
            hobi = '$hobi',
            umur = '$umur',
            alamat = '$alamat',
            password = '$password',
            tanggal_dibuat = '$tanggal_dibuat'
        WHERE id = '$id'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
