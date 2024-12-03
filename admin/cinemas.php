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
		<a href="index.php" class="sidebar__logo"></a>
		<?php include 'components/sidebar.php'; ?>
	</div>
	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="main__title">
						<h2>Cinemas</h2>
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
								<th>Nama Biokop</th>
								<th>Kota</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
    <?php
    include '../koneksi.php';

    $sql = "SELECT c.cinema_id, c.cinema_name, ci.city_name
            FROM cinemas c
            JOIN cities ci ON c.city_id = ci.city_id
            ORDER BY c.cinema_name ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td><div class='catalog__text'>{$no}</div></td>
                    <td><div class='catalog__text'>{$row['cinema_name']}</div></td>
                    <td><div class='catalog__text'>{$row['city_name']}</div></td>
                    <td>
                        <div class='catalog__btns'>
                            <a href='edit-cinemas.php?id={$row['cinema_id']}' class='catalog__btn catalog__btn--view'>
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
        echo "<tr><td colspan='4'><div class='catalog__text'>Tidak ada data bioskop tersedia.</div></td></tr>";
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