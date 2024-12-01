<body>
	<link href="<?= base_url('assets/css/styleprofil.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/tachevue.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/tachevue.css') ?>" rel="stylesheet">

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
				<?= form_open('profil/enregistrer-modif') ?>
				<div class="status-priorities">
					<?php foreach ($statuts as $statut): ?>
						<div class="color-picker">
						<!-- Libellé au début -->
						<span class="status-label"><?= esc($statut['libelle']) ?></span>
						
						<!-- Conteneur pour le color picker et le bouton -->
						<div class="actions">
							<input 
								type="color" 
								name="couleurs[statuts][<?= esc($statut['id']) ?>]" 
								value="<?= esc($statut['couleur']) ?>">
							<a 
								href="<?= base_url('profil/supprimer-statut/' . esc($statut['id'])) ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
									<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
									<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
								</svg>
							</a>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<!-- Formulaire Enregistrer -->
				<div class="form-actions">
					<button type="submit" class="button main-button">Enregistrer les modifications</button>
				</div>
				<?= form_close() ?>
			</div>
			<!-- Formulaires Modifier mot de passe et Supprimer compte -->
			<div class="button-group">
				<?= form_open('connexion/mdp_oublie') ?>
					<button type="submit" class="button secondary-button">Modifier le mot de passe</button>
				<?= form_close() ?>

				<?= form_open('profil/supprimer-compte', ['id' => 'form_supprimer']) ?>
					<button style="background-color:#dc3545; color: white;" type="submit" id="supprimer" class="button secondary-button">Supprimer le compte</button>
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
					<button type="button" id="btn-fermer-popup" class="btn-fermer">Annuler</button>
					<button type="submit" class="btn-enregistrer">Ajouter</button>			
				</div>
				
			<?= form_close() ?>
		</div>
	</div>

	<script src="<?= base_url('assets/js/profil.js') ?>"></script>
</body>
</html>
