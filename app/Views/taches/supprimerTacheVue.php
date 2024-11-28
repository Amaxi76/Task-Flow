<?php echo form_open('/taches/appliquerSuppression'); ?>
<?php echo form_input('id', set_value('id'), 'required'); ?>
<?php echo form_submit('submit', 'Supprimer'); ?>
<?php echo form_reset('reset', 'Annuler'); ?>
<?php echo form_close(); ?>

