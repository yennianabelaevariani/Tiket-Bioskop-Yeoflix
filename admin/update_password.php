<?php
include '../koneksi.php';
session_start(); // Pastikan session sudah dimulai

$user_id = $_POST['user_id'];
$old_password = $_POST['oldpass'];
$new_password = $_POST['newpass'];
$confirm_password = $_POST['confirmpass'];

if ($new_password !== $confirm_password) {
    echo "<script>alert('New passwords do not match!'); window.location.href='edit-user.php?id=" . $user_id . "';</script>";
    exit;
}

$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($db_password);
$stmt->fetch();
$stmt->close();

if (!password_verify($old_password, $db_password)) {
    echo "<script>alert('Old password is incorrect!'); window.location.href='edit-user.php?id=" . $user_id . "';</script>";
    exit;
}

$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_password_hashed, $user_id);

if ($stmt->execute()) {
    session_destroy();
    echo "<script>alert('Password updated successfully. Please log in again.'); window.location.href='../signin.php';</script>";
} else {
    echo "<script>alert('Error updating password: " . $conn->error . "'); window.location.href='edit-user.php?id=" . $user_id . "';</script>";
}

$stmt->close();
$conn->close();
?>
