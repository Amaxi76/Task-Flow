<link rel="stylesheet" href="<?= base_url('assets/css/tachevue.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/tachecarte.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/commentairevue.css') ?>">
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
		<h2><?php echo $titre ?><?= esc($tache['titre'])?></h2></h2>

		<div class="conteneur-boutons-taches">
			<?= form_open('taches/modifier') ?>
			<?= form_hidden('id', esc($tache['id_tache'])) ?>
			<div class="button secondary-button"  onclick="this.closest('form').submit();">
				<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M27.5 10.2167H15C12.3478 10.2167 9.80445 11.2702 7.92907 13.1456C6.05372 15.021 5 17.5645 5 20.2167V45.2167C5 47.8689 6.05372 50.4124 7.92907 52.2877C9.80445 54.1632 12.3478 55.2167 15 55.2167H42.5C48.025 55.2167 50 50.7167 50 45.2167V32.7167M53.1997 16.2168L29.3497 40.0667C26.9747 42.4417 19.9247 43.5417 18.3497 41.9667C16.7747 40.3917 17.8497 33.3417 20.2247 30.9667L44.0997 7.09173C44.6885 6.44938 45.4012 5.93303 46.1952 5.57378C46.989 5.21453 47.8475 5.01978 48.7187 5.00143C49.5897 4.9831 50.4557 5.14145 51.264 5.46698C52.0722 5.7925 52.8062 6.2785 53.4215 6.8955C54.0367 7.5125 54.5207 8.24775 54.844 9.0569C55.1672 9.86608 55.3235 10.7323 55.3027 11.6035C55.282 12.4746 55.0847 13.3326 54.7235 14.1254C54.362 14.9183 53.8437 15.6298 53.1997 16.2168Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				
				<button type="submit">Modifier la tâche</button>
			</div>
			<?= form_close() ?>

			<?= form_open('taches/supprimer') ?>
			<?= form_hidden('id', esc($tache['id_tache'])) ?>
			<div class="button danger-button" onclick="this.closest('form').submit();">
				<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M24 30V45M36 30V45M6 15H54M12 24V48.7273C12 53.8486 16.0294 58 21 58H39C43.9707 58 48 53.8486 48 48.7273V24M21 9C21 5.68629 23.6863 3 27 3H33C36.3138 3 39 5.68629 39 9V15H21V9Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				<button type="submit">Supprimer la tâche</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</header>

<div class="conteneur-principal">
	<div class="conteneur-carte-gauche">
		<div class="carte large" hexa="<?=  esc($tache['couleur_statut']) ?>">
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
			<div class="carte-description large">
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
	</div>
	
	<div class="conteneur-commentaire">

		<div class="conteneur-commentaire-tableau">
			<table class="tableau-commentaires">
				<thead style="background-color:<?=  esc($tache['couleur_statut']) ?>">
					<tr>
						<th>Date</th>
						<th>Commentaire</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($commentaires as $commentaire): ?>
						<tr>
							<td><?= esc($commentaire['date']) ?></td>
							<td><?= esc($commentaire['description']) ?></td>
							<td>
								<div class="conteneur-boutons-taches">
									<?= form_open('commentaire/modifier') ?>
									<?= form_hidden('id_commentaire', esc($commentaire['id_commentaire'])) ?>
									<div class="button secondary-button"  onclick="this.closest('form').submit();">
										<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M27.5 10.2167H15C12.3478 10.2167 9.80445 11.2702 7.92907 13.1456C6.05372 15.021 5 17.5645 5 20.2167V45.2167C5 47.8689 6.05372 50.4124 7.92907 52.2877C9.80445 54.1632 12.3478 55.2167 15 55.2167H42.5C48.025 55.2167 50 50.7167 50 45.2167V32.7167M53.1997 16.2168L29.3497 40.0667C26.9747 42.4417 19.9247 43.5417 18.3497 41.9667C16.7747 40.3917 17.8497 33.3417 20.2247 30.9667L44.0997 7.09173C44.6885 6.44938 45.4012 5.93303 46.1952 5.57378C46.989 5.21453 47.8475 5.01978 48.7187 5.00143C49.5897 4.9831 50.4557 5.14145 51.264 5.46698C52.0722 5.7925 52.8062 6.2785 53.4215 6.8955C54.0367 7.5125 54.5207 8.24775 54.844 9.0569C55.1672 9.86608 55.3235 10.7323 55.3027 11.6035C55.282 12.4746 55.0847 13.3326 54.7235 14.1254C54.362 14.9183 53.8437 15.6298 53.1997 16.2168Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<?= form_close() ?>
									<?= form_open('commentaire/supprimer') ?>
									<?= form_hidden('id_commentaire', esc($commentaire['id_commentaire'])) ?>
									<div class="button danger-button" onclick="this.closest('form').submit();">
										<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M24 30V45M36 30V45M6 15H54M12 24V48.7273C12 53.8486 16.0294 58 21 58H39C43.9707 58 48 53.8486 48 48.7273V24M21 9C21 5.68629 23.6863 3 27 3H33C36.3138 3 39 5.68629 39 9V15H21V9Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<?= form_close() ?>
								</div>
								
							</td>

						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		
		<?= form_open('commentaire/ajout') ?>
    <?= form_hidden('id_tache', esc($tache['id_tache'])) ?>
    <div class="conteneur-commentaire-ajout">
        <?php echo form_textarea('detail', set_value('detail'), 'id="description" placeholder="Votre commentaire" required class="textarea-commentaire" rows="1"'); ?>
        <?= validation_show_error('detail') ?>

        <div class="button secondary-button" id="ajout-bouton" onclick="this.closest('form').submit();">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M37.5 30H30M30 30H22.5M30 30V22.5M30 30V37.5M55 30C55 43.8071 43.8071 55 30 55C16.1929 55 5 43.8071 5 30C5 16.1929 16.1929 5 30 5C43.8071 5 55 16.1929 55 30Z" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
    <?= form_close() ?>

	
	</div>
</div>