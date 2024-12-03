<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_film = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM users WHERE user_id = '$id_film'";

    if (mysqli_query($conn, $sql)) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "ID film tidak valid.";
}
