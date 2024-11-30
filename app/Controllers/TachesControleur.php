<?php 
namespace App\Controllers;

use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use Config\Pager;   

class TachesControleur extends BaseController 
{ 
	private int $idUtilisateur;
	private ServiceTriageTaches $trieur;
	private ServiceFiltrageTaches $filtreur;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/
	
	public function __construct() {
		$session = session ();
		$this->idUtilisateur = $session->get ('id');

		$this->initialiserServicesSession();
	}

	//TODO: il y a de la duplication avec TriageFiltrageControleur.php mais je ne sais pas comment factoriser de manière cohérente ici
	//C'est peut-être la meilleure solution de laisser comme ça
	private function initialiserServicesSession() {
		//dd('trieur');
		if( ServiceTriageTaches::estPresentEnSession() ) {
			$this->trieur = ServiceTriageTaches::getDepuisSession();
		}
		else {
			$this->trieur = new ServiceTriageTaches();
			$this->trieur->setDansSession();
		}

		//dd('filtreur');
		if( ServiceFiltrageTaches::estPresentEnSession() ) {
			$this->filtreur = ServiceFiltrageTaches::getDepuisSession();
		}
		else {
			$this->filtreur = new ServiceFiltrageTaches();
			$this->filtreur->setDansSession();
		}
	}

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	public function index ( $typeVue ): string {
		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger les modèles
		$tacheModele    = new ModeleVueCartesTaches ();
		$intituleModele = new ModeleIntitules ();

		// Appliquer les tris
		$tacheModele = $this->trieur->trier($tacheModele);
		$tacheModele = $this->filtreur->filtrer($tacheModele);

		$dataCorps = [];
		$dataCorps['idUtilisateur'] = $this->idUtilisateur;
		$dataCorps['statuts']       = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);
		$dataCorps['priorites']     = $intituleModele->getPrioritesUtilisateur ($this->idUtilisateur);


		$dataFiltre = [];
		$dataFiltre['trieur']   = $this->trieur;
		$dataFiltre['filtreur'] = $this->filtreur;

		helper (['form']);

		switch ( $typeVue ) {
			case 'toutes':
				// Constantes
				$NOMBRE_TACHES_PAR_PAGE = 6;

				// Configurer le pager
				$configPager = config (Pager::class);
				$configPager->perPage = $NOMBRE_TACHES_PAR_PAGE;
				
				$dataCorps['taches']        = $tacheModele   ->getCartesUtilisateurPaginees ($this->idUtilisateur, $NOMBRE_TACHES_PAR_PAGE);
				$dataCorps['pagerTaches']   = $tacheModele   ->pager;

				return view ('commun/entete', $dataEntete) . view ('/taches/afficherTachesVue', $dataCorps) . view('/taches/popupFiltreVue', $dataFiltre) .view ('commun/piedpage'); 

			case 'kanban':
				$taches       = $tacheModele   ->getCartesUtilisateur ($this->idUtilisateur);

				$dataCorps['taches'] = array_reduce($taches, function ($carry, $tache) {
					$statut = $tache['libelle_statut'];
					if (!isset($carry[$statut])) {
						$carry[$statut] = [];
					}
					$carry[$statut][] = $tache;
					return $carry;
				}, []);
				
				ksort($dataCorps['taches']);

				return view ('commun/entete', $dataEntete) . view ('/taches/kanbanTachesVue', $dataCorps) . view('/taches/popupFiltreVue', $dataFiltre) .view ('commun/piedpage'); 
			default:
				throw new \InvalidArgumentException('Type de vue non valide');
		}
	}

	public function ajouter (): string{
		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$dataCorps = [];
		$dataCorps['routeFormulaire'] = '/taches/appliquerAjout';
		$dataCorps['idUtilisateur']   = $this->idUtilisateur;
		$dataCorps['priorites']       = $intituleModele->getPrioritesUtilisateur( $this->idUtilisateur);
		$dataCorps['statuts']         = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);

		$dataCorps['tache'] = [
			'id' => '',
			'id_utilisateur' => $this->idUtilisateur,
			'titre' => old('titre', ''),
			'detail' => old('detail', ''),
			'date_echeance' => old('date_echeance', ''),
			'id_priorite' => old('id_priorite', ''),
			'id_statut' => old('id_statut', '')
		];

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/actionsTacheVue', $dataCorps) . view ('commun/piedpage'); 
	}

	public function appliquerAjout () {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$data = $request->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Validation des données
		$validation = \Config\Services::validation();
		$validation->setRules([
			'titre' => 'required',
			'date_echeance' => 'required|valid_date[Y-m-d\TH:i]',
			'id_priorite' => 'required|integer',
			'id_statut' => 'required|integer'
		]);

		
		if (!$validation->withRequest($this->request)->run()) {
			// Si la validation échoue, recharger le formulaire avec les erreurs
			return redirect()->back()->withInput()->with('errors', $validation->getErrors());
		}

		// Insérer les données
		$tacheModele->insert($data);

		// Charger la vue
		return redirect()->to('/taches');
	}

	public function appliquerSuppression () {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$idTache = $request->getPost ('id');

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Supprimer les données
		$tacheModele->where('id', $idTache)->delete ();

		// Charger la vue
		return redirect ()->to ('/taches');
	}

	public function modifier (): string {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$idTache = $request->getPost ('id');

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Modifier une tâche';

		// Charger les modèles
		$tacheModele    = new ModeleTaches ();
		$intituleModele = new ModeleIntitules ();

		// Charger les données
		$dataCorps = [];
		$dataCorps['routeFormulaire'] = '/taches/appliquerModification';
		$dataCorps['tache']           = $tacheModele->find ($idTache);
		$dataCorps['idUtilisateur']   = $this->idUtilisateur;
		$dataCorps['priorites']       = $intituleModele->getPrioritesUtilisateur ($this->idUtilisateur);
		$dataCorps['statuts']         = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/actionsTacheVue', $dataCorps) . view ('commun/piedpage');
	}

	public function appliquerModification () {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$data = $request->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Mettre à jour les données
		$tacheModele->update ($data['id'], $data);

		// Charger la vue
		//TODO: rediriger vers la page de détail de la tâche avec post
		return redirect ()->to ('/taches');
		//return redirect()->to('/taches/detail/' . $data['id'])->with('post', $data);
	}
}