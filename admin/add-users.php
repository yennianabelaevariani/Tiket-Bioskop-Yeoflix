<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $rights = mysqli_real_escape_string($conn, $_POST['rights']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, gender, role, created_at) 
            VALUES ('$username', '$email', '$hashed_password', '$gender', '$rights', NOW())";

    if (mysqli_query($conn, $sql)) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn); 
?>
