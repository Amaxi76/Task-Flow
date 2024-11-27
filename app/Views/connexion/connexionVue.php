<body>

<script src="assets/js/motdepasse.js"></script>
<link href="assets/css/styleutilisateur.css" rel="stylesheet">
	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section gauche avec le logo -->
			<div class="md-6 d-flex align-items-center justify-content-center bg-white p-4">
				<img src="assets/images/Logo.svg" alt="Logo" class="logo mx-auto d-block">
			</div>
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Connexion</h2>
				<?php echo form_open('/connexion', ['class' => 'needs-validation', 'novalidate' => '']); ?>
				
				<div class="form-floating mb-3">
					<?php echo form_input('email', set_value('email'), 'class="form-control" id="email" placeholder="name@example.com" required'); ?>
					<?php echo form_label('E-mail', 'email'); ?>
					<?= validation_show_error('email') ?>
				</div>

				<div class="form-floating mb-3 position-relative">
					<?php echo form_password('mdp', set_value('mdp'), 'class="form-control password-input" id="mdp" placeholder="Mot de passe" required'); ?>
					<?php echo form_label('Mot de passe', 'mdp'); ?>
					<span class="password-toggle-icon">
						<i class="fas fa-eye-slash" id="togglePassword"></i>
					</span>
				</div>

				<div class="d-flex justify-content-between align-items-center mb-4">
					<div class="form-check">
						<?php echo form_checkbox("seSouvenir", "1", "", 'class="form-check-input" id="seSouvenir"') ?>
						<?php echo form_label('Se souvenir de moi', 'seSouvenir', ['class' => 'form-check-label']); ?>
					</div>
					<a href="/connexion/mdp_oublie" class="text-white text-decoration-none">Mot de passe oublié ?</a>
				</div>

				<?= validation_show_error('password') ?>

				<?php echo form_submit('submit', 'Se connecter', 'class="btn btn-light w-100"'); ?>
				<?php echo form_close(); ?>

				<p class="text-center mt-3">
					<span>Pas encore inscrit ?</span> <a href="/inscription" class="text-white">Inscrivez-vous</a>
				</p>
			</div>
		</div>
	</div>