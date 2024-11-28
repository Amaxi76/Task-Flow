<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecartepopup.css') ?>">

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
	</div>
</header>

<div class="conteneur-carte">
	<div class="carte carte-popup" hexa="#379EE8">
		<?= form_open('taches/stocker') ?>
			<div class="carte-entete">
				<input type="hidden" name="id_utilisateur" value="1"> <!-- TODO: à remplacer par l'utilisateur actuel -->

				<div class="carte-titre carte-bg-color">
					<?= form_input('titre', '', ['placeholder' => 'Titre de la tâche']) ?>
				</div>

				<div class="carte-options">
					<span class="badge">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="10" stroke-width="1.5"/>
							<path d="M12 8V12L14.5 14.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?= form_input(['type' => 'datetime-local', 'name' => 'echeance', 'value' => '' ]) ?>
					</span>
					<span class="badge">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.45001 14.97C3.52001 18.41 6.40002 21.06 9.98002 21.79" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2.04999 10.98C2.55999 5.93 6.81998 2 12 2C17.18 2 21.44 5.94 21.95 10.98" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M14.01 21.8C17.58 21.07 20.45 18.45 21.54 15.02" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<?= form_dropdown('id_statut', ['' => 'Choisissez un statut'] + array_column($statuts, 'libelle', 'id'), '', 'style="width: auto;"') ?>
					</span>
					<span class="badge">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 9V14" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12.0001 21.41H5.94005C2.47005 21.41 1.02005 18.93 2.70005 15.9L5.82006 10.28L8.76006 5.00003C10.5401 1.79003 13.4601 1.79003 15.2401 5.00003L18.1801 10.29L21.3001 15.91C22.9801 18.94 21.5201 21.42 18.0601 21.42H12.0001V21.41Z"  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M11.9945 17H12.0035" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<?= form_dropdown('id_priorite', ['' => 'Choisissez une priorité'] + array_column($priorites, 'libelle', 'id'), '', 'style="width: auto;"') ?>
					</span>
				</div>
			</div>

			<div class="carte-description">
				<?= form_textarea('detail', '', ['rows' => '10']) ?>
			</div>

			<div class="carte-ajout">
				<?= form_submit('submit', 'Ajouter la tâche', ['class' => 'button main-button']) ?>
			</div>
		<?= form_close() ?>
	</div>
</div>
