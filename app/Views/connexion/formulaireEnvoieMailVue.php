<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Inscription</title>
</head>

<body>
	<h2>Inscription </h2>
	<?php echo form_open('ConnexionControleur/mdpOublie'); ?>
	<?php echo form_label('Adresse e-mail', 'email'); ?>
	<?php echo form_input('email', set_value('email'), 'required'); ?>
    
	<?= validation_show_error('email') ?>
	<?php echo form_submit('submit', 'Envoyer'); ?>
	<?php echo form_close(); ?>
</body>

</html>