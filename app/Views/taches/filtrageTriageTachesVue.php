<?= form_open('taches/filtres/appliquer') ?>

<h2>Tris</h2>

<!-- Tri par titre -->
<label for="tri_titre">Trier par titre</label>
<?= form_dropdown('tri_titre', 
    ['' => 'Aucun', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], 
    $trieur->getTri('titre') ?? '', 
    ['id' => 'tri_titre']
) ?>

<!-- Tri par échéance -->
<label for="tri_date_echeance">Trier par échéance</label>
<?= form_dropdown('tri_date_echeance', 
    ['' => 'Aucun', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], 
    $trieur->getTri('date_echeance') ?? '', 
    ['id' => 'tri_date_echeance']
) ?>

<!-- Tri par date d'ajout -->
<label for="tri_date_ajout">Trier par date d'ajout</label>
<?= form_dropdown('tri_date_ajout', 
    ['' => 'Aucun', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], 
    $trieur->getTri('date_ajout') ?? '', 
    ['id' => 'tri_date_ajout']
) ?>

<?= form_submit('submit', 'Appliquer les filtres') ?>

<?= form_close() ?>
