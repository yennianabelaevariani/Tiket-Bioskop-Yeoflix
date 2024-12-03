<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {

    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $age_rating = mysqli_real_escape_string($conn, $_POST['age_rating']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $trailer_link = mysqli_real_escape_string($conn, $_POST['trailer_link']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $old_thumbnail_sql = "SELECT thumbnail FROM movies WHERE movie_id = ?";
    $stmtOld = $conn->prepare($old_thumbnail_sql);
    $stmtOld->bind_param("i", $id);
    $stmtOld->execute();
    $old_thumbnail_result = $stmtOld->get_result();
    $old_thumbnail = '';

    if ($old_thumbnail_result && $old_thumbnail_result->num_rows > 0) {
        $old_thumbnail_row = $old_thumbnail_result->fetch_assoc();
        $old_thumbnail = $old_thumbnail_row['thumbnail'];
    }

    $thumbnail = $old_thumbnail; 
    if (isset($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        
        $ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
        $thumbnail = time() . '_' . uniqid() . '.' . $ext; 
        move_uploaded_file($_FILES['media']['tmp_name'], "./assets/upload/thumbnail/" . $thumbnail);
    }

    $update_sql = "UPDATE movies SET 
                    title = ?,
                    description = ?,
                    thumbnail = ?,
                    director = ?,
                    age_rating = ?,
                    duration = ?,
                    Casts = ?,
                    category = ?,
                    trailer_link = ?,
                    release_date = ?,
                    status = ?
                    WHERE movie_id = ?";
    
    $stmtUpdate = $conn->prepare($update_sql);
    $stmtUpdate->bind_param("sssssssssssi", $judul, $deskripsi, $thumbnail, $director, $age_rating, $duration, $rating, $kategori, $trailer_link, $release_date, $status, $id);

    if ($stmtUpdate->execute()) {
        
        $delete_genre_sql = "DELETE FROM movie_genres WHERE movie_id = ?";
        $stmtDeleteGenre = $conn->prepare($delete_genre_sql);
        $stmtDeleteGenre->bind_param("i", $id);
        $stmtDeleteGenre->execute();

        $genres = isset($_POST['genre']) ? $_POST['genre'] : [];
        foreach ($genres as $genre) {
            $genre = mysqli_real_escape_string($conn, $genre);
            $insert_genre_sql = "INSERT INTO movie_genres (movie_id, genre) VALUES (?, ?)";
            $stmtInsertGenre = $conn->prepare($insert_genre_sql);
            $stmtInsertGenre->bind_param("is", $id, $genre);
            $stmtInsertGenre->execute();
        }

        if ($old_thumbnail && $thumbnail != $old_thumbnail && file_exists("./assets/upload/thumbnail/" . $old_thumbnail)) {
            unlink("./assets/upload/thumbnail/" . $old_thumbnail);
        }

        echo "<script>alert('Film berhasil diperbarui!'); window.location.href = 'film.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if ($id) {
    $sql = "SELECT * FROM movies WHERE movie_id = ?";
    $stmtSelect = $conn->prepare($sql);
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    if ($result && $result->num_rows > 0) {
        $movie = $result->fetch_assoc();

        $genre_sql = "SELECT genre FROM movie_genres WHERE movie_id = ?";
        $stmtGenre = $conn->prepare($genre_sql);
        $stmtGenre->bind_param("i", $id);
        $stmtGenre->execute();
        $genre_result = $stmtGenre->get_result();
        $genres = [];
        while ($genre_row = $genre_result->fetch_assoc()) {
            $genres[] = $genre_row['genre'];
        }
    } else {
        die("Film tidak ditemukan.");
    }
} else {
    die("ID film tidak diberikan.");
}
?>
