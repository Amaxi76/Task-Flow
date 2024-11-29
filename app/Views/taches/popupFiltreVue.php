
<?= form_open('taches/filtres/appliquer') ?>
<div id="filter-popup" class="popup">
	<div class="popup-content">
		<div class="conteneur-elements-filtre">
			<span class="close-btn">&times;</span>

			<div class="tri-filtre">
				<h3>Tris</h3>
				<div class="conteneur-tri">

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

					<br>

					<!-- Tri par date d'ajout -->
					<label for="tri_date_ajout">Trier par date d'ajout</label>
					<br>
					<?= form_dropdown('tri_date_ajout', 
						['' => 'Aucun', 'ASC' => 'Ascendant', 'DESC' => 'Descendant'], 
						$trieur->getTri('date_ajout') ?? '', 
						['id' => 'tri_date_ajout']
					) ?>
				</div>
			</div>

			<div class="filtres-filtre">
				<h3>Filtres</h3>

				<!-- Filtre par date d'échéance -->
				<label for="deb_date_echeance">Date d'échéance minimale</label>
				<?= form_input([
					'name' => 'deb_date_echeance',
					'id' => 'deb_date_echeance',
					'type' => 'datetime-local',
					'value' => !empty($filtreur->getTri('deb_date_echeance')) ? date('Y-m-d\TH:i', strtotime($filtreur->getTri('deb_date_echeance'))) : ''
					//'value' => $filtreur->getTri('deb_date_echeance') ?? ''
				]) ?>

				<br>

				<label for="fin_date_echeance">Date d'échéance maximale</label>
				<?= form_input([
					'name' => 'fin_date_echeance',
					'id' => 'fin_date_echeance',
					'type' => 'datetime-local',
					'value' => !empty($filtreur->getTri('fin_date_echeance')) ? date('Y-m-d\TH:i', strtotime($filtreur->getTri('fin_date_echeance'))) :''
					//'value' => $filtreur->getTri('fin_date_echeance') ?? ''
				]) ?>

				<br>

				<!-- Filtre par priorité -->
				<label for="priorite">Priorité</label>
				<?= form_dropdown('priorite', 
					['' => 'Toutes'] + array_column($priorites, 'libelle', 'libelle'),
					$filtreur->getTri('priorite') ?? '',
					['id' => 'priorite']
				) ?>


				<!-- Filtre par statut -->
				<label for="statut">Statut</label>
				<?= form_dropdown('statut', 
					['' => 'Tous'] + array_column($statuts, 'libelle', 'libelle'),
					$filtreur->getTri('statut') ?? '',
					['id' => 'statut']
				) ?>
			</div>

			<div class="recherche-filtre">
				<h3>Recherche</h3>
				<?= form_input('contient', $filtreur->getTri('contient') ?? '', ['id' => 'contient']) ?>
			</div>
		</div>

		<div class="boutons-filtre">
			<?= form_reset('reset', 'Réinitialiser', ['class' => 'button secondary-button']) ?>
			<?= form_submit('submit', 'Appliquer', ['class' => 'button main-button']) ?>
		</div>


	</div>
</div>

<?= form_close() ?>

<script src="<?= base_url( 'assets/js/filtrepopup.js') ?>"></script>


