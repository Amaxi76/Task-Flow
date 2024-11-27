<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Mot de passe oublié</title>
</head>

<body>
	<h2>Mot de passe oublié</h2>
	<?php echo form_open('/connexion/mdp_oublie/envoie_mail'); ?>
	<?php echo form_label('Adresse e-mail', 'email'); ?>
	<?php echo form_input('email', set_value('email'), 'required'); ?>
    
	<?= validation_show_error('email') ?>
	<?php echo form_submit('submit', 'Envoyer'); ?>
	<?php echo form_close(); ?>
</body>

</html>