<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialisation des filtres</title>
</head>
<body>
    <h1>Formulaire de Filtrage des Tâches</h1>

    <!-- Formulaire pour initialiser les valeurs des filtres -->
    <?= form_open('taches/filtres/appliquer') ?>

    <!-- Tri des tâches -->
    <h2>Tris</h2>
    <label for="tri_titre">Trier par titre</label>
    <?= form_dropdown('tri_titre', ['' => 'Sélectionner', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], '', ['id' => 'tri_titre']) ?>

    <label for="tri_echeance">Trier par échéance</label>
    <?= form_dropdown('tri_echeance', ['' => 'Sélectionner', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], '', ['id' => 'tri_echeance']) ?>

    <label for="tri_ajoute_le">Trier par date d'ajout</label>
    <?= form_dropdown('tri_ajoute_le', ['' => 'Sélectionner', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], '', ['id' => 'tri_ajoute_le']) ?>

    <!-- Filtres Simples -->
    <h2>Filtres Simples</h2>
    <label for="date_min">Date Minimum :</label>
    <?= form_input(['type' => 'date', 'name' => 'date_min', 'id' => 'date_min', 'value' => '']) ?>

    <label for="date_max">Date Maximum :</label>
    <?= form_input(['type' => 'date', 'name' => 'date_max', 'id' => 'date_max', 'value' => '']) ?>

    <label for="contient">Contient (dans le titre ou la description) :</label>
    <?= form_input(['type' => 'text', 'name' => 'contient', 'id' => 'contient', 'value' => '']) ?>

    <!-- Filtres Multiples -->
    <h2>Filtres Multiples</h2>
    <label for="priorite">Priorité :</label><br>
    <?= form_checkbox('priorite[]', 'Haute', false) ?> Haute<br>
    <?= form_checkbox('priorite[]', 'Moyenne', false) ?> Moyenne<br>
    <?= form_checkbox('priorite[]', 'Basse', false) ?> Basse<br>

    <label for="statut">Statut :</label><br>
    <?= form_checkbox('statut[]', 'En cours', false) ?> En cours<br>
    <?= form_checkbox('statut[]', 'Terminé', false) ?> Terminé<br>
    <?= form_checkbox('statut[]', 'En attente', false) ?> En attente<br>

    <!-- Bouton de soumission -->
    <?= form_submit('submit', 'Appliquer les filtres') ?>

    <?= form_close() ?>

</body>
</html>
