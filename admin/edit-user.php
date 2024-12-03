<?php
include '../koneksi.php'; 

$user_id = $_GET['id']; 

$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include 'components/link.php' ?>
	<title>YeoFlix</title>
</head>
<body>
	<?php include 'components/headerAdmin.php' ?>

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
						<h2>Edit User</h2>
					</div>
				</div>

				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab" tabindex="0">
						<div class="col-12">
							<div class="row">
								<div class="col-12 col-lg-6">
									<form action="update_profile.php" method="POST" class="sign__form sign__form--profile">
										<div class="row">
											<div class="col-12">
												<h4 class="sign__title">Profile details</h4>
											</div>

											<input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

											<div class="col-12 col-md-6">
												<div class="sign__group">
													<label class="sign__label" for="username">Username</label>
													<input id="username" type="text" name="username" class="sign__input" value="<?php echo $user['username']; ?>">
												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="sign__group">
													<label class="sign__label" for="email2">Email</label>
													<input id="email2" type="email" name="email" class="sign__input" value="<?php echo $user['email']; ?>">
												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="sign__group">
													<label class="sign__label" for="fname">Name</label>
													<input id="fname" type="text" name="name" class="sign__input" value="<?php echo $user['name']; ?>">
												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="sign__group">
													<label class="sign__label" for="rights">Role</label>
													<select class="sign__select" id="rights" name="role">
														<option value="User" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
														<option value="Admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
													</select>
												</div>
											</div>

											<div class="col-12">
												<button class="sign__btn sign__btn--small" type="submit"><span>Save</span></button>
											</div>
										</div>
									</form>
								</div>

								<div class="col-12 col-lg-6">
									<form action="update_password.php" method="POST" class="sign__form sign__form--profile">
										<div class="row">
											<div class="col-12">
												<h4 class="sign__title">Change password</h4>
											</div>

											<input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

											<div class="col-12 col-md-6 col-lg-12 col-xxl-6">
												<div class="sign__group">
													<label class="sign__label" for="oldpass">Old Password</label>
													<input id="oldpass" type="password" name="oldpass" class="sign__input">
												</div>
											</div>

											<div class="col-12 col-md-6 col-lg-12 col-xxl-6">
												<div class="sign__group">
													<label class="sign__label" for="newpass">New Password</label>
													<input id="newpass" type="password" name="newpass" class="sign__input">
												</div>
											</div>

											<div class="col-12 col-md-6 col-lg-12 col-xxl-6">
												<div class="sign__group">
													<label class="sign__label" for="confirmpass">Confirm New Password</label>
													<input id="confirmpass" type="password" name="confirmpass" class="sign__input">
												</div>
											</div>

											<div class="col-12">
												<button class="sign__btn sign__btn--small" type="submit"><span>Change</span></button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
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
