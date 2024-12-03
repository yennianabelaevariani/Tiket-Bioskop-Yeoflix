<?php
include 'koneksi.php';

if (isset($_POST['selected_seats']) && isset($_POST['showtime_id'])) {
    $selectedSeats = $_POST['selected_seats'];
    $showtimeId = $_POST['showtime_id'];

    foreach ($selectedSeats as $seat) {
        $query = "INSERT INTO booked_seats (seat_number, showtime_id) VALUES ('$seat', '$showtimeId')";
        if (!mysqli_query($conn, $query)) {
            echo "Error saat memesan kursi $seat: " . mysqli_error($conn);
        }
    }

    echo "Kursi berhasil dipesan untuk Showtime ID: $showtimeId!";
} else {
    echo "Tidak ada kursi yang dipilih.";
}

mysqli_close($conn);
?>
