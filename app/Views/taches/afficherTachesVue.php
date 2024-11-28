<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">
<script src="<?= base_url('assets/js/carte.js') ?>"></script>

<header id="up-link">
	<div class="conteneur-entete">
		<img src="<?= base_url('assets/images/Logo.svg') ?>" alt="Logo de TaskFlow">
		
		<div class="button main-button">
			<svg viewBox="0 0 43 36" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M27.5294 24.0714V30.9524C27.5294 33.1878 25.7298 35 23.5098 35H5.0196C2.79964 35 1 33.1878 1 30.9524V5.04762C1 2.81218 2.79964 1 5.01961 1H23.5098C25.7298 1 27.5294 2.81218 27.5294 5.04762V11.9286M11.8529 18H42M42 18L35.9704 11.9286M42 18L35.9704 24.0715" />
			</svg>
			<button>Déconnexion</button>
		</div>
	</div>
		
	<div class="conteneur-menu-titre">
		<h2><?php echo $titre ?></h2>

		<div class="conteneur-menu-boutons">
			<a href="<?= base_url('taches/ajouter') ?>">
				<div class="button main-button" id="ajout-bouton">
					<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M37.5 30H30M30 30H22.5M30 30V22.5M30 30V37.5M55 30C55 43.8071 43.8071 55 30 55C16.1929 55 5 43.8071 5 30C5 16.1929 16.1929 5 30 5C43.8071 5 55 16.1929 55 30Z" stroke-width="3" stroke-linecap="round"/>
					</svg>
					<button>Ajouter une tâche</button>
				</div>
			</a>

			<div class="button secondary-button">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 3H5C3.58579 3 2.87868 3 2.43934 3.4122C2 3.8244 2 4.48782 2 5.81466V6.50448C2 7.54232 2 8.06124 2.2596 8.49142C2.5192 8.9216 2.99347 9.18858 3.94202 9.72255L6.85504 11.3624C7.49146 11.7206 7.80967 11.8998 8.03751 12.0976C8.51199 12.5095 8.80408 12.9935 8.93644 13.5872C9 13.8722 9 14.2058 9 14.8729L9 17.5424C9 18.452 9 18.9067 9.25192 19.2613C9.50385 19.6158 9.95128 19.7907 10.8462 20.1406C12.7248 20.875 13.6641 21.2422 14.3321 20.8244C15 20.4066 15 19.4519 15 17.5424V14.8729C15 14.2058 15 13.8722 15.0636 13.5872C15.1959 12.9935 15.488 12.5095 15.9625 12.0976C16.1903 11.8998 16.5085 11.7206 17.145 11.3624L20.058 9.72255C21.0065 9.18858 21.4808 8.9216 21.7404 8.49142C22 8.06124 22 7.54232 22 6.50448V5.81466C22 4.48782 22 3.8244 21.5607 3.4122C21.1213 3 20.4142 3 19 3Z" />
				</svg>
				<button>Filtre</button>
			</div>
			
		</div>
	</div>
</header>

<div class="conteneur-cartes">
	<?php foreach ($taches as $tache) : ?>
	<?php echo form_open('/taches/detail'); ?>
	<?= form_hidden('id_tache', esc($tache['id_tache'])) ?>

	<div class="carte" hexa="<?=  esc($tache['couleur_statut']) ?>" onclick="this.closest('form').submit();">
	<div class="carte-entete">
				<div class="carte-titre carte-bg-color">
					<h5><?= esc($tache['titre'])?></h5>
					<p><?= esc($tache['libelle_statut'])?></p>
				</div>
				<div class="carte-options">
					<span class="badge">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="10" stroke-width="1.5"/>
							<path d="M12 8V12L14.5 14.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?= esc($tache['date_echeance']) ?>
					</span>
					<span class="badge">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 9V14" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12.0001 21.41H5.94005C2.47005 21.41 1.02005 18.93 2.70005 15.9L5.82006 10.28L8.76006 5.00003C10.5401 1.79003 13.4601 1.79003 15.2401 5.00003L18.1801 10.29L21.3001 15.91C22.9801 18.94 21.5201 21.42 18.0601 21.42H12.0001V21.41Z"  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M11.9945 17H12.0035" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?= esc($tache['libelle_priorite']) ?>
					</span>
				</div>
			</div>
		<div class="carte-description">
			<p><?= esc($tache['detail']) ?></p>
		</div>
		<div class="carte-commentaire">
			<span class="commentaire-bulle carte-bg-color">
				<svg width="" height="" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 13.4876 3.36093 14.891 4 16.1272L3 21L7.8728 20C9.10904 20.6391 10.5124 21 12 21Z" stroke="#292929" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="commentaire-count"><?= esc($tache['nb_commentaires']) ?></span>
			</span>
		</div>
	</div>

	<?= form_close() ?>

	<?php endforeach; ?>
</div>

<!-- TODO: à adapter avec le CSS -->
<style>
    #pager a {
        margin-right: 10px; /* Ajoute un espace entre les liens */
    }

    #pager .active a {
        font-weight: bold; /* Exemple de personnalisation supplémentaire */
    }

    #pager .prev, #pager .next {
        margin-right: 20px;
    }
</style>

<div id="pager">
	<?= $pagerTaches->links('taches', 'default_full') ?> 
</div>