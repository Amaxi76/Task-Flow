<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">
<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">


<header id="up-link">
	<div class="conteneur-entete">
		<img src="<?= base_url('assets/images/Task-Flow-Horizontal.svg') ?>" alt="Logo de TaskFlow">

		<div class="button main-button">
			<svg viewBox="0 0 43 36" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M27.5294 24.0714V30.9524C27.5294 33.1878 25.7298 35 23.5098 35H5.0196C2.79964 35 1 33.1878 1 30.9524V5.04762C1 2.81218 2.79964 1 5.01961 1H23.5098C25.7298 1 27.5294 2.81218 27.5294 5.04762V11.9286M11.8529 18H42M42 18L35.9704 11.9286M42 18L35.9704 24.0715" />
			</svg>
			<button>Déconnexion</button>
		</div>
	</div>
</header>

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row" style="width:fit-content;">
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4"><?php echo $titre ?></h2>
				<?php echo form_open($routeFormulaire, ['class' => 'needs-validation', 'novalidate' => '']); ?>
				<?= form_hidden('id',$tache['id']."", ""); ?>
				<?= form_hidden('id_utilisateur',$tache['id_utilisateur']."", ""); ?>
				
				<div class="form-floating mb-3">
					<?php echo form_input('titre', $tache['titre'], 'class="form-control" id="nom_tache" placeholder="Nom de la tâche" required'); ?>
					<?php echo form_label('Nom de la tâche', 'titre'); ?>
					<?= validation_show_error('titre') ?>
				</div>

				<div class="form-floating mb-3">
					<?php echo form_textarea('detail', $tache['detail'], 'class="form-control" id="description" placeholder="Description" required style="height: 150px;"'); ?>
					<?php echo form_label('Description', 'detail'); ?>
					<?= validation_show_error('detail') ?>
				</div>

				<div class="form-floating mb-3">
					<?php echo form_input(['name' => 'date_echeance', 'type' => 'datetime-local', 'value' => $tache['date_echeance'], 'class' => 'form-control', 'id' => 'date_echeance', 'placeholder' => 'Date et Heure', 'required' => 'required']); ?>
					<?php echo form_label('Date et Heure', 'datetime'); ?>
					<?= validation_show_error('date_echeance') ?>
				</div>

				<div class="row mb-3">
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_dropdown('id_priorite', array_column($priorites, 'libelle', 'id'), $tache['id_priorite'], 'class="form-select" id="priorite" required');  ?>
							<?php echo form_label('Priorité', 'id_priorite'); ?>
							<?= validation_show_error('id_priorite') ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_dropdown('id_statut',  array_column($statuts, 'libelle', 'id'), $tache['id_statut'], 'class="form-select" id="statut" required');  ?>
							<?php echo form_label('Statut', 'id_statut'); ?>
							<?= validation_show_error('id_statut') ?>
						</div>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_input(['name' => 'rappel', 'type' => 'number', 'class' => 'form-control', 'id' => 'duree_valeur', 'placeholder' => 'Durée', 'required' => 'required']); ?>
							<?php echo form_label('Durée', 'duree_valeur'); ?>
							<?= validation_show_error('duree_valeur') ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_dropdown('unite', [
								'heure' => 'Heure',
								'jour' => 'Jours',
								'mois' => 'Mois',
								'annee' => 'Années'
							], '', 'class="form-select" id="unite" required'); ?>
							<?php echo form_label('Unité', 'unite'); ?>
							<?= validation_show_error('unite') ?>
						</div>
					</div>
				</div>

				<?php echo form_submit('submit', 'Valider', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>