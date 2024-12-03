<style>
    body {
        background-color: #121212;
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 700px;
    }

    .card {
        background-color: #1e1e1e;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .card-title {
        color: #f9ab00;
    }

    .form-group label {
        color: #e0e0e0;
    }

    .btn {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        height: 46px;
        width: 100%;
        border-radius: 8px;
        background-color: transparent;
        font-size: 14px;
        color: #fff;
        text-transform: uppercase;
        border: 2px solid #f9ab00;
        margin-top: 10px;
    }

    .btn:hover {
        color: #fff;
    }

    h2 {
        color: #f9ab00;
    }

    .card p {
        color: #b0b0b0;
    }

    input[type="number"] {
        background-color: #333;
        border: 1px solid #555;
        color: #e0e0e0;
    }

    input[type="number"]::placeholder {
        color: #888;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php'; ?>
    <title>YeoFlix</title>
</head>

<body>
    <header class="header">
        <div class="header__content">
            <a href="index.html" class="header__logo"></a>
            <button class="header__btn" type="button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <div class="sidebar">
        <a href="index.html" class="sidebar__logo"></a>
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
                        <div class="col-12 col-lg-6">
                            <form action="" method="POST" class="sign__form sign__form--profile">
                                <input type="hidden" name="edit_id" value="<?php echo isset($editData['showtime_id']) ? $editData['showtime_id'] : ''; ?>">

                                <div class="sign__group">
                                    <label for="cinemaMovieId" class="sign__label">Bioskop dan Film</label>
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
                                    </select>
                                </div>

                                <div class="sign__group">
                                    <label for="studio" class="sign__label">Studio</label>
                                    <select id="studio" name="studio" class="sign__input" required>
                                        <option value="">Pilih Studio</option>
                                        <option value="Studio A" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio A' ? 'selected' : ''; ?>>Studio A</option>
                                        <option value="Studio B" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio B' ? 'selected' : ''; ?>>Studio B</option>
                                        <option value="Studio C" <?php echo isset($editData['studio']) && $editData['studio'] == 'Studio C' ? 'selected' : ''; ?>>Studio C</option>
                                    </select>
                                </div>

                                <div class="sign__group">
                                    <label for="showDateStart" class="sign__label">Tanggal Mulai</label>
                                    <input id="showDateStart" type="date" class="sign__input" name="show_date_start" required>
                                </div>

                                <div class="sign__group">
                                    <label for="showDateEnd" class="sign__label">Tanggal Akhir</label>
                                    <input id="showDateEnd" type="date" class="sign__input" name="show_date_end" required>
                                </div>

                                <div class="sign__group">
                                    <label for="showTime" class="sign__label">Waktu Tayang</label>
                                    <input id="showTime" type="time" class="sign__input" name="show_time" required>
                                </div>

                                <button class="sign__btn" type="submit"><span><?php echo isset($editData) ? 'Update Showtime' : 'Simpan Showtime'; ?></span></button>
                            </form>
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
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/slimselect.min.js"></script>
    <script src="js/smooth-scrollbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>