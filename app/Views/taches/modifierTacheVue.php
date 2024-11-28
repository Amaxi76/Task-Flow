<?php echo form_open('/taches/appliquerModification'); ?>

<?= form_hidden('id_utilisateur', set_value('id_utilisateur', $idUtilisateur)); ?>
<?= form_hidden('id', set_value('id', $tache['id'])); ?>

<?php echo form_input('titre', set_value('titre', $tache['titre']), 'required'); ?>
<?php echo form_input('detail', set_value('detail', $tache['detail']), 'required'); ?>
<?php echo form_input('echeance', set_value('echeance', $tache['echeance']), 'required'); ?>

<?= form_dropdown(
    'id_statut', 
    array_reduce($statuts, function ($resultat, $statut) {
        $resultat[$statut['id']] = $statut['libelle']; // Clé : ID | Valeur : Libellé
        return $resultat;
    }, []), 
    set_value('id_statut', $tache['id_statut']), // Valeur par défaut (ID de statut)
    'style="width: auto;" required'
) ?>

<?= form_dropdown(
    'id_priorite', 
    array_reduce($priorites, function ($resultat, $priorite) {
        $resultat[$priorite['id']] = $priorite['libelle']; // Clé : ID | Valeur : Libellé
        return $resultat;
    }, []), 
    set_value('id_priorite', $tache['id_priorite']), // Valeur par défaut (ID de priorité)
    'style="width: auto;" required'
) ?>


<?php echo form_submit('submit', 'Modifier'); ?>
<?php echo form_reset('reset', 'Annuler'); ?>
<?php echo form_close(); ?>
