<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Cek apakah username atau email sudah terdaftar
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username atau email sudah terdaftar!'); window.location.href='index.php';</script>";
    } else {
        
        $insertUser = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertUser);
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='signin.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat pendaftaran.'); window.location.href='index.php';</script>";
        }

        $stmt->close();
    }

    $checkUser->close();
    $conn->close();
}
