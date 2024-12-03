<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<style>
		body {
			background-color: #f8f9fa;
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		.container {
			width: 100%;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
		}
		.box {
			background-color: #ffffff;
			border-radius: 8px;
			overflow: hidden;
			padding: 40px; /* Augmenté pour un espace intérieur plus grand */
			text-align: center;
		}
		.header {
			background-color: #379EE8;
			padding: 20px;
			text-align: center;
		}
		.logo {
			max-width: 200px;
		}
		.content {
			padding: 30px;
			color: #1C4973;
		}
		h1 {
			color: #1C4973;
			margin-bottom: 20px;
		}
		.btn {
			display: inline-block;
			background-color: #379EE8;
			color: #ffffff !important;
			text-decoration: none;
			padding: 10px 20px;
			border-radius: 5px;
			margin-top: 20px;
		}
		.btn:hover {
			background-color: #163a5c;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="box">
			<div class="header">
				<h1>TaskFlow</h1>
			</div>
			<div class="content">
				<h1>Activation de votre compte</h1>
				<p>Merci de vous être inscrit. Pour activer votre compte, veuillez cliquer sur le bouton ci-dessous :</p>
				<a href="<?= esc($activationLien) ?>" class="btn">Activer mon compte</a>
			</div>
		</div>
	</div>
</body>
</html>