<body>
	<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4">
				<h2 class="text-center mb-4">Un mail a été envoyé à votre adresse mail</h2>

				<p class="text-center mt-3">
					<span>Si vous ne l'avez pas reçu</span> <a href="<?= base_url('inscription') ?>" class="text-white">Cliquez ici</a>
				</p>
			</div>
			<!-- Section gauche avec le logo -->
			<?php echo view('commun/logoSection'); ?>
		</div>
	</div>