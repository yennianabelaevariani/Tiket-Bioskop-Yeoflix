<?php
include '../koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $query = "UPDATE users SET username = ?, email = ?, name = ?, role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $username, $email, $name, $role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully'); window.location.href='edit-user.php?id=" . $user_id . "';</script>";
    } else {
        echo "<script>alert('Error updating profile'); window.location.href='edit-user.php?id=" . $user_id . "';</script>";
    }
}
?>
