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

	<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	</body>
</html>