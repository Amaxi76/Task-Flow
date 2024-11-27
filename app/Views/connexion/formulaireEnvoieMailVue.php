<link href="assets/css/styleutilisateur.css" rel="stylesheet">

<body>
	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section gauche avec le logo -->
			<div class="md-6 d-flex align-items-center justify-content-center bg-white p-4">
				<img src="assets/images/Logo.svg" alt="Logo" class="logo mx-auto d-block">
			</div>
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Mot de passe oublié</h2>
				<?php echo form_open('/connexion/mdp_oublie/envoie_mail'); ?>

				<div class="form-floating mb-3">
					<?php echo form_input('email', set_value('email'), 'class="form-control" id="email" placeholder="name@example.com" required'); ?>
					<?php echo form_label('E-mail', 'email'); ?>
					<?= validation_show_error('email') ?>
				</div>

				<?php echo form_submit('submit', 'Envoyer', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<!-- Toast pour l'envoi du mail -->
	<div class="toast-container position-fixed top-0 end-0 p-3">
		<div id="mailEnvoyeToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<img src="assets/images/LogoSeul.svg" class="rounded me-2" alt="Logo TaskFlow" width="20" height="20">
				<strong class="me-auto">TaskFlow</strong>
				<small>À l'instant</small>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				Un e-mail de réinitialisation a été envoyé à votre adresse.
			</div>
		</div>
	</div>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		<?php if(session()->getFlashdata('mailEnvoye')): ?>
			var toast = new bootstrap.Toast(document.getElementById('mailEnvoyeToast'));
			toast.show();
		<?php endif; ?>
	});
	</script>

