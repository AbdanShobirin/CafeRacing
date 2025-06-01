<?php
session_start();
include "connection/koneksi.php";

// Cek apakah email dan nama dari Google login tersedia
if (!isset($_SESSION['google_email']) || !isset($_SESSION['google_name'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['google_email'];
$nama = $_SESSION['google_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_level = $_POST['id_level'];

    // Simpan ke database dengan status "Pending"
    $stmt = $conn->prepare("INSERT INTO tb_user 
        (username, password, nama_user, id_level, status, CompanyCode, isDeleted, CreatedBy, CreatedDate)
        VALUES (?, '', ?, ?, 'Pending', '', 0, 'GoogleLogin', NOW())");
    $stmt->bind_param("ssi", $email, $nama, $id_level);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Pendaftaran berhasil. Tunggu verifikasi dari admin.'); window.location='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pilih Level Akun</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 450px;
            background: white;
            margin: 100px auto;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .note {
            margin-top: 20px;
            color: #888;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pilih Level Akun</h2>
        <form method="POST">
            <label for="id_level">Pilih Jenis Akun:</label>
            <select name="id_level" id="id_level" required>
                <option value="">-- Pilih Level --</option>
                <option value="2">Waiter</option>
                <option value="3">Kasir</option>
                <option value="4">Owner</option>
                <option value="5">Pelanggan</option>
            </select>

            <button type="submit">Lanjutkan</button>
        </form>
        <div class="note">
            Setelah memilih level, akun Anda akan menunggu verifikasi oleh admin.
        </div>
    </div>
</body>
</html>
