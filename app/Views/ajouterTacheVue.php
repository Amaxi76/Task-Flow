<form action="/ajouterTache" method="post">
	<input id="titre" type="text" placeholder="Titre">
	<input id="detail" type="text" placeholder="Détail">
	<input id="echeance" type="date" placeholder="Echéance">
	<select id="id_priorite">
		<?php foreach ($statuts as $statut) : ?>
			<option value= <?= esc($statut['id']) ?> ><?= esc($statut['libelle']) ?></option>
		<?php endforeach; ?>
	</select>
	<select id="id_statut">
		<?php foreach ($priorites as $priorite) : ?>
			<option value= <?= esc($priorite['id']) ?> ><?= esc($priorite['libelle']) ?></option>
		<?php endforeach; ?>
	</select>
	
	<button type="submit">Ajouter</button>
	<button type="reset">Annuler</button>
</form>