<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_ticket");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Proses delete data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete dependent rows from bookings
    $deleteBookingsQuery = "DELETE FROM bookings WHERE showtime_id = '$delete_id'";
    mysqli_query($conn, $deleteBookingsQuery);

    // Now delete the showtime
    $deleteShowtimeQuery = "DELETE FROM showtimes WHERE showtime_id = '$delete_id'";
    if (mysqli_query($conn, $deleteShowtimeQuery)) {
        echo "<script>
                alert('Jadwal tayang berhasil dihapus.');
                window.location.href = 'showtimes.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location.href = 'showtimes.php';
              </script>";
    }
}


if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $editQuery = "SELECT * FROM showtimes WHERE showtime_id = '$edit_id'";
    $editResult = mysqli_query($conn, $editQuery);
    $editData = mysqli_fetch_assoc($editResult);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cinema_movie_id = mysqli_real_escape_string($conn, $_POST['cinema_movie_id']);
    $show_date_start = mysqli_real_escape_string($conn, $_POST['show_date_start']);
    $show_date_end = mysqli_real_escape_string($conn, $_POST['show_date_end']);
    $show_time = mysqli_real_escape_string($conn, $_POST['show_time']);
    $studio = mysqli_real_escape_string($conn, $_POST['studio']);

    $start_date = strtotime($show_date_start);
    $end_date = strtotime($show_date_end);

    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $updateQuery = "UPDATE showtimes SET cinema_movie_id = '$cinema_movie_id', show_date = '$show_date_start', show_time = '$show_time', studio = '$studio' WHERE showtime_id = '$edit_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>
                    alert('Jadwal tayang berhasil diupdate.');
                    window.location.href = 'showtimes.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . mysqli_error($conn) . "');
                    window.location.href = 'showtimes.php';
                  </script>";
        }
    } else {
        while ($start_date <= $end_date) {
            $current_date = date("Y-m-d", $start_date);
            $insertQuery = "INSERT INTO showtimes (cinema_movie_id, show_date, show_time, studio) VALUES ('$cinema_movie_id', '$current_date', '$show_time', '$studio')";
            mysqli_query($conn, $insertQuery);
            $start_date = strtotime("+1 day", $start_date);
        }
        echo "<script>
                alert('Jadwal tayang berhasil ditambahkan.');
                window.location.href = 'showtimes.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php'; ?>
    <title>YeoFlix</title>
</head>

<body>
    <?php header('components/headerAdmin.php'); ?>

    <div class="sidebar">
        <a href="index.html" class="sidebar__logo">
        </a>
        <?php include 'components/sidebar.php'; ?>
    </div>

    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main__title">
                        <h2>Showtime</h2>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="add-showtime" role="tabpanel">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <form action="" method="POST" class="sign__form sign__form--profile">
                                        <input type="hidden" name="edit_id" value="<?php echo isset($editData['showtime_id']) ? $editData['showtime_id'] : ''; ?>">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="cinemaMovieId">Bioskop dan Film</label>
                                                    <select id="cinemaMovieId" name="cinema_movie_id" class="sign__input" required>
                                                        <option value="">Pilih Bioskop dan Film</option>
                                                        <?php
                                                        $query = "SELECT cm.cinema_movie_id, c.cinema_name, m.title 
                                                  FROM cinema_movies cm 
                                                  JOIN cinemas c ON cm.cinema_id = c.cinema_id 
                                                  JOIN movies m ON cm.movie_id = m.movie_id 
                                                  ORDER BY c.cinema_name, m.title ASC";
                                                        $cinemaMovies = mysqli_query($conn, $query);
                                                        while ($cinemaMovie = mysqli_fetch_assoc($cinemaMovies)) {
                                                            $selected = isset($editData['cinema_movie_id']) && $editData['cinema_movie_id'] == $cinemaMovie['cinema_movie_id'] ? 'selected' : '';
                                                            echo "<option value='{$cinemaMovie['cinema_movie_id']}' $selected>{$cinemaMovie['cinema_name']} - {$cinemaMovie['title']}</option>";
                                                        }
                                                        ?>
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="studio">Studio</label>
                                                    <select id="studio" name="studio" class="sign__input" required>
                                                        <option value="">Pilih Studio</option>
                                                        <option value="Studio A" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio A' ? 'selected' : ''; ?>>Studio A</option>
                                                        <option value="Studio B" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio B' ? 'selected' : ''; ?>>Studio B</option>
                                                        <option value="Studio C" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio C' ? 'selected' : ''; ?>>Studio C</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="sign__group">
                                                    <label for="showDateStart" class="sign__label">Tanggal Mulai</label>
                                                    <input id="showDateStart" type="date" class="sign__input" name="show_date_start" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="sign__group">
                                                    <label for="showDateEnd" class="sign__label">Tanggal Akhir</label>
                                                    <input id="showDateEnd" type="date" class="sign__input" name="show_date_end" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="showTime">Waktu Tayang</label>
                                                    <input id="showTime" type="time" class="sign__input" name="show_time" value="<?php echo isset($editData['show_time']) ? $editData['show_time'] : ''; ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="sign__btn sign__btn--small" type="submit"><span><?php echo isset($editData) ? 'Update Showtime' : 'Simpan Showtime'; ?></span></button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <?php
                            // Koneksi ke database
                            $conn = mysqli_connect("localhost", "root", "", "db_ticket");
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT st.showtime_id, c.cinema_name, m.title AS movie_title, st.show_date, st.show_time, st.studio
                            FROM showTimes st
                            JOIN cinema_movies cm ON st.cinema_movie_id = cm.cinema_movie_id
                            JOIN cinemas c ON cm.cinema_id = c.cinema_id
                            JOIN movies m ON cm.movie_id = m.movie_id
                            ORDER BY st.show_date, st.show_time";
                            $result = mysqli_query($conn, $sql);
                            ?>

                            <div class="col-12">
                                <div class="catalog catalog--1">
                                    <table class="catalog__table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bioskop & Film</th>
                                                <th>Tanggal Tayang</th>
                                                <th>Waktu Tayang</th>
                                                <th>Studio</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>
                                <td><div class='catalog__text'>{$no}</div></td>
                                <td><div class='catalog__text'>{$row['cinema_name']} - {$row['movie_title']}</div></td>
                                <td><div class='catalog__text'>" . date("d-m-Y", strtotime($row['show_date'])) . "</div></td>
                                <td><div class='catalog__text'>" . date("H:i", strtotime($row['show_time'])) . "</div></td>
                                <td><div class='catalog__text'>{$row['studio']}</div></td>
                                <td>
                                    <div class='catalog__btns'>
                                        <a href='?edit_id={$row['showtime_id']}'>
                                            <button type='button' class='catalog__btn catalog__btn--view' style='margin-right: 10px;'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                        </a>
                                        <a href='?delete_id={$row['showtime_id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus jadwal tayang ini?\");'>
                                            <button type='button' class='catalog__btn catalog__btn--delete'>
                                                <i class='bi bi-trash3'></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>";
                                                    $no++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'><div class='catalog__text' style='text-align:center;'>Tidak ada data jadwal tayang.</div></td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/slimselect.min.js"></script>
    <script src="js/smooth-scrollbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>