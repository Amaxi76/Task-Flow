<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="TaskFlow">
	<meta name="description" content="">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="icon" href="/favicon.ico">
	<title>Task-Flow</title>
</head>

<body>

	<script src="<?= base_url('assets/js/motdepasse.js') ?>"></script>
	<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section gauche avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Changement du mot de passe </h2>
				<?php echo form_open('/profil/appliquerChangementMdp', ['class' => 'needs-validation', 'novalidate' => '']); ?>
			
				<div class="form-floating mt-3 position-relative">
					<?php echo form_password('mdp', set_value('mdp'), 'class="form-control password-input" id="mdp" placeholder="Mot de passe" required'); ?>
					<?php echo form_label('Mot de passe', 'mdp'); ?>
					<span class="password-toggle-icon">
						<i class="fas fa-eye-slash" id="togglePassword"></i>
					</span>
				</div>
				<?= validation_show_error('mdp') ?>

				<div class="form-floating mt-3 position-relative">
					<?php echo form_password('confirmerMdp', set_value(field: 'confirmerMdp'), 'class="form-control password-input" id="confirmerMdp" placeholder="Confirmer le mot de passe" required'); ?>
					<?php echo form_label('Confimer le mot de passe', 'confirmerMdp'); ?>
					<span class="password-toggle-icon">
						<i class="fas fa-eye-slash" id="toggleConfirmPassword"></i>
					</span>
				</div>
				<?= validation_show_error('confirmerMdp') ?>

				<?php echo form_submit('submit', 'Changer le mot de passe', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>
			</div>
			<!-- Section droite avec le logo -->
			<?php echo view('commun/logoSection'); ?>
		</div>
	</div>


	<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	</body>
</html>