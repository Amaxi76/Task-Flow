<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Liste des Élèves</title>
</head>

<body>
	<h1>Liste des Personnes</h1>
	<?php if (!empty($personnes)): ?>
		<table>
			<tr>
				<th>email</th>
				<th>Nom</th>
				<th>mdp</th>
			</tr>
			<?php foreach ($personnes as $personne): ?>
				<tr>
					<td><?= $personne['email']; ?></td>
					<td><?= $personne['nom']; ?></td>
					<td><?= $personne['mdp']; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p>Aucun personne trouvé.</p>
	<?php endif; ?>
</body>

</html>