<?php
include "koneksi.php";
if (isset($_POST['city_id']) && isset($_POST['movie_id'])) {
    $city_id = $_POST['city_id'];
    $movie_id = $_POST['movie_id'];

    $sql = "SELECT c.cinema_id, c.cinema_name 
            FROM cinemas c
            JOIN cinema_movies cm ON c.cinema_id = cm.cinema_id
            WHERE c.city_id = '$city_id' AND cm.movie_id = '$movie_id'";
    $result = mysqli_query($conn, $sql);

    $options = "<option value=''>Pilih Bioskop</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['cinema_id']}'>{$row['cinema_name']}</option>";
    }
    echo $options;
}
?>
