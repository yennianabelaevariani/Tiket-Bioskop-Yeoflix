<?php
include "koneksi.php";
session_start();

$booking_id = $_POST['booking_id'];
$amount = $_POST['amount'];

$stmt = $conn->prepare("SELECT total_price FROM bookings WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    if ($amount >= $booking['total_price']) {
        
        $stmt = $conn->prepare("UPDATE transactions SET payment_status = 'paid', payment_date = NOW(), amount = ? WHERE booking_id = ?");
        $stmt->bind_param("di", $amount, $booking_id);
        $stmt->execute();

        echo "<script>
                alert('Pembayaran berhasil! Tiket Anda sudah terkonfirmasi.');
                window.location.href = 'tiketEnd.php?booking_id=" . htmlspecialchars($booking_id) . "';
              </script>";
    } else {
        echo "<script>
                alert('Jumlah uang tidak cukup.');
                window.history.back(); // Kembali ke halaman sebelumnya
              </script>";
    }
} else {
    echo "<script>
            alert('Booking ID tidak valid.');
            window.history.back(); // Kembali ke halaman sebelumnya
          </script>";
}

$stmt->close();
?>
