<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="admin/css/slimselect.css">
	<link rel="stylesheet" href="admin/css/admin.css">
	<link rel="stylesheet" href="admin/webfont/tabler-icons.min.css">
</head>

<body>
	<div class="sign section--bg" data-bg="admin/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<form action="lg.php" class="sign__form" method="post">
							</a>
							<div class="sign__group">
								<input type="text" class="sign__input" name="username" placeholder="Name" required>
							</div>
							<div class="sign__group">
								<input type="text" class="sign__input" name="email" placeholder="Email" required>
							</div>
							<div class="sign__group">
								<input type="password" class="sign__input" name="password" placeholder="Password" required>
							</div>
							<div>
								<input type="hidden" name="role" value="user">
							</div>
							<button class="sign__btn" type="submit">Sign up</button>
							<span class="sign__delimiter">or</span>
							<span class="sign__text">Already have an account? <a href="signin.php">Sign in!</a></span>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="admin/js/bootstrap.bundle.min.js"></script>
	<script src="admin/js/slimselect.min.js"></script>
	<script src="admin/js/smooth-scrollbar.js"></script>
	<script src="admin/js/admin.js"></script>
</body>

</html>