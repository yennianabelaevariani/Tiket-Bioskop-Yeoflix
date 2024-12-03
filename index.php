<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YeoFlix</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pengguna/grid.css">
    <link rel="stylesheet" href="pengguna/app.css">
</head>

<body>
    <div class="nav-wrapper">
        <div class="container">
            <div class="nav">
                <a href="#" class="logo">
                    <i class=' bx-tada main-color'></i>Yeo<span class="main-color">F</span>lix
                </a>
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Movies</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li>
                        <a href="signin.php" class="btn btn-hover">
                            <span>Sign in</span>
                        </a>
                    </li>

                </ul>
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger"></div>
                </div>
            </div>
        </div> 
    </div>
<!-- pemilihan kota -->
    <!-- <div class="dropdown-container">
        <div class="dropdown-item">
            <div class="container">
                <div class="heading-twenty">
                    <h3>City</h3>
                    <div class="select-twenty">
                        <select class="custom-select">
                            <option value="77">Malang</option>
                            <option value="77">Surabaya</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="container">
                <div class="heading-twenty">
                    <h3>Cinemas</h3>
                    <div class="select-twenty">
                        <select class="custom-select">
                            <option value="77">BioskopSBY</option>
                            <option value="77">CabangMLG</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!-- end pemilihan kota -->

    <div class="section">
        <div class="container">
            <div class="heading-twenty">
                <h3>Now Playing</h3>
            </div>
            <div class="movies-slide carousel-nav-center owl-carousel p-3" style="margin-top: 2rem;">
                <?php
                include "koneksi.php";
                $today = date('Y-m-d');
                $sql = "
                SELECT m.*, cm.cinema_id
                FROM movies m
                JOIN cinema_movies cm ON m.movie_id = cm.movie_id
                JOIN showTimes s ON cm.cinema_movie_id = s.cinema_movie_id
                WHERE s.show_date = '$today' AND m.status = 'Visible'
            ";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <a href="details.php?id=<?= $row['movie_id'] ?>" class="movie-item">
                            <img src="admin/assets/upload/thumbnail/<?= $row['thumbnail'] ?>" alt="<?= $row['title'] ?>">
                            <div class="movie-item-content">
                                <div class="movie-item-title">
                                    <?= $row['title'] ?>
                                </div>
                                <div class="movie-infos">
                                    <div class="movie-info">
                                        <i class="bx bxs-time"></i>
                                        <span>
                                            <?= $row['duration'] ?>
                                        </span>
                                    </div>
                                    <div class="movie-info">
                                        <span>
                                            <?= $row['age_rating'] . "+"; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                <?php
                    }
                } else {
                    echo "<p>No movies are currently playing.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="section-header">
                Movies
            </div>
            <div class="movies-slide carousel-nav-center owl-carousel p-3">
                <?php
                $sqlMovies = "SELECT * FROM movies WHERE status = 'Visible'";
                $resultMovies = mysqli_query($conn, $sqlMovies);

                if (mysqli_num_rows($resultMovies) > 0) {
                    while ($movie = mysqli_fetch_assoc($resultMovies)) {
                ?>
                        <a href="details.php?id=<?= $movie['movie_id'] ?>" class="movie-item">
                            <img src="admin/assets/upload/thumbnail/<?= $movie['thumbnail'] ?>" alt="<?= $movie['title'] ?>">
                            <div class="movie-item-content">
                                <div class="movie-item-title">
                                    <?= $movie['title'] ?>
                                </div>
                                <div class="movie-infos">
                                    <div class="movie-info">
                                        <i class="bx bxs-time"></i>
                                        <span>
                                            <?= $movie['duration'] ?>
                                        </span>
                                    </div>
                                    <div class="movie-info">
                                        <span>
                                            <?= $movie['age_rating'] . "+"; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                <?php
                    }
                } else {
                    echo "<p>No movies available.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
    <script src="pengguna/app.js"></script>

</body>

</html>