<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT thumbnail FROM movies WHERE movie_id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
        $thumbnail = $movie['thumbnail'];
        $video = $movie['trailer_video'];

        $upload_dir = 'assets/upload/thumbnail/';

        if ($thumbnail && file_exists($upload_dir . $thumbnail)) {
            unlink($upload_dir . $thumbnail);
        }

        if ($video && file_exists($upload_dir . $video)) {
            unlink($upload_dir . $video);
        }

        $delete_movie_sql = "DELETE FROM movies WHERE movie_id = '$id'";
        if (mysqli_query($conn, $delete_movie_sql)) {
            $delete_genre_sql = "DELETE FROM movie_genres WHERE movie_id = '$id'";
            mysqli_query($conn, $delete_genre_sql);

            echo "<script>alert('Film berhasil dihapus!'); window.location.href = 'film.php';</script>";
        } else {
            echo "Error saat menghapus film: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Film tidak ditemukan.'); window.location.href = 'film.php';</script>";
    }
} else {
    echo "<script>alert('ID film tidak diberikan.'); window.location.href = 'film.php';</script>";
}
?>
