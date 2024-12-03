<?php
include "koneksi.php";

if (isset($_POST['cinema_id']) && isset($_POST['movie_id'])) {
    $cinema_id = mysqli_real_escape_string($conn, $_POST['cinema_id']);
    $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);

    $sql = "SELECT s.showtime_id, s.show_date, s.show_time
            FROM showtimes s
            JOIN cinema_movies cm ON s.cinema_movie_id = cm.cinema_movie_id
            WHERE cm.cinema_id = '$cinema_id' AND cm.movie_id = '$movie_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $options = "<option value=''>Pilih Waktu</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= "<option value='{$row['showtime_id']}'>{$row['show_date']} - {$row['show_time']}</option>";
        }
        echo $options;
    } else {
        echo "<option value=''>Error dalam mengambil waktu tayang</option>";
    }
} else {
    echo "<option value=''>ID bioskop atau film tidak ditemukan</option>";
}
?>
