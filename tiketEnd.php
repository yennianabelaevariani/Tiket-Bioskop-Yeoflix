<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket yang Dibeli</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin|Indie+Flower|Inknut+Antiqua|Lora|Ravi+Prakash" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #121212;
            font-family: 'Inknut Antiqua', serif, 'Ravi Prakash', cursive, 'Lora', serif, 'Indie Flower', cursive, 'Cabin', sans-serif;
            padding: 20px;
            color: #e0e0e0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .upcomming {
            font-size: 28px;
            text-transform: uppercase;
            border-bottom: 2px solid #f9ab00;
            padding-bottom: 8px;
            margin-bottom: 20px;
            color: #f9ab00;
            text-align: center;
        }

        .item {
            display: flex;
            background: #1e1e1e;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            padding: 15px;
            justify-content: space-between;
        }

        .item-right {
            width: 70px;
            text-align: center;
            margin-right: 15px;
        }

        .item-right .num {
            font-size: 40px;
            color: #f9ab00;
        }

        .item-right .day {
            font-size: 16px;
            color: #888;
        }

        .item-left {
            flex-grow: 1;
        }

        .title {
            color: #f9ab00;
            font-size: 20px;
            margin: 10px 0;
        }

        .event {
            color: #b0b0b0;
            font-size: 14px;
        }

        .ticket-code {
            margin-top: 10px;
            background: #2e2e2e;
            padding: 10px;
            border-radius: 4px;
            font-size: 20px;
            text-align: center;
            color: #f9ab00;
        }

        .ticket-code h2 {
            font-size: 28px;
            font-weight: bold;
        }

        .small {
            color: #ff4d4d;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="upcomming">Tiket Anda</h1>
        <?php
        include 'koneksi.php';

        // Fungsi untuk menghasilkan kode acak
        function generateRandomCode($length = 6)
        {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $randomCode = '';
            for ($i = 0; $i < $length; $i++) {
                $randomCode .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomCode;
        }

        $booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

        if ($booking_id > 0) {
            $booking_query = "SELECT b.*, t.payment_method, t.payment_status, t.payment_date, m.title, sh.show_time, s.seat_number, s.row_label
                          FROM bookings b
                          JOIN transactions t ON b.booking_id = t.booking_id
                          JOIN showtimes sh ON b.showtime_id = sh.showtime_id
                          JOIN cinema_movies cm ON sh.cinema_movie_id = cm.cinema_movie_id
                          JOIN movies m ON cm.movie_id = m.movie_id
                          JOIN booked_seats bs ON b.booking_id = bs.booking_id
                          JOIN seats s ON bs.seat_id = s.seat_id
                          WHERE b.booking_id = $booking_id";

            $result = mysqli_query($conn, $booking_query);

            if (mysqli_num_rows($result) > 0) {
                while ($ticket = mysqli_fetch_assoc($result)) {
                    $date = date('l, d F Y', strtotime($ticket['booking_date']));
                    $time = isset($ticket['show_time']) ? $ticket['show_time'] : 'Waktu tidak tersedia';
                    $title = isset($ticket['title']) ? htmlspecialchars($ticket['title']) : 'Judul tidak tersedia';
                    $seat_info = isset($ticket['row_label']) && isset($ticket['seat_number']) ? $ticket['row_label'] . ' ' . $ticket['seat_number'] : 'Kursi tidak tersedia';

                    echo '<div class="item">';
                    echo '    <div class="item-right">';
                    echo '        <h2 class="num">' . htmlspecialchars($ticket['booking_id']) . '</h2>';
                    echo '        <p class="day">' . date('M', strtotime($ticket['booking_date'])) . '</p>';
                    echo '    </div>';
                    echo '    <div class="item-left">';
                    echo '        <p class="event">' . $title . '</p>';
                    echo '        <p class="event">Tanggal: ' . $date . ' - Waktu: ' . $time . '</p>';
                    // Menampilkan kode tiket
                    for ($i = 0; $i < 1; $i++) {
                        $randomCode = generateRandomCode(6); // Generate kode acak 6 karakter
                        echo '        <div class="ticket-code"><h2>Kode Tiket: ' . htmlspecialchars($randomCode) . '</h2></div>';
                    }
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tiket tidak ditemukan.</p>';
            }
        } else {
            echo '<p>Parameter tiket tidak valid.</p>';
        }
        ?>
    </div>

</body>

</html>