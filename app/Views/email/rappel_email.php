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
			padding: 40px;
			text-align: left;
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
		li {
			margin-bottom: 1rem;
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
				<h1>Rappel de vos tâches à venir</h1>
			</div>
			<div class="content">
				<h2>Voici la liste des tâches qui arrivent bientôt</h2>
				<ul>
					<?php foreach ($taches as $tache): ?>
						<li>
							<strong><?= esc($tache['titre']) ?></strong><br>
							<em><?= esc($tache['detail']) ?></em><br>
							Échéance : <?= date('d/m/Y H:i', strtotime($tache['echeance'])) ?><br>
							Rappel : <?= esc($tache['rappel']) ?> minutes avant échéance
						</li>
					<?php endforeach; ?>
				</ul>
				<p>Merci de votre attention.</p>
			</div>
		</div>
	</div>

</body>
</html>
