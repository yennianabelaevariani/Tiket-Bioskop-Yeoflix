<?php
include "koneksi.php";

if (isset($_POST['cinema_id']) && isset($_POST['movie_id'])) {
    $cinemaId = mysqli_real_escape_string($conn, $_POST['cinema_id']);
    $movieId = mysqli_real_escape_string($conn, $_POST['movie_id']);

    $query = "SELECT start_date, end_date FROM cinema_movies WHERE cinema_id='$cinemaId' AND movie_id='$movieId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dates = mysqli_fetch_assoc($result);
        echo json_encode([$dates]); 
    } else {
        echo json_encode([]); 
    }
} else {
    echo json_encode([]); 
}
?>
