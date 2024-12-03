<?php
include '../koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode(['error' => 'Database error.']);
        exit;
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No user ID provided.']);
}

$conn->close();
?>
