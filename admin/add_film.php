<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $media = $_FILES['media'];
    $director = $_POST['director'];
    $age_rating = $_POST['age_rating'];
    $duration = $_POST['duration'];
    $kategori = $_POST['kategori'];
    $release_date = $_POST['release_date'];
    $rating = $_POST['rating'];
    $trailer_link = $_POST['trailer_link'];
    $status = $_POST['status'];

    $thumbnail = null;

    // Proses upload media
    if ($media['error'] === UPLOAD_ERR_OK) {
        $thumbnail = $media['name'];
        $mediaPath = './assets/upload/thumbnail/' . basename($thumbnail);

        if (!move_uploaded_file($media['tmp_name'], $mediaPath)) {
            echo "<script>
                    alert('Terjadi kesalahan saat mengunggah gambar.');
                    window.history.back();
                  </script>";
            exit;
        }
    } else {
        echo "Kesalahan saat upload: " . $media['error'];
        exit;
    }

    // Insert data film ke tabel movies
    $sql = "INSERT INTO movies (title, description, thumbnail, director, age_rating, duration, category, trailer_link, release_date, Casts, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $judul, $deskripsi, $thumbnail, $director, $age_rating, $duration, $kategori, $trailer_link, $release_date, $rating, $status);

    if ($stmt->execute()) {
        $movie_id = $stmt->insert_id;

        // Insert genres terkait jika ada
        if (isset($_POST['genres'])) {
            $genres = $_POST['genres'];
            foreach ($genres as $genre) {
                $genre_sql = "INSERT INTO movie_genres (movie_id, genre) VALUES (?, ?)";
                $genre_stmt = $conn->prepare($genre_sql);
                $genre_stmt->bind_param("is", $movie_id, $genre);
                if (!$genre_stmt->execute()) {
                    echo "<script>
                            alert('Terjadi kesalahan saat menambahkan genre: " . $genre_stmt->error . "');
                          </script>";
                }
                $genre_stmt->close();
            }
        }

        // Insert cinema terkait jika ada
        if (isset($_POST['cinema_id'])) {
            $cinema_id = $_POST['cinema_id'];
            $cinema_sql = "INSERT INTO cinema_movies (cinema_id, movie_id, start_date, end_date) VALUES (?, ?, NOW(), NOW())";
            $cinema_stmt = $conn->prepare($cinema_sql);
            $cinema_stmt->bind_param("ii", $cinema_id, $movie_id);

            if (!$cinema_stmt->execute()) {
                echo "<script>
                        alert('Terjadi kesalahan saat menambahkan cinema: " . addslashes($cinema_stmt->error) . "');
                      </script>";
            } else {
                echo "<script>
                        alert('Cinema berhasil ditambahkan!');
                      </script>";
            }
            $cinema_stmt->close();
        }

        header("Location: film.php");
        exit;
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat menambahkan film: " . $stmt->error . "');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
