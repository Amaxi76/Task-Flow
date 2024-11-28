<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">
<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">


<header id="up-link">
	<div class="conteneur-entete">
		<img src="<?= base_url('assets/images/Logo.svg') ?>" alt="Logo de TaskFlow">

		<div class="button main-button">
			<svg viewBox="0 0 43 36" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M27.5294 24.0714V30.9524C27.5294 33.1878 25.7298 35 23.5098 35H5.0196C2.79964 35 1 33.1878 1 30.9524V5.04762C1 2.81218 2.79964 1 5.01961 1H23.5098C25.7298 1 27.5294 2.81218 27.5294 5.04762V11.9286M11.8529 18H42M42 18L35.9704 11.9286M42 18L35.9704 24.0715" />
			</svg>
			<button>Déconnexion</button>
		</div>
	</div>
</header>

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4"><?php echo $titre ?></h2>
				<?php echo form_open('/taches/appliquerAjout', ['class' => 'needs-validation', 'novalidate' => '']); ?>
				<?= form_hidden('id_utilisateur', set_value('id_utilisateur', $idUtilisateur)); ?>
				
				<div class="form-floating mb-3">
					<?php echo form_input('titre', set_value('titre'), 'class="form-control" id="nom_tache" placeholder="Nom de la tâche" required'); ?>
					<?php echo form_label('Nom de la tâche', 'titre'); ?>
					<?= validation_show_error('titre') ?>
				</div>

				<div class="form-floating mb-3">
					<?php echo form_textarea('detail', set_value('detail'), 'class="form-control" id="description" placeholder="Description" required style="height: 150px;"'); ?>
					<?php echo form_label('Description', 'detail'); ?>
					<?= validation_show_error('detail') ?>
				</div>

				<div class="form-floating mb-3">
					<?php echo form_input(['name' => 'echeance', 'type' => 'datetime-local', 'value' => set_value('echeance'), 'class' => 'form-control', 'id' => 'echeance', 'placeholder' => 'Date et Heure', 'required' => 'required']); ?>
					<?php echo form_label('Date et Heure', 'datetime'); ?>
					<?= validation_show_error('echeance') ?>
				</div>

				<div class="row mb-3">
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_dropdown('id_priorite', array_column($priorites, 'libelle', 'id'), set_value('id_priorite'), 'class="form-select" id="priorite" required');  ?>
							<?php echo form_label('Priorité', 'id_priorite'); ?>
							<?= validation_show_error('id_priorite') ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-floating">
							<?php echo form_dropdown('id_statut',  array_column($statuts, 'libelle', 'id'), set_value('id_statut'), 'class="form-select" id="statut" required');  ?>
							<?php echo form_label('Statut', 'id_statut'); ?>
							<?= validation_show_error('id_statut') ?>
						</div>
					</div>
				</div>

				<?php echo form_submit('submit', 'Ajouter la tâche', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>