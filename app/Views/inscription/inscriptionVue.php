<script src="<?= base_url('assets/js/motdepasse.js') ?>"></script>
<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

<body>
	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section gauche avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Inscription</h2>
				<?php echo form_open('/inscription', ['class' => 'needs-validation', 'novalidate' => '']); ?>

				<div class="form-floating">
					<?php echo form_input('email', set_value('email'), 'class="form-control" id="email" placeholder="name@example.com" required'); ?>
					<?php echo form_label('E-mail', 'email'); ?>
					<?php if(isset($erreur['email'])): ?>
					    <div class="invalid-feedback d-block text-white fs-6"><?= $erreur['email'] ?></div>
					<?php else: ?>
					    <div class="text-white"><?= validation_show_error('email') ?></div>
					<?php endif; ?>

				</div>

				<div class="form-floating mt-3">
					<?php echo form_input('nom', set_value('nom'), 'class="form-control" id="nom" placeholder="Votre nom" required'); ?>
					<?php echo form_label('Nom', 'nom'); ?>
					<?= validation_show_error('nom') ?>
				</div>

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
					<?php echo form_label('Confirmer le mot de passe', 'confirmerMdp'); ?>
					<span class="password-toggle-icon">
						<i class="fas fa-eye-slash" id="toggleConfirmPassword"></i>
					</span>
				</div>
				<?= validation_show_error('confirmerMdp') ?>

				<?php echo form_submit('submit', 'S\'inscrire', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>

				<p class="text-center mt-3">
					<span>Déjà inscrit ?</span> <a href="<?= base_url('connexion') ?>" class="text-white">Connectez-vous</a>
				</p>
			</div>

			<!-- Section droite avec le logo -->
			<div class="md-6 d-flex align-items-center justify-content-center bg-white">
				<img src="<?= base_url('assets/images/Logo.svg') ?>" alt="Logo" class="logo mx-auto d-block">
			</div>
		</div>
	</div>

	<!-- Toast pour l'inscription réussie -->
	<div class="toast-container position-fixed top-0 end-0 p-3">
		<div id="inscriptionToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<img src="<?= base_url('assets/images/Logo.svg') ?>" class="rounded me-2" alt="Logo TaskFlow" width="20" height="20">
				<strong class="me-auto">TaskFlow</strong>
				<small>À l'instant</small>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				Un mail a été envoyé à votre adresse mail.
			</div>
		</div>
	</div>

	<!-- Script pour afficher le toast -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		<?php if(session()->getFlashdata('inscriptionReussie')): ?>
			var toast = new bootstrap.Toast(document.getElementById('inscriptionToast'));
			toast.show();
		<?php endif; ?>
	});
	</script>