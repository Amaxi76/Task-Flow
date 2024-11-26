<link rel="stylesheet" href="assets/css/tachecarte.css">
<div class="conteneur">

<?php foreach ($taches as $tache) : ?>
	<div class="carte">
    <div class="carte-entete">
        <div class="carte-titre">
            <h5><?= esc($tache['titre'])?></h5>
        </div>
        <div class="carte-options">
            <span class="badge"><img src="assets/svg/rappel.svg" > <?= esc($tache['rappel']) ?></span>
            <span class="badge"><img src="assets/svg/statut.svg" > <?= esc($tache['statut']) ?></span>
            <span class="badge"><img src="assets/svg/priorite.svg" > <?= esc($tache['priorite']) ?></span>
        </div>
    </div>
    <div class="carte-description">
        <p><?= esc($tache['detail']) ?></p>
    </div>
    <div class="carte-commentaire">
        <span class="commentaire-bulle">
            <img src="path/to/comment-icon.svg" alt="Commentaires">
            <span class="commentaire-count">1</span>
        </span>
    </div>
</div>


<?php endforeach; ?>
</div>