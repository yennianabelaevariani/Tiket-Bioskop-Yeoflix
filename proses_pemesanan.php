<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_pembeli = $_POST['nama_pembeli'] ?? null;
    $no_tlp = $_POST['no_tlp'] ?? null;
    $city_id = $_POST['kota'] ?? null;
    $cinema_id = $_POST['bioskop'] ?? null;
    $studio = $_POST['studio'] ?? null;
    $showtime_id = $_POST['waktu_nonton'] ?? null;
    $seats = $_POST['kursi'] ?? null;

    if (empty($nama_pembeli) || empty($no_tlp) || empty($city_id) || empty($cinema_id) || empty($studio) || empty($showtime_id) || empty($seats)) {
        echo "Data tidak valid. Semua field harus diisi.";
        exit;
    }

    $nama_pembeli = mysqli_real_escape_string($conn, $nama_pembeli);
    $no_tlp = mysqli_real_escape_string($conn, $no_tlp);
    $city_id = mysqli_real_escape_string($conn, $city_id);
    $cinema_id = mysqli_real_escape_string($conn, $cinema_id);
    $studio = mysqli_real_escape_string($conn, $studio);
    $showtime_id = mysqli_real_escape_string($conn, $showtime_id);
    $seats = array_map(function($seat) use ($conn) {
        return mysqli_real_escape_string($conn, $seat);
    }, $seats);

    session_start();
    $user_id = $_SESSION['user_id'];

    mysqli_begin_transaction($conn);

    try {
        $total_price = count($seats) * 30000; 

        $stmt = $conn->prepare("INSERT INTO bookings (user_id, showtime_id, booking_date, total_price) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("iis", $user_id, $showtime_id, $total_price);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $booking_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO transactions (booking_id, payment_method, payment_status, payment_date, amount) VALUES (?, 'cash', 'paid', NOW(), ?)");
        $stmt->bind_param("id", $booking_id, $total_price);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $transaction_id = $stmt->insert_id;
        $stmt->close();

        foreach ($seats as $seat_id) {
            
            $stmt = $conn->prepare("INSERT INTO transaction_details (transaction_id, seat_id, price) VALUES (?, ?, ?)");
            $price = 30000; 
            $stmt->bind_param("isi", $transaction_id, $seat_id, $price);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $stmt = $conn->prepare("INSERT INTO booked_seats (booking_id, seat_id) VALUES (?, ?)");
            $stmt->bind_param("is", $booking_id, $seat_id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
        }

        mysqli_commit($conn);

        header("Location: konfirmasi.php?booking_id=$booking_id");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Request tidak valid.";
}
