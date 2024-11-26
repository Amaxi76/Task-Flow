<style>
	.badge {
		1px solid black;
		padding: 10px;
		margin: 10px;
		background-color: grey;
		border-radius : 50px;
	}
</style>

<a href=/taches/ajouter>Ajouter une tâche</a>

<?php foreach ($taches as $tache) : ?>
	<div class="tache">
		<h1><?= esc($tache['titre']) ?></h1>
		<span class="badge"><?= esc($tache['echeance']) ?></span>
		<span class="badge"><?= esc($tache['priorite']) ?></span>
		<span class="badge"><?= esc($tache['statut']) ?></span>
		<p><?= esc($tache['detail']) ?></p>
		<input type="text" placeholder="Ajouter un commentaire">
	</div>
<?php endforeach; ?>

<?= $pagerTaches->links('taches', 'default_full'); ?>