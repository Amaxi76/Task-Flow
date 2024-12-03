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
	<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4 d-flex flex-column justify-content-between">
				<h2 class="text-center mb-4">Votre jetons est expiré, veuillez refaire votre inscription.</strong></h2>

				<div class="text-center">
					<?php echo form_open('/inscription'); ?>
						<?php echo form_submit('resend', 'Redirection vers la page d\'inscription', 'class="btn btn-light"'); ?>
					<?php echo form_close(); ?>
				</div>
			</div>

			<!-- Section gauche avec le logo -->
			<?php echo view('commun/logoSection'); ?>
		</div>
	</div>

	<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	</body>
</html>