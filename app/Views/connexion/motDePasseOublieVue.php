
<body>
	<script src="<?= base_url('assets/js/motdepasse.js') ?>"></script>
	<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section gauche avec le logo -->
			<?php echo view('commun/logoSection'); ?>
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Mot de passe oublié</h2>
				<?php echo form_open('/connexion/mdp_oublie/envoie_mail'); ?>

				<div class="form-floating mb-3">
					<?php echo form_input('email', set_value('email'), 'class="form-control" id="email" placeholder="name@example.com" required'); ?>
					<?php echo form_label('E-mail', 'email'); ?>
					<?php if(isset(session('erreurs')['email'])): ?>
						<div class="invalid-feedback d-block text-white fs-6"><?= session('erreurs')['email'] ?></div>
					<?php else: ?>
						<?= validation_show_error('email') ?>
					<?php endif; ?>
				</div>

				<?php echo form_submit('submit', 'Envoyer', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>