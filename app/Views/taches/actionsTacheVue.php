<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">
<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

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
				<?php echo form_textarea('detail', $tache['detail'], 'class="form-control" id="description" placeholder="Description" required style="height: 150px; resize: none;"'); ?>
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
						<?php 
							$priorite_options = ['' => ''] + array_column($priorites, 'libelle', 'id');
							echo form_dropdown('id_priorite', $priorite_options, $tache['id_priorite'], 'class="form-select" id="priorite" required');  
						?>
						<?php echo form_label('Priorité', 'id_priorite'); ?>
						<?= validation_show_error('id_priorite') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-floating">
						<?php 
							$statut_options = ['' => ''] + array_column($statuts, 'libelle', 'id');
							echo form_dropdown('id_statut', $statut_options, $tache['id_statut'], 'class="form-select" id="statut" required');  
						?>
						<?php echo form_label('Statut', 'id_statut'); ?>
						<?= validation_show_error('id_statut') ?>
					</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-md-6">
					<div class="form-floating">
						<?php echo form_input(['name' => 'rappel', 'type' => 'number', 'value' => $tache['rappel'], 'class' => 'form-control', 'id' => 'rappel', 'placeholder' => 'Durée', 'required' => 'required', 'min' => '1']); ?>
						<?php echo form_label('Durée avant rappel', 'rappel'); ?>
						<?= validation_show_error('rappel') ?>
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