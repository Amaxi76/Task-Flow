<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>CHnagement du mot de passe</title>
</head>

<body>
	<h2>Changement du mot de passe </h2>
	<?php echo form_open('/connexion/mdp_oublie/reinit_mdp'); ?>
    <?php echo form_hidden('jeton', $jeton); ?>
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