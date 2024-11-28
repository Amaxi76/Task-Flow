<?= form_open('/taches/appliquerAjout'); ?>

<?= form_hidden('id_utilisateur', set_value('id_utilisateur', $idUtilisateur)); ?>
<?= form_input('titre', set_value('titre'), 'required'); ?>
<?= form_input('detail', set_value('detail'), 'required'); ?>
<?= form_input(['type' => 'datetime-local', 'name' => 'echeance', 'value' => '' ]) ?>

<?= form_dropdown(
    'id_statut', 
    array_column($statuts, 'libelle', 'id'), // Génère un tableau associatif [id => libelle]
    'style="width: auto;" required' // Attributs supplémentaires
); ?>


<?= form_dropdown(
    'id_priorite', 
    array_column($priorites, 'libelle', 'id'), // Génère un tableau associatif [id => libelle]
    'style="width: auto;" required' // Attributs supplémentaires
); ?>

<?= form_submit('submit', 'Ajouter'); ?>
<?= form_reset('reset', 'Annuler'); ?>

<?= form_close(); ?>

