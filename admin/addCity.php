<?php
include '../koneksi.php';

$edit_city_id = null;
$edit_city_name = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_city'])) {
    $city_name = $_POST['city_name'];

    $stmt = $conn->prepare("INSERT INTO cities (city_name) VALUES (?)");
    $stmt->bind_param("s", $city_name);

    if ($stmt->execute()) {
        echo "<script>alert('Kota berhasil ditambahkan!'); window.location.href='addCity.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_city'])) {
    $city_id = $_POST['city_id'];
    $city_name = $_POST['city_name'];

    $stmt = $conn->prepare("UPDATE cities SET city_name = ? WHERE city_id = ?");
    $stmt->bind_param("si", $city_name, $city_id);

    if ($stmt->execute()) {
        echo "<script>alert('Kota berhasil diperbarui!'); window.location.href='addCity.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

if (isset($_GET['delete_id'])) {
    $city_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM cities WHERE city_id = ?");
    $stmt->bind_param("i", $city_id);

    if ($stmt->execute()) {
        echo "<script>alert('Kota berhasil dihapus!'); window.location.href='addCity.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

if (isset($_GET['edit_id'])) {
    $edit_city_id = $_GET['edit_id'];

    $stmt = $conn->prepare("SELECT city_name FROM cities WHERE city_id = ?");
    $stmt->bind_param("i", $edit_city_id);
    $stmt->execute();
    $stmt->bind_result($edit_city_name);
    $stmt->fetch();
    $stmt->close();
}

$sql = "SELECT * FROM cities";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'components/link.php'; ?>
    <title>YeoFlix</title>
</head>

<body>
    <?php include 'components/headerAdmin.php'; ?>

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
                        <h2>Add City</h2>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab" tabindex="0">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <form action="" method="POST" class="sign__form sign__form--profile">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="sign__title">Add City</h4>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="sign__group">
                                                    <label class="sign__label" for="Bioskop">Nama Kota</label>
                                                    <input id="Bioskop" type="text" name="city_name" class="sign__input" placeholder="Name of city" required value="<?php echo htmlspecialchars($edit_city_name); ?>">
                                                    <input type="hidden" name="city_id" value="<?php echo $edit_city_id; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="sign__btn sign__btn--small" name="<?php echo isset($edit_city_id) ? 'edit_city' : 'add_city'; ?>" type="submit"><span><?php echo isset($edit_city_id) ? 'Update' : 'Save'; ?></span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="catalog catalog--1">
                        <table class="catalog__table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kota</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td>
                                            <div class="catalog__text"><?php echo $no++; ?></div>
                                        </td>
                                        <td>
                                            <div class="catalog__text"><?php echo htmlspecialchars($row['city_name']); ?></div>
                                        </td>
                                        <td>
                                            <div class="catalog__btns">
                                                <a href="?edit_id=<?php echo $row['city_id']; ?>">
                                                    <button type="button" class="catalog__btn catalog__btn--view" style="margin-right: 10px;">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </a>

                                                <a href="?delete_id=<?php echo $row['city_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kota ini?');">
                                                    <button type="button" class="catalog__btn catalog__btn--delete">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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