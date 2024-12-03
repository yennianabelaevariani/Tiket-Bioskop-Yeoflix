<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include 'components/link.php' ?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQp3mZ6o13KxiBIyNlF0x5QEOmYpBw1FeFiQ8BxEN7pu8mWZ9s" crossorigin="anonymous">
	<style>
		#new-user-info-modal .modal-content {
			background-color: white !important;
			opacity: 1 !important;
		}
	</style>
	<title>YeoFlix</title>
</head>

<body>
	<?php include 'components/headerAdmin.php' ?>

	<!-- sidebar -->
	<div class="sidebar">
		<a href="index.html" class="sidebar__logo"></a>
		<?php include 'components/sidebar.php' ?>
	</div>
	<!-- end sidebar -->

	<main class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="main__title">
						<h2>Users</h2>
						<div class="main__title-wrap">
							<a href="add-user.php" class="main__title-link main__title-link--wrap" data-bs-toggle="modal" data-bs-target="#modal-user">Add user</a>
						</div>
					</div>
				</div>
				
				<div class="col-12">
					<div class="catalog catalog--1">
						<table class="catalog__table">
							<thead>
								<tr>
									<th>No</th>
									<th>USERNAME</th>
									<th>LEVEL</th>
									<th>Gender</th>
									<th>CREATED DATE</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
								<?php
								include '../koneksi.php';
								$no = 1;
								$sql = "SELECT * FROM users";
								$result = mysqli_query($conn, $sql);
								while ($row = mysqli_fetch_assoc($result)) {
								?>
									<tr>
										<td>
											<div class="catalog__text"><?= $no; ?></div>
										</td>
										<td>
											<div class="catalog__user">
												<div class="catalog__meta">
													<h3><?= htmlspecialchars($row['username']) ?></h3>
													<span><?= htmlspecialchars($row['email']) ?></span>
												</div>
											</div>
										</td>
										<td>
											<div class="catalog__text"><?= htmlspecialchars($row['role']) ?></div>
										</td>
										<td>
											<div class="catalog__text"><?= htmlspecialchars($row['gender']) ?></div>
										</td>
										<td>
											<div class="catalog__text"><?= htmlspecialchars($row['created_at']) ?></div>
										</td>
										<td>
											<div class="catalog__btns">
												<a href="#" class="catalog__btn" onclick="showUserInfo(<?= $row['user_id'] ?>)">
													<i class="bi bi-eye"></i>
												</a>

												<a href="edit-user.php?id=<?= $row['user_id'] ?>" class="catalog__btn catalog__btn--edit">
													<i class="bi bi-pencil"></i>
												</a>
												<a href="#" class="catalog__btn catalog__btn--delete" onclick="confirmDelete(<?= $row['user_id'] ?>)">
													<i class="bi bi-trash3"></i>
												</a>
											</div>
										</td>
									</tr>
								<?php $no++;
								} ?>
							</tbody>
						</table>
					</div>
				</div>

				<script>
					function confirmDelete(userId) {
						const isConfirmed = confirm("Apakah Anda yakin ingin menghapus pengguna ini?");
						if (isConfirmed) {
							window.location.href = "hapususer.php?id=" + userId;
						}
					}
				</script>
			</div>
		</div>
	</main>

	<div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="modal-user" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal__content">
					<form action="add-users.php" method="POST" class="modal__form">
						<h4 class="modal__title">Add User</h4>
						<div class="row">
							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label" for="username">Username</label>
									<input id="username" type="text" name="username" class="sign__input" required>
								</div>
							</div>
							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label" for="email">Email</label>
									<input id="email" type="email" name="email" class="sign__input" required>
								</div>
							</div>
							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label" for="password">Password</label>
									<input id="password" type="password" name="password" class="sign__input" required>
								</div>
							</div>
							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label" for="gender">Gender</label>
									<select name="gender" class="sign__input">
										<option value="Pria">Pria</option>
										<option value="Wanita">Wanita</option>
										<option value="None" selected>None</option>
									</select>
								</div>
							</div>
							<div class="col-12">
								<div class="sign__group">
									<label class="sign__label" for="rights">Role</label>
									<select class="sign__select" id="rights" name="rights" required>
										<option value="User">User</option>
										<option value="Admin">Admin</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-lg-6 offset-lg-3">
								<button type="submit" class="sign__btn sign__btn--modal">Add</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="new-user-info-modal" tabindex="-1" aria-labelledby="new-user-info-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-dark">
            <div class="modal-header bg-dark border-bottom border-light">
                <h5 class="modal-title text-light">Informasi Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <div id="new-user-info-content">
                    <p><strong class="text-light">Nama:</strong> <span class="text-light" id="user-name"></span></p>
                    <p><strong class="text-light">Email:</strong> <span class="text-light" id="user-email"></span></p>
                    <p><strong class="text-light">Gender:</strong> <span class="text-light" id="user-phone"></span></p>
                    <p><strong class="text-light">Role:</strong> <span class="text-light" id="user-address"></span></p>
                </div>
            </div>
            <div class="modal-footer border-top border-light bg-dark">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/slimselect.min.js"></script>
	<script src="js/smooth-scrollbar.js"></script>
	<script src="js/admin.js"></script>
	<script>
		function showUserInfo(userId) {
			console.log('User ID:', userId); 

			$.ajax({
				url: 'get_user_info.php',
				type: 'GET',
				data: {
					id: userId
				},
				success: function(response) {
					console.log('Server Response:', response); 
					try {
						const user = JSON.parse(response);

						if (user.error) {
							alert(user.error); 
							return;
						}

						$('#user-name').text(user.username);
						$('#user-email').text(user.email);
						$('#user-phone').text(user.gender);
						$('#user-address').text(user.role);
						$('#new-user-info-modal').modal('show');
					} catch (e) {
						alert('Kesalahan dalam memproses data: ' + e.message);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('AJAX error:', textStatus, errorThrown);
					alert('Gagal mengambil informasi pengguna.');
				}
			});
		}
	</script>

</body>

</html>