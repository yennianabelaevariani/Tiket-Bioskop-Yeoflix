<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php'; ?>
    <title>YeoFlix</title>
</head>

<body>
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
                        <h2>Bookings </h2>
                    </div>
                </div>
            </div>
            <div class="main__title-wrap">
                <a href="add_Cinema.php" class="main__title-link main__title-link--wrap">Add Cinemas</a>
            </div>

            <div class="col-12">
                <div class="catalog catalog--1">
                    <table class="catalog__table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Booking</th>
                                <th>Username</th>
                                <th>Studio</th>
                                <th>Tanggal Booking</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            include '../koneksi.php';

                            // Query untuk mengambil data booking, username dari tabel users, dan studio dari tabel showtimes
                            $sql = "SELECT b.booking_id, u.username AS username, s.studio AS studio, b.booking_date, b.total_price
                                    FROM bookings b
                                    JOIN users u ON b.user_id = u.user_id
                                    JOIN showtimes s ON b.showtime_id = s.showtime_id
                                    ORDER BY b.booking_date ASC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td><div class='catalog__text'>{$no}</div></td>
                                            <td><div class='catalog__text'>{$row['booking_id']}</div></td>
                                            <td><div class='catalog__text'>{$row['username']}</div></td>
                                            <td><div class='catalog__text'>{$row['studio']}</div></td>
                                            <td><div class='catalog__text'>{$row['booking_date']}</div></td>
                                            <td><div class='catalog__text'>{$row['total_price']}</div></td>
                                            <td>
                                                <div class='catalog__btns'>
                                                    <a href='edit-booking.php?id={$row['booking_id']}' class='catalog__btn catalog__btn--view'>
                                                        <i class='bi bi-pencil-square'></i>
                                                    </a>
                                                    <button type='button' data-bs-toggle='modal' class='catalog__btn catalog__btn--delete' data-bs-target='#modal-delete'>
                                                        <i class='bi bi-trash3'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'><div class='catalog__text'>Tidak ada data booking tersedia.</div></td></tr>";
                            }
                            ?>

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/slimselect.min.js"></script>
    <script src="js/smooth-scrollbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>