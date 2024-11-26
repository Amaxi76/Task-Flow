<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Inscription</title>
</head>

<body>
	<h2>Inscription </h2>
	<?php echo form_open('InscriptionControleur/inscription'); ?>Utilisateur
	<?php echo form_label('Adresse e-mail', 'email'); ?>
	<?php echo form_input('email', set_value('email'), 'required'); ?>
	<?= validation_show_error('email') ?>
	<br>
	<?php echo form_label('Nom', 'nom'); ?>
	<?php echo form_input('nom', set_value('nom'), 'required'); ?>
	<?= validation_show_error('nom') ?>
	<br>
	<?php echo form_label('Mot de passe', 'mdp'); ?>
	<?php echo form_input('mdp', set_value('mdp'), 'required'); ?>
	<?= validation_show_error('mdp') ?>
	<br>
	<?php echo form_label('Confimer le mot de passe', 'confirmerMdp'); ?>
	<?php echo form_input('confirmerMdp', set_value('confirmerMdp'), 'required'); ?>
	<?= validation_show_error('confirmerMdp') ?>
	<br>
	<?php echo form_submit('submit', 'Envoyer'); ?>
	<?php echo form_close(); ?>
</body>

</html>