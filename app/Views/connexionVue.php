<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Inscription</title>
</head>

<body>
	<h2>Inscription </h2>
	<?php echo form_open('ConnexionControleur/connexion'); ?>
	<?php echo form_label('Adresse e-mail', 'email'); ?>
	<?php echo form_input('email', set_value('email'), 'required'); ?>
	<?= validation_show_error('email') ?>
	<br>
	<?php echo form_label('Mot de passe', 'mdp'); ?>
	<?php echo form_input('mdp', set_value('mdp'), 'required'); ?>
	<?= validation_show_error('mdp') ?>
	<br>
    <a href="/MotDePasseOublie/envoieMail">Mot de passe oublié ?</a>
	<?php echo form_submit('submit', 'Envoyer'); ?>
	<?php echo form_close(); ?>
</body>

</html>