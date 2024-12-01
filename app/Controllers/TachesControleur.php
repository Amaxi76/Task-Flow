<?php 
namespace App\Controllers;

use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use App\Models\Utilisateurs\SessionUtilisateur;
use CodeIgniter\Validation\ValidationInterface;
use Config\Pager;
use App\Models\Taches\OutilsConversion;

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
	/*           METHODES INTERNES           */
	/*---------------------------------------*/

	public function getValideurDonnees(): ValidationInterface{
		$validation = \Config\Services::validation();
		$validation->setRules([
			'titre'         => 'required',
			'date_echeance' => 'required|valid_date[Y-m-d\TH:i]',
			'id_priorite'   => 'required|integer',
			'id_statut'     => 'required|integer'
		]);

		return $validation;
	}

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	public function index ( ): string {
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Charger les modèles
		$tacheModele    = new ModeleVueCartesTaches ();
		$intituleModele = new ModeleIntitules ();

		// Appliquer les tris
		$tacheModele = $this->session->getTriageTaches()  ->trier($tacheModele);
		$tacheModele = $this->session->getFiltrageTaches()->filtrer($tacheModele);

		$data = [];
		$data['titre']         = 'Liste des Tâches';
		$data['idUtilisateur'] = $this->session ->getIdUtilisateur();
		$data['statuts']       = $intituleModele->getStatutsUtilisateur        ($this->session->getIdUtilisateur() );
		$data['priorites']     = $intituleModele->getPrioritesUtilisateur      ($this->session->getIdUtilisateur() );
		$data['pagerTaches']   = $tacheModele   ->pager;

		$dataFiltre = [];
		$dataFiltre['trieur'] = $this->session->getTriageTaches();
		$dataFiltre['filtreur'] = $this->session->getFiltrageTaches();

		// Générer la vue adaptée
		helper (['form']);
		$corpsPage = "";
		switch ( $this->session->getTypeVue() ){ 
			case SessionUtilisateur::VUE_GENERALE:
				$corpsPage = $this->getVueGenerale( $data, $tacheModele );
				break;
			case SessionUtilisateur::VUE_KANBAN:
				$corpsPage = $this->getVueKanban( $data, $tacheModele );
				break;
			default:
				throw new \InvalidArgumentException('Type de vue non valide');
		}

		// Charger la vue
		return view ('commun/entete') . $corpsPage . view('/taches/popupFiltreVue', $dataFiltre) .view ('commun/piedpage');
	}

	private function getVueGenerale( array $data, ModeleVueCartesTaches $tacheModele ): string {
		$nbTachesParPage = $this->session->getNbTachesParPage();

		// Configurer le pager
		$configPager = config (Pager::class);
		$configPager->perPage = $nbTachesParPage;
		
		// Récupération et préparation des données
		$data['taches']        = $tacheModele   ->getCartesUtilisateurPaginees ($this->session->getIdUtilisateur(), $nbTachesParPage);
		$data['pagerTaches']   = $tacheModele   ->pager;
		$data['parPage']       = $nbTachesParPage;

		return view ('/taches/afficherTachesVue', $data); 
	}

	private function getVueKanban( array $data, ModeleVueCartesTaches $tacheModele ): string {
		// Récupération des données
		$taches = $tacheModele->getCartesUtilisateur ($this->session->getIdUtilisateur());

		// Préparation des données
		$data['taches'] = array_reduce($taches, function ($carry, $tache) {
			$statut = $tache['libelle_statut'];
			if (!isset($carry[$statut])) {
				$carry[$statut] = [];
			}
			$carry[$statut][] = $tache;
			return $carry;
		}, []);
		
		ksort($data['taches']);

		return view ('/taches/kanbanTachesVue', $data); 
	}

	public function changerNbTachesParPage ( ) {
		// Récupérer les données du formulaire
		$data = request()->getPost ();
	
		// Mettre à jour les données de la session
		$this->session->setNbTachesParPage ( $data['parPage'] );

		//rediriger vers la page de la vue en cours
		return redirect()->to ('/taches');
	}

	public function changerTypeVue( $typeVue ){
		$this->session->setTypeVue( $typeVue );

		return redirect()->to ('/taches');
	}

	public function ajouter (): string{
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$data = [];
		$data['titre']           = 'Liste des Tâches';
		$data['routeFormulaire'] = '/taches/appliquerAjout';
		$data['idUtilisateur']   = $this->session->getIdUtilisateur();
		$data['priorites']       = $intituleModele->getPrioritesUtilisateur($this->session->getIdUtilisateur());
		$data['statuts']         = $intituleModele->getStatutsUtilisateur  ($this->session->getIdUtilisateur());

		$data['tache'] = [
			'id'             => '',
			'id_utilisateur' => $this->session->getIdUtilisateur(),
			'titre'          => old('titre', ''),
			'detail'         => old('detail', ''),
			'date_echeance'  => old('date_echeance', ''),
			'id_priorite'    => old('id_priorite', ''),
			'id_statut'      => old('id_statut', ''),
			'rappel'         => old('rappel', ''),
			'unite'          => old('unite', '')
		];

		// Charger la vue
		helper (['form']);
		return view ('commun/entete') . view ('taches/actionsTacheVue', $data) . view ('commun/piedpage'); 
	}

	public function appliquerAjout () {
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );

		// Récupérer les données du formulaire
		$data = request()->getPost ();

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Validation des données
		$valideur = $this->getValideurDonnees();
		$donneesValides = $valideur->withRequest($this->request )->run();
		if( !$donneesValides ){
			return redirect()->back()->withInput()->with('errors', $valideur->getErrors());
		}

		// Convertir les données
		$data['rappel'] = OutilsConversion::convertirEnMinutes( $data['rappel'], $data['unite'] );

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

	public function modifier () {
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost( 'id' );
		$idTache = $this->session->getIdTache();

		// Vérifier qu'il n'y a pas de problème
		if( !$this->session->idTacheExiste() ) return redirect()->to(site_url('taches'));

		// Charger les modèles
		$tacheModele    = new ModeleTaches ();
		$intituleModele = new ModeleIntitules ();

		// Charger les données
		$tache = $tacheModele->find ($idTache);
		$tache['rappel']      = OutilsConversion::convertirMinutesEnUnite( $tache['rappel'], 'heure' );

		$data = [];
		$data['titre'] = 'Liste des Tâches';
		$data['routeFormulaire'] = '/taches/appliquerModification';		
		$data['tache']   = $tache;
		$data['idUtilisateur']   = $this->session ->getIdUtilisateur();
		$data['priorites']       = $intituleModele->getPrioritesUtilisateur ($this->session->getIdUtilisateur ());
		$data['statuts']         = $intituleModele->getStatutsUtilisateur   ($this->session->getIdUtilisateur ());

		// Charger la vue
		helper (['form']);
		return view ('commun/entete') . view ('taches/actionsTacheVue', $data) . view ('commun/piedpage');
	}

	public function appliquerModification () {
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost( 'id' );

		// Récupérer les données du formulaire
		$data = request()->getPost ();

		// Validation des données
		$valideur = $this->getValideurDonnees();
		$donneesValides = $valideur->withRequest($this->request )->run();
		if( !$donneesValides ){
			return redirect()->back()->withInput()->with('errors', $valideur->getErrors());
		}

		// Convertir les données
		$data['rappel'] = OutilsConversion::convertirEnMinutes( $data['rappel'], $data['unite'] );

		// Charger le modèle
		$tacheModele = new ModeleTaches ();

		// Mettre à jour les données
		$tacheModele->update ($this->session->getIdTache(), $data);

		// Charger la vue
		return redirect ()->to ('/taches/detail');
<<<<<<< HEAD
=======
		//TODO: tester : 
		// return redirect()->back();
	}

	public function changerNbTachesParPage ( ) {
		// Récupérer les données du formulaire
		$data = request()->getPost ();

		$this->session->setNbTachesParPage ( $data['parPage'] );

		//TODO: rediriger vers la page de la vue en cours
>>>>>>> 032ef16a21c76bd2eebd64d3aa4f101c32876ec7
	}
}