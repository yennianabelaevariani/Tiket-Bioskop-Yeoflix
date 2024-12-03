<?php
include "koneksi.php";
session_start();

$booking_id = isset($_GET['booking_id']) ? mysqli_real_escape_string($conn, $_GET['booking_id']) : null;

if (!$booking_id) {
    echo "Booking ID tidak valid.";
    exit;
}

$stmt = $conn->prepare("SELECT b.user_id, b.total_price, t.amount, s.show_date, s.show_time, 
                               GROUP_CONCAT(se.seat_id) AS seats, u.username AS user_name
                         FROM bookings b
                         JOIN transactions t ON b.booking_id = t.booking_id
                         JOIN showtimes s ON b.showtime_id = s.showtime_id
                         JOIN booked_seats bs ON b.booking_id = bs.booking_id
                         JOIN seats se ON bs.seat_id = se.seat_id
                         JOIN users u ON b.user_id = u.user_id
                         WHERE b.booking_id = ?
                         GROUP BY b.user_id, b.total_price, s.show_date, s.show_time, t.amount, u.username");

$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking_details = $result->fetch_assoc();
} else {
    echo "Data booking tidak ditemukan.";
    exit;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Konfirmasi Pemesanan</title>
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
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Konfirmasi Pemesanan Tiket</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Detail Pemesanan</h5>
                <p><strong>Nama Pengguna:</strong> <?= htmlspecialchars($booking_details['user_name']) ?></p>
                <p><strong>Total Harga:</strong> Rp <?= number_format(htmlspecialchars($booking_details['total_price']), 0, ',', '.') ?></p>
                <p><strong>Tanggal:</strong> <?= htmlspecialchars($booking_details['show_date']) ?></p>
                <p><strong>Jam:</strong> <?= htmlspecialchars($booking_details['show_time']) ?></p>
                <p><strong>ID Kursi:</strong> <?= htmlspecialchars($booking_details['seats']) ?></p>

                <form method="POST" action="proseskonformasi.php" class="mt-4">
                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                    <div class="form-group">
                        <label for="amount">Masukkan Jumlah Uang:</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-pri">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>