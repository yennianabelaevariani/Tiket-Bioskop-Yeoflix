<?php
include "koneksi.php";

if (isset($_POST['cinema_id'])) {
    $cinemaId = mysqli_real_escape_string($conn, $_POST['cinema_id']);

    $query = "SELECT DISTINCT studio FROM showtimes WHERE cinema_movie_id IN (SELECT cinema_movie_id FROM cinema_movies WHERE cinema_id='$cinemaId')";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) { 
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['studio']) . '">' . htmlspecialchars($row['studio']) . '</option>';
        }
    } else {
        echo ''; 
    }
} else {
    echo ''; 
}
?>
