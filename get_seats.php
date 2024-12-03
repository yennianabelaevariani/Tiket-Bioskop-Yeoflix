<?php
include 'koneksi.php';

$showtimeId = isset($_POST['showtime_id']) ? intval($_POST['showtime_id']) : 0;

if ($showtimeId <= 0) {
    die("Showtime ID tidak valid.");
}

$query = "
    SELECT seat_number FROM seats 
    WHERE seat_number NOT IN (
        SELECT seat_number FROM booked_seats 
        WHERE booking_id IN (
            SELECT booking_id FROM bookings WHERE showtime_id = '$showtimeId'
        )
    )
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    echo "<form id='seatSelectionForm' method='POST' action='tiket.php'>"; 
    echo "<input type='hidden' name='showtime_id' value='$showtimeId'>"; 
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='seat'>
                <input type='checkbox' name='seats[]' value='{$row['seat_number']}' id='seat-{$row['seat_number']}'>
                <label for='seat-{$row['seat_number']}'>{$row['seat_number']}</label>
              </div>";
    }
    echo "<button type='submit'>Pesan Kursi</button>";
    echo "</form>"; 
} else {
    echo "Tidak ada kursi yang tersedia.";
}

mysqli_close($conn);
?>
