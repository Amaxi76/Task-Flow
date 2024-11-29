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

	public function index (): string {
		return $this->chargerPagePrincipale ();
	}

	private function chargerPagePrincipale (): string {
		// Constantes
		$NOMBRE_TACHES_PAR_PAGE = 4;

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger les modèles
		$tacheModele    = new ModeleVueCartesTaches ();
		$intituleModele = new ModeleIntitules ();

		// Appliquer les tris
		$tacheModele = $this->trieur->trier($tacheModele);
		$tacheModele = $this->filtreur->filtrer($tacheModele);

		// Configurer le pager
		$configPager = config (Pager::class);
		$configPager->perPage = $NOMBRE_TACHES_PAR_PAGE;

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['idUtilisateur'] = $this->idUtilisateur;
		$dataCorps['taches']        = $tacheModele   ->getCartesUtilisateurPaginees ($this->idUtilisateur, $NOMBRE_TACHES_PAR_PAGE);
		$dataCorps['statuts']       = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);
		$dataCorps['priorites']     = $intituleModele->getPrioritesUtilisateur ($this->idUtilisateur);
		$dataCorps['pagerTaches']   = $tacheModele   ->pager;

		// Charger la vue 
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('/taches/afficherTachesVue', $dataCorps) . view ('commun/piedpage'); 
	}

	public function ajouter (): string{
		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$dataCorps = [];
		$dataCorps['idUtilisateur'] = $this->idUtilisateur;
		$dataCorps['priorites']     = $intituleModele->getPrioritesUtilisateur( $this->idUtilisateur);
		$dataCorps['statuts']       = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/ajouterTacheVue', $dataCorps) . view ('commun/piedpage'); 
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
			'detail' => 'required',
			'echeance' => 'required|valid_date[Y-m-d\TH:i]',
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

	public function supprimer (): string {
		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Supprimer une tâche';

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/supprimerTacheVue') . view ('commun/piedpage');
	}

	public function appliquerSuppression () {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$idTache = $request->getPost ('id');

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Supprimer les données
		$tacheModele->delete ($idTache);

		// Charger la vue
		return redirect ()->to ('/taches');
	}

	public function modifier ( $idTache ): string {
		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Modifier une tâche';

		// Charger les modèles
		$tacheModele    = new ModeleTaches ();
		$intituleModele = new ModeleIntitules ();

		// Charger les données
		$dataCorps = [];
		$dataCorps['tache']     = $tacheModele->find ($idTache);
		$dataCorps['idUtilisateur'] = $this->idUtilisateur;
		$dataCorps['priorites'] = $intituleModele->getPrioritesUtilisateur ($this->idUtilisateur);
		$dataCorps['statuts']   = $intituleModele->getStatutsUtilisateur ($this->idUtilisateur);

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/modifierTacheVue', $dataCorps) . view ('commun/piedpage');
	}

	public function appliquerModification () {
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$data['tache'] = $request->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Mettre à jour les données
		$tacheModele->update ($data['tache']['id'], $data['tache']);

		// Charger la vue
		return redirect ()->to ('/taches');
	}
} 