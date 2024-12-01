<?php 
namespace App\Controllers;

use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use App\Models\Utilisateurs\SessionUtilisateur;
use Config\Pager;

//TODO: le mieux serait de passer direcement les données dans la session plutot qu'avec les formulaires POST ?
class TachesControleur extends BaseController 
{ 
	private SessionUtilisateur $session;
	private ServiceTriageTaches $trieur;
	private ServiceFiltrageTaches $filtreur;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/
	
	public function __construct() {
		$this->session = new SessionUtilisateur();
	}

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	public function index (): string {
		return $this->chargerPagePrincipale ();
	}

	//TODO: remettre directement dans index car la méthode n'est pas réutilisée
	private function chargerPagePrincipale (): string {
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Constantes
		$NOMBRE_TACHES_PAR_PAGE = 8;

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger les modèles
		$tacheModele    = new ModeleVueCartesTaches ();
		$intituleModele = new ModeleIntitules ();

		// Appliquer les tris
		$tacheModele = $this->session->getTriageTaches()  ->trier($tacheModele);
		$tacheModele = $this->session->getFiltrageTaches()->filtrer($tacheModele);

		// Configurer le pager
		$configPager = config (Pager::class);
		$configPager->perPage = $NOMBRE_TACHES_PAR_PAGE;

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['idUtilisateur'] = $this->session ->getIdUtilisateur();
		$dataCorps['taches']        = $tacheModele   ->getCartesUtilisateurPaginees ($this->session->getIdUtilisateur(), $NOMBRE_TACHES_PAR_PAGE);
		$dataCorps['statuts']       = $intituleModele->getStatutsUtilisateur        ($this->session->getIdUtilisateur() );
		$dataCorps['priorites']     = $intituleModele->getPrioritesUtilisateur      ($this->session->getIdUtilisateur() );
		$dataCorps['pagerTaches']   = $tacheModele   ->pager;

		$dataFiltre = [];
		$dataFiltre['trieur'] = $this->session->getTriageTaches();
		$dataFiltre['filtreur'] = $this->session->getFiltrageTaches();

		// Charger la vue 
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('/taches/afficherTachesVue', $dataCorps) . view('/taches/popupFiltreVue', $dataFiltre) .view ('commun/piedpage'); 
	}

	public function ajouter (): string{
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$dataCorps = [];
		$dataCorps['routeFormulaire'] = '/taches/appliquerAjout';
		$dataCorps['idUtilisateur']   = $this->session->getIdUtilisateur();
		$dataCorps['priorites']       = $intituleModele->getPrioritesUtilisateur($this->session->getIdUtilisateur());
		$dataCorps['statuts']         = $intituleModele->getStatutsUtilisateur  ($this->session->getIdUtilisateur());

		$dataCorps['tache'] = [
			'id' => '',
			'id_utilisateur' => $this->session->getIdUtilisateur(),
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
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Récupérer les données du formulaire
		$data = request()->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Validation des données
		$validation = \Config\Services::validation();
		$validation->setRules([
			'titre'         => 'required',
			'date_echeance' => 'required|valid_date[Y-m-d\TH:i]',
			'id_priorite'   => 'required|integer',
			'id_statut'     => 'required|integer'
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
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );
		$idTache = request()->getPost ('id');

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Supprimer les données
		$tacheModele->where('id', $idTache )->delete ();

		// Charger la vue
		return redirect ()->to ('/taches');
	}

	public function modifier (): string {
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );
		$idTache = request()->getPost ('id');

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Modifier une tâche';

		// Charger les modèles
		$tacheModele    = new ModeleTaches ();
		$intituleModele = new ModeleIntitules ();

		// Charger les données
		$dataCorps = [];
		$dataCorps['routeFormulaire'] = '/taches/appliquerModification';
		$dataCorps['tache']           = $tacheModele   ->find ($idTache);
		$dataCorps['idUtilisateur']   = $this->session ->getIdUtilisateur();
		$dataCorps['priorites']       = $intituleModele->getPrioritesUtilisateur ($this->session->getIdUtilisateur ());
		$dataCorps['statuts']         = $intituleModele->getStatutsUtilisateur   ($this->session->getIdUtilisateur ());

		// Charger la vue
		helper (['form']);
		return view ('commun/entete', $dataEntete) . view ('taches/actionsTacheVue', $dataCorps) . view ('commun/piedpage');
	}

	public function appliquerModification () {
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost( 'id' );

		// Récupérer les données du formulaire
		$data = request()->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Mettre à jour les données
		$tacheModele->update ($this->session->getIdTache(), $data);

		// Charger la vue
		return redirect ()->to ('/taches/detail');
	}
}