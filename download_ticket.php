<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include 'koneksi.php'; 

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if ($booking_id > 0) {
    $booking_query = "SELECT b.*, t.payment_method, t.payment_status, t.payment_date, m.title, sh.show_time, s.seat_number, s.row_label
                      FROM bookings b
                      JOIN transactions t ON b.booking_id = t.booking_id
                      JOIN showtimes sh ON b.showtime_id = sh.showtime_id
                      JOIN cinema_movies cm ON sh.cinema_movie_id = cm.cinema_movie_id
                      JOIN movies m ON cm.movie_id = m.movie_id
                      JOIN booked_seats bs ON b.booking_id = bs.booking_id
                      JOIN seats s ON bs.seat_id = s.seat_id
                      WHERE b.booking_id = $booking_id";
    
    $result = mysqli_query($conn, $booking_query);
    
    if (mysqli_num_rows($result) > 0) {
        $ticket = mysqli_fetch_assoc($result);

        $dompdf = new Dompdf();

        $date = date('l, d F Y', strtotime($ticket['booking_date']));
        $time = isset($ticket['show_time']) ? $ticket['show_time'] : 'Waktu tidak tersedia';
        $title = isset($ticket['title']) ? htmlspecialchars($ticket['title']) : 'Judul tidak tersedia';
        $seat_info = isset($ticket['row_label']) && isset($ticket['seat_number']) ? $ticket['row_label'] . ' ' . $ticket['seat_number'] : 'Kursi tidak tersedia';

        $html = <<<EOD
        <h1>Tiket Bioskop</h1>
        <p>Judul Film: $title</p>
        <p>Tanggal: $date</p>
        <p>Waktu: $time</p>
        <p>Kursi: $seat_info</p>
        <p>ID Booking: {$ticket['booking_id']}</p>
        EOD;

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream('tiket_' . $ticket['booking_id'] . '.pdf', array('Attachment' => true));
    } else {
        echo 'Tiket tidak ditemukan.';
    }
} else {
    echo 'Parameter tiket tidak valid.';
}
?>
