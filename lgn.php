    <?php
    include 'koneksi.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $getUser = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $getUser->bind_param("s", $email);
        $getUser->execute();
        $result = $getUser->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true; 

            if ($user['role'] === 'admin') {
                echo "<script>alert('Login sebagai admin berhasil!'); window.location.href='admin/index.php';</script>";
            } else {
                echo "<script>alert('Login berhasil!'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Username atau password salah.'); window.location.href='signin.php';</script>";
        }
    }
