<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql = "SELECT * FROM movies WHERE movie_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
    } else {
        die("Film tidak ditemukan.");
    }
    $genre_sql = "SELECT genre FROM movie_genres WHERE movie_id = '$id'";
    $genre_result = mysqli_query($conn, $genre_sql);
    $genres = [];
    while ($genre_row = mysqli_fetch_assoc($genre_result)) {
        $genres[] = $genre_row['genre'];
    }
} else {
    die("ID film tidak diberikan.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php'; ?>
    <title>YeoFlix</title>
    <style>
        .form-check {
            width: 150px;
        }

        .form-check-label {
            color: white;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include 'components/headerAdmin.php'; ?>

    <div class="sidebar">
        <a href="index.php" class="sidebar__logo">
        </a>
        <?php include 'components/sidebar.php'; ?>
    </div>

    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main__title">
                        <h2>Edit Film</h2>
                    </div>
                </div>

                <div class="col-12">
                    <form action="EditFilm.php?id=<?= $id ?>" class="sign__form sign__form--add" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-xl-7">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="sign__group">
                                            <input type="text" class="sign__input" placeholder="Judul" name="judul" value="<?= htmlspecialchars($movie['title']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="sign__group">
                                            <textarea id="text" name="deskripsi" class="sign__textarea" placeholder="Deskripsi" required><?= htmlspecialchars($movie['description']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <div class="sign__gallery">
                                                <label for="sign">Unggah Sampul (240x340)</label>
                                                <input id="sign" name="media" class="bi bi-image" type="file" accept=".png, .jpg, .jpeg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <input type="text" name="director" class="sign__input" placeholder="Sutradara" value="<?= htmlspecialchars($movie['director']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <select id="status" name="status" class="sign__input">
                                                <option value="Visible" <?= $movie['status'] == 'Visible' ? 'selected' : '' ?>>Visible</option>
                                                <option value="Hidden" <?= $movie['status'] == 'Hidden' ? 'selected' : '' ?>>Hidden</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <input type="date" name="release_date" class="sign__input" value="<?= htmlspecialchars($movie['release_date']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <input type="text" name="age_rating" class="sign__input" placeholder="Rating Usia" value="<?= htmlspecialchars($movie['age_rating']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <input type="text" name="duration" class="sign__input" placeholder="Durasi (menit)" value="<?= htmlspecialchars($movie['duration']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="sign__group">
                                            <input type="text" name="rating" class="sign__input" placeholder="Nama Aktor" value="<?= htmlspecialchars($movie['Casts']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="trailer_link" class="sign__input" placeholder="Kode semat" optional>
                                            <div class="text-light mt-2 col-lg-12">
												<p class="small" style="font-size:10px;">Contoh: https://www.youtube.com/embed/<b>4fdqx7gEUDs</b> kirim link yang bercetak tebal</p>
											</div>
										</div>
									</div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="sign__group">
                                            <label class="sign__label">Pilih Genre:</label>
                                            <div class="d-flex flex-wrap">
                                                <?php
                                                $available_genres = ['Adventure', 'Action', 'Animation', 'Comedy', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Romance'];

                                                foreach ($available_genres as $genre) {
                                                    // Cek apakah genre ini ada dalam array genre yang sudah dipilih
                                                    $checked = in_array($genre, $genres) ? 'checked' : '';
                                                    echo "<div class='form-check me-3'>
                        <input type='checkbox' class='form-check-input' name='genre[]' value='$genre' id='genre$genre' $checked>
                        <label class='form-check-label' for='genre$genre'>$genre</label>
                    </div>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="sign__group">
                                            <label class="sign__label">Pilih Bioskop:</label>
                                            <div class="d-flex flex-wrap">
                                                <?php
                                                $sql_cinemas = "SELECT cinema_id FROM cinema_movies WHERE movie_id = '$id'";
                                                $cinema_result = mysqli_query($conn, $sql_cinemas);
                                                $selected_cinemas = [];

                                                while ($cinema_row = mysqli_fetch_assoc($cinema_result)) {
                                                    $selected_cinemas[] = $cinema_row['cinema_id'];
                                                }

                                                $sql = "SELECT cinema_id, cinema_name FROM cinemas";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $checked = in_array($row['cinema_id'], $selected_cinemas) ? 'checked' : '';
                                                    echo "<div class='form-check me-3'>
                                                    <input type='checkbox' class='form-check-input' name='cinema_id[]' value='" . $row['cinema_id'] . "' id='cinema" . $row['cinema_id'] . "' $checked>
                                                    <label class='form-check-label' for='cinema" . $row['cinema_id'] . "'>" . $row['cinema_name'] . "</label>
                                                </div>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="sign__group">
                                    <label class="sign__label">Tipe Item:</label>
                                    <ul class="sign__radio">
                                        <li>
                                            <input id="type1" type="radio" name="kategori" value="Film" <?= $movie['category'] == 'Film' ? 'checked' : '' ?> required>
                                            <label for="type1">Film</label>
                                        </li>
                                        <li>
                                            <input id="type2" type="radio" name="kategori" value="TV" <?= $movie['category'] == 'TV' ? 'checked' : '' ?>>
                                            <label for="type2">TV</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="sign__btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>