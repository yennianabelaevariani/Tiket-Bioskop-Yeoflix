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
<style>
	.btn-hover {
		display: inline-block;
		padding: 10px 20px;
		border: 2px solid #FFD700;
		background-color: #000;
		color: #fff;
		font-size: 16px;
		font-weight: bold;
		text-transform: uppercase;
		text-align: center;
		transition: background-color 0.3s ease, color 0.3s ease;
		border-radius: 5px; 
	}

	.btn-hover:hover {
		background-color: rgba(255, 215, 0, 0.3);
		color: #000;
		border-color: #FFD700;
		text-decoration: none !important;

	}

	.video-container {
		max-width: 100%;
		border-radius: 15px;
		overflow: hidden;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		background-color: #000;
	}

	.video-container iframe {
		width: 100%;
		height: 385px;
		border: none;
	}


	.btn-hover:active {
		transform: scale(0.98);
	}
</style>

<body>
	<?php
	include "koneksi.php";
	$id = $_GET['id'];
	$sql = "SELECT * FROM movies WHERE movie_id='$id'";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($result);
	?>
	<section class="container mt-5">
		<div class="container">
			<div class="row">
				<div class="col-12 mb-5">
					<h1 class="section__title section__title--head"><?= $data['title'] ?></h1>
				</div>
				<div class="col-12 col-xl-6">
					<div class="item item--details">
						<div class="row">
							<div class="col-12 col-sm-5 col-md-5 col-lg-4 col-xl-6 col-xxl-5">
								<div class="item__cover">
								<img src="admin/assets/upload/thumbnail/<?= $data['thumbnail'] ?>" alt="<?= $data['title'] ?>">
								</div>
							</div>
							<div class="col-12 col-md-7 col-lg-8 col-xl-6 col-xxl-7">
								<div class="item__content">
									<ul class="item__meta">
										<li><span>Director:</span> <a href="actor.html"><?= $data['director'] ?></a></li>
										<li><span>Cast:</span><?= $data['Casts'] ?></li>
										<li><span>Genre:</span> <a href="catalog.html">Action</a>
											<a href="catalog.html">Triler</a>
										</li>
										<li><span>Premiere::</span> <?= $data['release_date'] ?></li>
										<li><span>Running time:</span> <?= $data['duration'] ?> menit</li>
										<a href="tiket.php?id=<?= $data['movie_id'] ?>" class="btn btn-hover mt-4">Buy Ticket</a>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-12 col-lg-6 rounded overflow-hidden shadow-lg">
					<div class="video-container">
						<iframe src="https://www.youtube.com/embed/<?= $data['trailer_link'] ?>?controls=0"
							frameborder="0"
							allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
							referrerpolicy="strict-origin-when-cross-origin"></iframe>
					</div>
				</div>

			</div>
			<div class="container">
				<div class="col-md-8">
					<div class="text-light p-2 mt-5">
						<h1 class="section__title section__title--head mb-3">Description</h1>
						<p>
							<?= $data['description'] ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/splide.min.js"></script>
	<script src="js/slimselect.min.js"></script>
	<script src="js/smooth-scrollbar.js"></script>
	<script src="js/plyr.min.js"></script>
	<script src="js/photoswipe.min.js"></script>
	<script src="js/photoswipe-ui-default.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>