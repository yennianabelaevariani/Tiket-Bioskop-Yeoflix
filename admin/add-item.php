<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include 'components/link.php' ?>
	<title>YeoFlix</title>
	<style>
		.form-check {
			width: 150px;
		}

		.form-check-label {
			color: white;
		}
	</style>
</head>

<body>
	<?php include 'components/headerAdmin.php' ?>
	<div class="sidebar">
		<a href="index.php" class="sidebar__logo">
		</a>
		<?php include 'components/sidebar.php' ?>
	</div>
	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="main__title">
						<h2>Add Movies</h2>
					</div>
				</div>

				<div class="col-12">
					<form action="add_film.php" class="sign__form sign__form--add" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-12 col-xl-7">
								<div class="row">
									<div class="col-12">
										<div class="sign__group">
											<input type="text" class="sign__input" placeholder="Judul" name="judul" required>
										</div>
									</div>
									<div class="col-12">
										<div class="sign__group">
											<textarea id="text" name="deskripsi" class="sign__textarea" placeholder="Deskripsi" required></textarea>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<div class="sign__gallery">
												<label for="sign">Unggah Sampul (240x340)</label>
												<input id="sign" name="media" class="bi bi-image" type="file" accept=".png, .jpg, .jpeg" required>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="director" class="sign__input" placeholder="Sutradara" required>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<select id="status" name="status" class="sign__input">
												<option value="Visible" selected>Visible</option>
												<option value="Hidden">Hidden</option>
											</select>
										</div>	
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="age_rating" class="sign__input" placeholder="Rating Usia" required>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="date" name="release_date" class="sign__input" required>
										</div>
									</div>	
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="duration" class="sign__input" placeholder="Durasi (menit)" required>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="rating" class="sign__input" placeholder="Nama Aktor" required>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="sign__group">
											<input type="text" name="trailer_link" class="sign__input" placeholder="Kode semat" optional>
											<div class="text-light mt-2 col-lg-12">
												<p class="small" style="font-size:10px;">Contoh: https://www.youtube.com/embed/<b>4fdqx7gEUDs</b> kirim link yang bercetak tebal</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-xl-5">
								<div class="row">
									<div class="col-12">
										<div class="sign__group">
											<label class="sign__label">Pilih Genre:</label>
											<div class="d-flex flex-wrap">
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Adventure" id="genreAdventure">
													<label class="form-check-label" for="genreAdventure">Adventure</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Action" id="genreAction">
													<label class="form-check-label" for="genreAction">Action</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Animation" id="genreAnimation">
													<label class="form-check-label" for="genreAnimation">Animation</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Comedy" id="genreComedy">
													<label class="form-check-label" for="genreComedy">Comedy</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Drama" id="genreDrama">
													<label class="form-check-label" for="genreDrama">Drama</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Fantasy" id="genreFantasy">
													<label class="form-check-label" for="genreFantasy">Fantasy</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Historical" id="genreHistorical">
													<label class="form-check-label" for="genreHistorical">Historical</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Horror" id="genreHorror">
													<label class="form-check-label" for="genreHorror">Horror</label>
												</div>
												<div class="form-check me-3">
													<input type="checkbox" class="form-check-input" name="genre[]" value="Romance" id="genreRomance">
													<label class="form-check-label" for="genreRomance">Romance</label>
												</div>
											</div>
										</div>
									</div>

									<div class="col-12">
										<div class="sign__group">
											<label class="sign__label">Pilih Bioskop:</label>
											<div class="d-flex flex-wrap">
												<?php
												include '../koneksi.php';
												$sql = "SELECT cinema_id, cinema_name FROM cinemas";
												$result = mysqli_query($conn, $sql);
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<div class='form-check me-3'>
														<input type='checkbox' class='form-check-input' name='cinema_id[]' value='" . $row['cinema_id'] . "' id='cinema" . $row['cinema_id'] . "'>
														<label class='form-check-label' for='cinema" . $row['cinema_id'] . "'>" . $row['cinema_name'] . "</label>
													</div>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label">Tipe Item:</label>
									<ul class="sign__radio">
										<li>
											<input id="type1" type="radio" name="kategori" value="Film" required>
											<label for="type1">Film</label>
										</li>
										<li>
											<input id="type2" type="radio" name="kategori" value="Series" required>
											<label for="type2">Series</label>
										</li>
									</ul>
								</div>
							</div>

							<div class="col-12">
								<button type="submit" class="sign__btn">Publish</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>
</body>

</html>