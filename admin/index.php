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
	<?php include 'components/link.php' ?>
	<title>YeoFlix</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
</head>

<body>
	<?php include 'components/headerAdmin.php'; ?>

	<div class="sidebar">
		<a href="index.html" class="sidebar__logo">
			
		</a>
		<?php include 'components/sidebar.php' ?>
	</div>
	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="main__title">
						<h2>Dashboard</h2>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>Top Purchased Movies</h3>
						</div>

						<?php
						include '../koneksi.php';
						$sql = "
								SELECT movies.title, movies.category, COUNT(bookings.showtime_id) AS purchase_count
								FROM movies
								JOIN cinema_movies ON movies.movie_id = cinema_movies.movie_id
								JOIN showtimes ON cinema_movies.cinema_movie_id = showtimes.cinema_movie_id
								JOIN bookings ON showtimes.showtime_id = bookings.showtime_id
								GROUP BY movies.movie_id
								ORDER BY purchase_count DESC
							";

						$result = $conn->query($sql);
						?>

						<div class="dashbox__table-wrap dashbox__table-wrap--2">
							<table class="dashbox__table">
								<thead>
									<tr>
										<th>NO</th>
										<th>ITEM</th>
										<th>CATEGORY</th>
										<th>PURCHASES</th>
									</tr>
								</thead>
								<tbody>

									<?php
									$no = 1;
									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "
                                <tr>
                                    <td>
                                        <div class='dashbox__table-text dashbox__table-text--grey'>" . $no++ . "</div>
                                    </td>
                                    <td>
                                        <div class='dashbox__table-text'><a href='#'>" . htmlspecialchars($row['title']) . "</a></div>
                                    </td>
                                    <td>
                                        <div class='dashbox__table-text'>" . htmlspecialchars($row['category']) . "</div>
                                    </td>
                                    <td>
                                        <div class='dashbox__table-text'>" . $row['purchase_count'] . "</div>
                                    </td>
                                </tr>";
										}
									} else {
										echo "<tr><td colspan='4'>No movies found</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>

						<?php
						$conn->close();
						?>
					</div>
				</div>
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3>Latest Movies</h3>
							<div class="dashbox__wrap">
							<a class="dashbox__more" href="film.php">View All</a>
							</div>
						</div>

						<?php
						include '../koneksi.php';

						// Batasi jumlah film yang ditampilkan maksimal 3
						$sql = "SELECT * FROM movies ORDER BY created_at DESC LIMIT 3";
						$result = $conn->query($sql);
						?>
					<div class="dashbox__table-wrap dashbox__table-wrap--2">
						<table class="dashbox__table">
							<thead>
								<tr>
									<th>NO</th>
									<th>ITEM</th>
									<th>CATEGORY</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										echo "<tr>
                                    <td>
                                        <div class='dashbox__table-text dashbox__table-text--grey'>" . $no++ . "</div>
                                    </td>
                                    <td>
                                        <div class='dashbox__table-text'><a href='#'>" . htmlspecialchars($row['title']) . "</a></div>
                                    </td>
                                    <td>
                                        <div class='dashbox__table-text'>" . htmlspecialchars($row['category']) . "</div>
                                    </td>
                                </tr>";
									}
								} else {
									echo "<tr><td colspan='3'>No movies found</td></tr>";
								}
								?>
							</tbody>
						</table>
						<?php
						$conn->close();
						?>
					</div>	
				</div>
			</div>
		</div>
		</div>
		<div class="col-12 col-xl-8">
			<div class="dashbox">
				<div class="dashbox__title">
					<h3>Statistics of Movie Sales</h3>
				</div>
				<canvas id="salesChart"></canvas>
			</div>
		</div>

	</main>
	<!-- JS for Chart Initialization -->
	<script>
		window.onload = function() {
			const data = {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Agustus'],
				datasets: [{
					label: 'Movies',
					data: [44, 50, 75, 81, 45, 55, 40, 78],
					backgroundColor: 'rgba(249, 171, 0, 0.5)',
					borderColor: 'rgba(249, 171, 0, 1)',
					borderWidth: 1
				}]
			};

			const config = {
				type: 'bar',
				data: data,
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			};

			const salesChart = new Chart(
				document.getElementById('salesChart'),
				config
			);
		};
	</script>
	</script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/slimselect.min.js"></script>
	<script src="js/smooth-scrollbar.js"></script>
	<script src="js/admin.js"></script>
</body>

</html>