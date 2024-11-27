<?php echo form_open('/taches/stocker'); ?>
<input type="hidden" id="id_utilisateur" value="1"> <!-- TODO: remplacer par l'id de l'utilisateur connecté -->
<?php echo form_input('titre', set_value('titre'), 'required'); ?>
<?php echo form_input('detail', set_value('detail'), 'required'); ?>
<?php echo form_input('echeance', set_value('echeance'), 'required'); ?>
<?php echo form_dropdown('id_priorite', $priorites, set_value('id_priorite'), 'required'); ?>
<?php echo form_dropdown('id_statut', $statuts, set_value('id_statut'), 'required'); ?>
<?php echo form_submit('submit', 'Ajouter'); ?>
<?php echo form_reset('reset', 'Annuler'); ?>
<?php echo form_close(); ?>

