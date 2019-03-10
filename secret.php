<!DOCTYPE html>
<html>
	<head>
		<title>Secret Server Task</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style/style.css"/>
	</head>
	<body>
		<form action="add_secret.php" method="post" enctype="application/x-www-form-urlencoded">
			<div class="secret_datas">
				<div class="secret text">
					<label>Secret</label>
					<textarea name="secret" required></textarea>
				</div>
				<div class="secret expire_after_views">
					<label>After how many views should be the secret unavailable? It must be greater than 0.</label>
					<input type="number" step="1" min="1" pattern="\d+" name="expireAfterViews" required>
				</div>
				<div class="secret expire_after">
					<label>After how many minutes should be the secret unavailable? 0 means never expires.</label>
					<input type="number" step="1" min="0" pattern="\d+" name="expireAfter" required>
				</div>
				<input type="submit" value="Submit">
			</div>
		</form>
	</body>
</html>