<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rappel de tâches</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
		}
		h2 {
			color: #2d3e50;
		}
		ul {
			list-style-type: disc;
			padding-left: 20px;
		}
		li {
			margin-bottom: 15px;
		}
		em {
			color: #555;
		}
	</style>
</head>
<body>
	<h2>Rappel de vos tâches à venir</h2>
	<p>Voici la liste des tâches qui arrivent bientôt :</p>
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
</body>
</html>
