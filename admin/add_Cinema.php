<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
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
    <?php
    $conn = mysqli_connect("localhost", "root", "", "db_ticket");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cinema_name = mysqli_real_escape_string($conn, $_POST['cinema_name']);
        $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
        $sql = "INSERT INTO cinemas (cinema_name, city_id) VALUES ('$cinema_name', '$city_id')";
        if (mysqli_query($conn, $sql)) {
            $message = "Bioskop berhasil ditambahkan.";
            header("Location: cinemas.php");
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
    ?>

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
                        <h2>Tambah Bioskop</h2>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="add-cinema" role="tabpanel" aria-labelledby="add-cinema-tab" tabindex="0">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <form action="" method="POST" class="sign__form sign__form--profile">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="sign__title">Tambah Bioskop</h4>
                                            </div>
                                            <div class="col-12">
                                                <?php if (!empty($message)): ?>
                                                    <div class="alert alert-info"><?php echo $message; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="cinemaName">Nama Bioskop</label>
                                                    <input id="cinemaName" type="text" name="cinema_name" class="sign__input" placeholder="Nama Bioskop" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="cityId">Kota</label>
                                                    <select id="cityId" name="city_id" class="sign__input" required>
                                                        <option value="">Pilih Kota</option>
                                                        <?php
                                                        $cities = mysqli_query($conn, "SELECT city_id, city_name FROM cities");
                                                        if ($cities) {
                                                            while ($city = mysqli_fetch_assoc($cities)) {
                                                                echo "<option value='{$city['city_id']}'>{$city['city_name']}</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=''>Tidak ada data kota</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="sign__btn sign__btn--small" type="submit"><span>Simpan Bioskop</span></button>
                                            </div>
                                        </div>
                                    </form>
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