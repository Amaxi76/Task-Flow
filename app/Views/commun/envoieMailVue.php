<body>
	<link href="<?= base_url('assets/css/styleutilisateur.css') ?>" rel="stylesheet">

	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="box shadow-lg d-flex flex-row">
			<!-- Section droite avec le formulaire -->
			<div class="md-6 bg-custom text-white p-4 d-flex flex-column justify-content-between">
				<h2 class="text-center mb-4">Un email d'activation a été envoyé à <strong><?= esc($email) ?></strong></h2>

				<div class="text-center">
					<?php echo form_open('/inscription/renvoieMail'); ?>
						<?php echo form_hidden('email', $email); ?>
						<?php echo form_submit('resend', 'Si vous n\'avez pas reçu de mail,cliquez ici', 'class="btn btn-light"'); ?>
					<?php echo form_close(); ?>
				</div>
			</div>

			<!-- Section gauche avec le logo -->
			<div class="md-6 d-flex align-items-center justify-content-center bg-white p-4">
				<img src="<?= base_url('assets/images/Logo.svg') ?>" alt="Logo" class="logo mx-auto d-block">
			</div>
		</div>
	</div>