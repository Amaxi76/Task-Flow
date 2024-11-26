<link rel="stylesheet" href="assets/css/tachecarte.css">
<script src="assets/js/carte.js"></script>
<div class="conteneur">
	<?php foreach ($taches as $tache) : ?>
	<div class="carte" hexa="<?=  esc($tache['statutHexa']) ?>">
		<div class="carte-entete">
			<div class="carte-titre carte-bg-color">
				<h5><?= esc($tache['titre'])?></h5>
				<svg width="" height="" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">      
					<path d="M12,6 C12.5522847,6 13,5.55228475 13,5 C13,4.44771525 12.5522847,4 12,4 C11.4477153,4 11,4.44771525 11,5 C11,5.55228475 11.4477153,6 12,6 Z" id="shape-03" stroke="" stroke-width="2" stroke-linecap="round" stroke-dasharray="0,0"></path>
					<path d="M12,13 C12.5522847,13 13,12.5522847 13,12 C13,11.4477153 12.5522847,11 12,11 C11.4477153,11 11,11.4477153 11,12 C11,12.5522847 11.4477153,13 12,13 Z" id="shape-03" stroke="" stroke-width="2" stroke-linecap="round" stroke-dasharray="0,0"></path>
					<path d="M12,20 C12.5522847,20 13,19.5522847 13,19 C13,18.4477153 12.5522847,18 12,18 C11.4477153,18 11,18.4477153 11,19 C11,19.5522847 11.4477153,20 12,20 Z" id="shape-03" stroke="" stroke-width="2" stroke-linecap="round" stroke-dasharray="0,0"> </path>
				</svg>
			</div>
			<div class="carte-options">
				<span class="badge">
					<svg width="" height="" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12" cy="12" r="10" stroke="" stroke-width="1.5"/>
						<path d="M12 8V12L14.5 14.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?= esc($tache['rappel']) ?>
				</span>
				<span class="badge">
					<svg width="" height="" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.45001 14.97C3.52001 18.41 6.40002 21.06 9.98002 21.79" stroke="" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M2.04999 10.98C2.55999 5.93 6.81998 2 12 2C17.18 2 21.44 5.94 21.95 10.98" stroke="" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M14.01 21.8C17.58 21.07 20.45 18.45 21.54 15.02" stroke="" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?= esc($tache['statut']) ?>
				</span>
				<span class="badge">
					<svg width="" height="" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 9V14" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M12.0001 21.41H5.94005C2.47005 21.41 1.02005 18.93 2.70005 15.9L5.82006 10.28L8.76006 5.00003C10.5401 1.79003 13.4601 1.79003 15.2401 5.00003L18.1801 10.29L21.3001 15.91C22.9801 18.94 21.5201 21.42 18.0601 21.42H12.0001V21.41Z" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M11.9945 17H12.0035" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?= esc($tache['priorite']) ?>
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
				<span class="commentaire-count">1</span>
			</span>
		</div>
	</div>

	<?php endforeach; ?>
</div>