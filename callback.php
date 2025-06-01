<?php
session_start();
ob_start(); 
require_once 'vendor/autoload.php';
include "connection/koneksi.php";

$client = new Google_Client();
$client->setClientId("YOUR_CLIENT_ID");
$client->setClientSecret("YOUR_CLIENT_SECRET");
$client->setRedirectUri('https://caferacing.alfazza.my.id/callback.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (!isset($token['error'])) {
        // Ini yang penting! set access_token
        $client->setAccessToken($token['access_token']);
        
        // Ambil id_token dan verifikasi
        $id_token = $token['id_token'] ?? null;
        if ($id_token) {
            $payload = $client->verifyIdToken($id_token);

            if ($payload) {
                $email = $payload['email'];
                $name = $payload['name'];
                
                // Cek apakah user sudah ada di database
                $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    $_SESSION['google_email'] = $email;
                    $_SESSION['google_name'] = $name;
                    header('Location: pilih_level.php');
                    exit();
                }

                // Ambil data user
                $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                // Cek apakah status user sudah aktif
                if ($user['status'] !== 'aktif') {
                    echo "Akun Anda belum diverifikasi oleh administrator.";
                    echo "<br>Silakan tunggu hingga akun Anda diaktifkan.";
                    exit();
                }

                // Simpan ke session
                $_SESSION['id_user'] = $user['id_user'];    // Sama kayak login lokal
                $_SESSION['username'] = $user['username'];  // Sama kayak login lokal
                $_SESSION['id_level'] = $user['id_level'];  // Sama kayak login lokal
                $_SESSION['nama_user'] = $user['nama_user']; // Opsional tambahan

                $conn->close();
                header('location: beranda.php');
                exit();
            } else {
                echo "Gagal verifikasi ID token.";
                exit();
            }
        } else {
            echo "ID Token tidak tersedia.";
            exit();
        }

    } else {
        echo "Error saat login Google:<br>";
        echo "<pre>";
        print_r($token);
        echo "</pre>";
        exit();
    }
} else {
    echo "Kode tidak ditemukan.";
    exit();
}