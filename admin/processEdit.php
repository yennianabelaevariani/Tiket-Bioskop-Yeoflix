<?php
include '../koneksi.php';

function validasiFile($file, $tipe_ekstensi = ['jpg', 'jpeg', 'png', 'mp4'])
{
    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    return in_array($ekstensi, $tipe_ekstensi);
}

function validasiUkuranFile($file, $max_size)
{
    return $file['size'] <= $max_size;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $umur = mysqli_real_escape_string($conn, $_POST['umur']); 
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tumbnail = mysqli_real_escape_string($conn, $_POST['tumbnail']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $genre = isset($_POST['genre']) ? implode(", ", $_POST['genre']) : '';
    $durasi = mysqli_real_escape_string($conn, $_POST['durasi']);
    $tggl_rilis = mysqli_real_escape_string($conn, $_POST['tgl_rilis']);
    $type = mysqli_real_escape_string($conn, $_POST['kategori']);

    $media = $_FILES['media'];
    $media_name = $media['name'] ? uniqid() . '_' . basename($media['name']) : null;
    $media_tmp = $media['tmp_name'];
    $media_dir = realpath("../pengguna/img") . "/" . $media_name;

    $movie = $_FILES['movie'];
    $movie_name = $movie['name'] ? uniqid() . '_' . basename($movie['name']) : null;
    $movie_tmp = $movie['tmp_name'];
    $movie_dir = realpath("../pengguna/img") . "/" . $movie_name;

    $sql = "UPDATE tb_film SET 
                tumbnail='$tumbnail',
                rating='$rating', 
                judul='$judul', 
                genre='$genre', 
                durasi='$durasi', 
                deskripsi='$deskripsi', 
                kategori='$type', 
                tgl_rilis='$tggl_rilis',
                umur='$umur'";  

    if ($media_name) {
        if (validasiFile($media, ['jpg', 'jpeg', 'png']) && validasiUkuranFile($media, 5 * 1024 * 1024)) {
            if (move_uploaded_file($media_tmp, $media_dir)) {
                $sql .= ", media='$media_name'";
            } else {
                echo "Gagal mengupload thumbnail.";
                exit();
            }
        } else {
            echo "Ekstensi atau ukuran thumbnail tidak valid.";
            exit();
        }
    }

    if ($movie_name) {
        if (validasiFile($movie, ['mp4']) && validasiUkuranFile($movie, 40 * 1024 * 1024)) {
            if (move_uploaded_file($movie_tmp, $movie_dir)) {
                $sql .= ", movie='$movie_name'";
            } else {
                echo "Gagal mengupload movie.";
                exit();
            }
        } else {
            echo "Ekstensi atau ukuran video tidak valid.";
            exit();
        }
    }

    $sql .= " WHERE id_film='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: film.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
