<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/popupfiltre.css') ?>">

<div class="conteneur-menu-titre">
	<h2><?php echo $titre ?></h2>

	<div class="conteneur-menu-boutons">
		<div class="conteneur-menu-boutons-gauche">
			<a href="<?= base_url('taches/ajouter') ?>">
				<div class="button main-button" id="ajout-bouton">
					<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M37.5 30H30M30 30H22.5M30 30V22.5M30 30V37.5M55 30C55 43.8071 43.8071 55 30 55C16.1929 55 5 43.8071 5 30C5 16.1929 16.1929 5 30 5C43.8071 5 55 16.1929 55 30Z" stroke-width="3" stroke-linecap="round"/>
					</svg>
					<button>Ajouter une tâche</button>
				</div>
			</a>

			<div class="button secondary-button filtre-button">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 3H5C3.58579 3 2.87868 3 2.43934 3.4122C2 3.8244 2 4.48782 2 5.81466V6.50448C2 7.54232 2 8.06124 2.2596 8.49142C2.5192 8.9216 2.99347 9.18858 3.94202 9.72255L6.85504 11.3624C7.49146 11.7206 7.80967 11.8998 8.03751 12.0976C8.51199 12.5095 8.80408 12.9935 8.93644 13.5872C9 13.8722 9 14.2058 9 14.8729L9 17.5424C9 18.452 9 18.9067 9.25192 19.2613C9.50385 19.6158 9.95128 19.7907 10.8462 20.1406C12.7248 20.875 13.6641 21.2422 14.3321 20.8244C15 20.4066 15 19.4519 15 17.5424V14.8729C15 14.2058 15 13.8722 15.0636 13.5872C15.1959 12.9935 15.488 12.5095 15.9625 12.0976C16.1903 11.8998 16.5085 11.7206 17.145 11.3624L20.058 9.72255C21.0065 9.18858 21.4808 8.9216 21.7404 8.49142C22 8.06124 22 7.54232 22 6.50448V5.81466C22 4.48782 22 3.8244 21.5607 3.4122C21.1213 3 20.4142 3 19 3Z" />
				</svg>
				<button>Filtre</button>
			</div>
		</div>

		<div class="conteneur-menu-boutons-droite">
			<?= form_open('/taches/setNbTacheParPage', ['method' => 'post']) ?>
			<select name="parPage" id="parPage" onchange="this.form.submit()">
				<option value="4" <?= set_select('parPage', '4', $parPage == 4) ?>>4</option>
				<option value="6" <?= set_select('parPage', '6', $parPage == 6) ?>>6</option>
				<option value="8" <?= set_select('parPage', '8', $parPage == 8) ?>>8</option>
				<option value="10" <?= set_select('parPage', '10', $parPage == 10) ?>>10</option>
				<option value="12" <?= set_select('parPage', '12', $parPage == 12) ?>>12</option>
			</select>
			<?= form_close() ?>

			<div class="conteneur-menu-affichage">
				<a href="<?= base_url('taches/kanban') ?>">
					<div class="button secondary-button" style="border:none;"  >
						<svg  viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.5 33.125V17.5M42.5 42.5V17.5M30 23.75V17.5M15 5H45C48.5003 5 50.2506 5 51.5875 5.68122C52.7634 6.28041 53.7197 7.23653 54.3187 8.41256C55 9.7495 55 11.4997 55 15V45C55 48.5003 55 50.2506 54.3187 51.5875C53.7197 52.7634 52.7634 53.7197 51.5875 54.3187C50.2506 55 48.5003 55 45 55H15C11.4997 55 9.7495 55 8.41256 54.3187C7.23653 53.7197 6.28041 52.7634 5.68122 51.5875C5 50.2506 5 48.5003 5 45V15C5 11.4997 5 9.7495 5.68122 8.41256C6.28041 7.23653 7.23653 6.28041 8.41256 5.68122C9.7495 5 11.4997 5 15 5Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
				</a>

				<a href="<?= base_url('taches/toutes') ?>">
					<div class="button main-button" >
						<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.77778 5H21.6667C23.2008 5 24.4444 6.24365 24.4444 7.77778V21.6667C24.4444 23.2008 23.2008 24.4444 21.6667 24.4444H7.77778C6.24365 24.4444 5 23.2008 5 21.6667V7.77778C5 6.24365 6.24365 5 7.77778 5Z" stroke="black" stroke-width="2" stroke-linejoin="round"/>
							<path d="M7.77778 35.5556H21.6667C23.2008 35.5556 24.4444 36.7992 24.4444 38.3333V52.2222C24.4444 53.7564 23.2008 55 21.6667 55H7.77778C6.24365 55 5 53.7564 5 52.2222V38.3333C5 36.7992 6.24365 35.5556 7.77778 35.5556Z" stroke="black" stroke-width="2" stroke-linejoin="round"/>
							<path d="M38.3333 5H52.2222C53.7564 5 55 6.24365 55 7.77778V21.6667C55 23.2008 53.7564 24.4444 52.2222 24.4444H38.3333C36.7992 24.4444 35.5556 23.2008 35.5556 21.6667V7.77778C35.5556 6.24365 36.7992 5 38.3333 5Z" stroke="black" stroke-width="2" stroke-linejoin="round"/>
							<path d="M38.3333 35.5556H52.2222C53.7564 35.5556 55 36.7992 55 38.3333V52.2222C55 53.7564 53.7564 55 52.2222 55H38.3333C36.7992 55 35.5556 53.7564 35.5556 52.2222V38.3333C35.5556 36.7992 36.7992 35.5556 38.3333 35.5556Z" stroke="black" stroke-width="2" stroke-linejoin="round"/>
						</svg>
					</div>
				</a>
			</div>

		</div>
		
	</div>
</div>

<div class="conteneur-cartes">
	<?php foreach ($taches as $tache) : ?>
	<?php echo form_open('/taches/detail'); ?>
	<?= form_hidden('id', esc($tache['id_tache'])) ?>

	<div class="carte" onclick="this.closest('form').submit();">
	<div class="carte-entete">
				<div class="carte-titre" style= "background-color:<?=  esc($tache['couleur_statut']) ?>">
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
			<span class="commentaire-bulle carte-bg-color" style="background-color:<?=  esc($tache['couleur_statut']) ?>">
				<svg width="" height="" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 13.4876 3.36093 14.891 4 16.1272L3 21L7.8728 20C9.10904 20.6391 10.5124 21 12 21Z" stroke="#292929" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="commentaire-count"><?= esc($tache['nb_commentaires']) ?></span>
			</span>

			<?php if ($tache['nb_jours_avant_echeance'] <= 0) : ?>
				<p><?= abs($tache['nb_jours_avant_echeance']) ?> jours en retard</p>
			<?php endif; ?>
		</div>
	</div>

	<?= form_close() ?>

	<?php endforeach; ?>
</div>

<div id="pager">
	<?= $pagerTaches->links('taches', 'default_full') ?> 
</div>

<style>
	#pager {
		display: flex;
		justify-content: center;
		padding: 1rem;
	}

	#pager a {
		margin: 0 0.5rem;
		padding: 0.5rem 1rem;
		border-radius: 8px;
		text-decoration: none;
		color: #379EE8;
		background-color: #EAEAEA;
		transition: background-color 0.3s, color 0.3s;
	}

	#pager a:hover {
		background-color: #379EE8;
		color: white;
	}

	#pager .active a {
		font-weight: bold;
		background-color: #379EE8;
		color: white;
	}

	#pager .prev, #pager .next {
		margin: 0 1rem;
	}
</style>