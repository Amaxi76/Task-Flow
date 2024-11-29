<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="TaskFlow">
	<meta name="description" content="">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link href="<?= base_url('assets/css/styleprofil.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/tachevue.css') ?>" rel="stylesheet">
	<link rel="icon" href="/favicon.ico">
	<title>Task-Flow</title>
</head>
<body>
	<div class="container">
		<div class="profile-card">
			<div class="info-card">
				<h5>Votre email</h5>
				<hr>
				<p><?= esc($utilisateur['email']) ?></p>
			</div>
			
			<div class="name-section">
				<div class="info-card">
					<h5>Votre nom</h5>
					<hr>
					<p><?= esc($utilisateur['nom']) ?></p>
				</div>
			</div>
			
			<div class="info-card">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<h5>Statuts</h5>
					<!-- Bouton pour ajouter un statut -->
					<button id="btn-ajouter-statut" class="button main-button">Ajouter un statut</button>
				</div>
				<hr>
				<div class="status-priorities">
					<?php foreach ($statuts as $statut): ?>
						<div class="color-picker">
							<span><?= esc($statut['libelle']) ?></span>
							<input type="color" id="statut_<?= esc($statut['id']) ?>" value="<?= esc($statut['couleur']) ?>">
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Formulaire Enregistrer -->
			<div style="text-align: right;"> 
				<?= form_open('profil/enregistrer-modifications') ?>
					<button type="submit" class="btn-enregistrer">Enregistrer les modifications</button>
				<?= form_close() ?>
			</div>

			<!-- Formulaires Modifier mot de passe et Supprimer compte -->
			<div class="button-group">
				<?= form_open('connexion/mdp_oublie') ?>
					<button type="submit" class="button secondary-button">Modifier le mot de passe</button>
				<?= form_close() ?>

				<?= form_open('profil/supprimer-compte', ['id' => 'form_supprimer']) ?>
					<button type="submit" id="supprimer" class="btn-supprimer">Supprimer le compte</button>
				<?= form_close() ?>
			</div>
		</div>
	</div>

	<!-- Popup pour ajouter un statut -->
	<div id="popup-ajouter-statut" class="popup" style="display: none;">
		<div class="popup-content">
			<h5>Ajouter un nouveau statut</h5>
			<hr>
			<?= form_open('profil/ajouter-statut') ?>
				<div class="form-group">
					<label for="titre-statut">Titre :</label>
					<input type="text" id="titre-statut" name="titre" required>
				</div>
				<div class="form-group">
					<label for="couleur-statut">Couleur :</label>
					<input type="color" id="couleur-statut" name="couleur" value="#000000" required>
				</div>
				<div class="form-buttons">
					<button type="submit" class="btn-enregistrer">Ajouter</button>
					<button type="button" id="btn-fermer-popup" class="btn-fermer">Annuler</button>
				</div>
			<?= form_close() ?>
		</div>
	</div>



	<script src="<?= base_url('assets/js/profil.js') ?>"></script>
</body>
</html>
