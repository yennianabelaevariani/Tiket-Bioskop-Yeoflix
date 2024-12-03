<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/splide.min.css">
    <link rel="stylesheet" href="css/slimselect.css">
    <link rel="stylesheet" href="css/plyr.css">
    <link rel="stylesheet" href="css/photoswipe.css">
    <link rel="stylesheet" href="css/default-skin.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="webfont/tabler-icons.min.css">
    <title>YeoFlix</title>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: signin.php");
        exit;
    }

    include "koneksi.php";

    $queryKota = "SELECT * FROM cities";
    $resultKota = mysqli_query($conn, $queryKota);
    if (!$resultKota) {
        die("Error fetching cities: " . mysqli_error($conn));
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM movies WHERE movie_id='$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
        } else {
            echo "<h2>Film tidak ditemukan</h2>";
            exit;
        }
    } else {
        echo "<h2>ID film tidak ditentukan</h2>";
        exit;
    }
    ?>

    ?>
    <section class="container mt-5">
        <div class="row">
            <div class="col-12 mb-5">
                <h1 class="section__title section__title--head"><?= htmlspecialchars($data['title']) ?></h1>
            </div>
            <div class="col-12 d-flex align-items-start gap-5">
                <div class="col-3">
                    <img src="admin/assets/upload/thumbnail/<?= htmlspecialchars($data['thumbnail']) ?>" alt="<?= htmlspecialchars($data['title']) ?>" class="img-fluid rounded shadow-lg w-100">
                </div>
                <div class="col-9">
                    <form action="proses_pemesanan.php" method="POST" class="col-md-10 p-5">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="namaPembeli">Nama pembeli</label>
                                    <input id="namaPembeli" type="text" name="nama_pembeli" class="sign__input" placeholder="nama pembeli" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="noTlp">No telephone</label>
                                    <input id="noTlp" type="text" name="no_tlp" class="sign__input" placeholder="nomor telepon" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="kota">Kota</label>
                                    <select id="kota" name="kota" class="sign__input" required>
                                        <option value="">Pilih Kota</option>
                                        <?php while ($row = mysqli_fetch_assoc($resultKota)) : ?>
                                            <option value="<?= htmlspecialchars($row['city_id']) ?>"><?= htmlspecialchars($row['city_name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="bioskop">Bioskop</label>
                                    <select id="bioskop" name="bioskop" class="sign__input" required>
                                        <option value="">Pilih Bioskop</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="studio">Studio</label>
                                    <select id="studio" name="studio" class="sign__input" required>
                                        <option value="">Pilih Studio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="waktuNonton">Pilih tanggal & waktu</label>
                                    <select id="waktuNonton" name="waktu_nonton" class="sign__input" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sign__group">
                                    <label class="sign__label" for="jumlahTiket">Jumlah Tiket</label>
                                    <select id="jumlahTiket" name="jumlah_tiket" class="sign__input" required>
                                        <option value="">Pilih Jumlah Tiket</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>       
                            </div>
                            <?php
                            include 'koneksi.php'; 
                            $bookedSeats = [];
                            $query = "SELECT seat_id FROM booked_seats";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $bookedSeats[] = $row['seat_id']; 
                            }
                            ?>

                            <div class="container mt-4">
                                <h3 class="text-white mb-3">Pilih Kursi</h3>
                                <div class="row justify-content-center">
                                    <?php for ($seatIndex = 1; $seatIndex <= 10; $seatIndex++): ?>
                                        <div class="col-12 mb-2">
                                            <div class="row justify-content-center">
                                                <?php for ($row = 'A'; $row <= 'I'; $row++): ?>
                                                    <?php
                                                    $seatID = $row . $seatIndex;
                                                    $isBooked = in_array($seatID, $bookedSeats); 
                                                    ?>
                                                    <div class="col-auto mb-2">
                                                        <div class="seat-wrapper text-center">
                                                            <?php if ($isBooked): ?>
                                                                <input type="checkbox" class="form-check-input d-none" id="seat_<?php echo $seatID; ?>" disabled onclick="showAlert('<?php echo $seatID; ?>')">
                                                                <label class="seat-label seat-booked" onclick="showAlert('<?php echo $seatID; ?>')" for="seat_<?php echo $seatID; ?>">
                                                                    <?php echo $seatID; ?>
                                                                </label>
                                                            <?php else: ?>
                                                                <input type="checkbox" class="form-check-input d-none" id="seat_<?php echo $seatID; ?>" name="kursi[]" value="<?php echo $seatID; ?>">
                                                                <label class="seat-label seat-available" for="seat_<?php echo $seatID; ?>">
                                                                    <?php echo $seatID; ?>
                                                                </label>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php if (in_array($row, ['C', 'F'])): ?>
                                                        <div class="col-1"></div> 
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <script>
                                function showAlert(seatID) {
                                    alert("Kursi " + seatID + " sudah dipilih.");
                                }
                            </script>

                            </script>

                            <style>
                                .seat-wrapper {
                                    width: 40px;
                                    height: 40px;
                                }

                                .seat-label {
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    width: 100%;
                                    height: 100%;
                                    font-weight: bold;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    transition: background-color 0.3s ease;
                                }

                                .seat-available {
                                    background-color: #ffffff;
                                    color: #333;
                                    border: 2px solid #444;
                                }

                                .seat-available:hover {
                                    background-color: #007bff;
                                    color: #fff;
                                }

                                .seat-booked {
                                    background-color: #8B0000;
                                    color: #fff;
                                    cursor: not-allowed;
                                }

                                .form-check-input:checked+.seat-available {
                                    background-color: #28a745;
                                    color: #fff;
                                    border-color: #28a745;
                                }

                                .row {
                                    margin-left: -5px;
                                    margin-right: -5px;
                                }

                                .col-auto {
                                    padding-left: 5px;
                                    padding-right: 5px;
                                }
                            </style>


                            <div class="col-5 text-end">
                                <button class="sign__btn sign__btn--modal" type="submit">Submit</button>
                            </div>
                    </form>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('#kota').change(function() {
                                    const cityId = $(this).val();
                                    const movieId = <?= json_encode($data['movie_id']); ?>;
                                    if (cityId) {
                                        $.post('get_cinemas.php', {
                                            city_id: cityId,
                                            movie_id: movieId
                                        }, function(data) {
                                            $('#bioskop').html(data);
                                        });
                                    } else {
                                        $('#bioskop').html('<option value="">Pilih Bioskop</option>');
                                    }
                                });
                                $('#bioskop').change(function() {
                                    const cinemaId = $(this).val();
                                    const movieId = <?= json_encode($data['movie_id']); ?>;
                                    if (cinemaId) {
                                        $.post('get_showtimes.php', {
                                            cinema_id: cinemaId,
                                            movie_id: movieId
                                        }).done(function(data) {
                                            if (data) {
                                                $('#waktuNonton').html(data);
                                            } else {
                                                $('#waktuNonton').html('<option value="">Tidak ada waktu tayang yang tersedia</option>');
                                            }
                                        }).fail(function() {
                                            alert('Gagal mengambil waktu tayang. Silakan coba lagi.');
                                        });
                                    } else {
                                        $('#waktuNonton').html('<option value="">Pilih Waktu Nonton</option>');
                                    }
                                });
                                $('#bioskop').change(function() {
                                    const cinemaId = $(this).val();
                                    const movieId = <?= json_encode($data['movie_id']); ?>;
                                    if (cinemaId) {
                                        $.post('get_studios.php', {
                                            cinema_id: cinemaId,
                                            movie_id: movieId
                                        }, function(data) {
                                            $('#studio').html(data);
                                        });
                                    } else {
                                        $('#studio').html('<option value="">Pilih Studio</option>');
                                    }
                                });
                                $('#waktuNonton').change(function() {
                                    const showtimeId = $(this).val();
                                    const cinemaId = $('#bioskop').val();
                                    $.post('get_seats.php', {
                                        showtime_id: showtimeId,
                                        cinema_id: cinemaId
                                    }, function(data) {
                                        const seatData = JSON.parse(data);
                                        $('.form-check-input').prop('disabled', false);
                                        seatData.forEach(function(seat) {
                                            $('#seat_' + seat).prop('disabled', true).prop('checked', false);
                                        });
                                    });
                                });

                                function validateSeatSelection() {
                                    const selectedSeats = $('input[name="kursi[]"]:checked').length;
                                    const ticketCount = parseInt($('#jumlahTiket').val());

                                    if (selectedSeats !== ticketCount) {
                                        const message = selectedSeats < ticketCount ?
                                            `Anda harus memilih ${ticketCount} kursi. Anda baru memilih ${selectedSeats} kursi.` :
                                            `Anda hanya boleh memilih ${ticketCount} kursi. Anda telah memilih ${selectedSeats} kursi.`;
                                        alert(message);
                                        return false;
                                    }
                                    return true;
                                }

                                $('form').submit(function(e) {
                                    if (!validateSeatSelection()) {
                                        e.preventDefault(); 
                                    }
                                });

                                $('input[name="kursi[]"]').change(function() {
                                    const selectedSeats = $('input[name="kursi[]"]:checked').length;
                                    const ticketCount = parseInt($('#jumlahTiket').val());

                                    if (selectedSeats > ticketCount) {
                                        $(this).prop('checked', false);
                                        alert(`Anda hanya dapat memilih ${ticketCount} kursi sesuai dengan jumlah tiket.`);
                                    }
                                });

                                $('#jumlahTiket').change(function() {
                                    $('input[name="kursi[]"]').prop('checked', false); 
                                });
                            });
                        </script>
                </div>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/splide.min.js"></script>
    <script src="js/slimselect.min.js"></script>
    <script src="js/plyr.polyfilled.js"></script>
    <script src="js/photoswipe.min.js"></script>
    <script src="js/photoswipe-ui-default.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>