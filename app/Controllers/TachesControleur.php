<?php 
namespace App\Controllers;

use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use App\Models\Utilisateurs\SessionUtilisateur;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Validation\ValidationInterface;
use Config\Pager;
use App\Models\Taches\OutilsConversion;

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

	public function index ( $typeVue ): string {
		// Mettre à jour les données de la session
		$this->session->setIdTache( null );
		

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger les modèles
		$tacheModele    = new ModeleVueCartesTaches ();
		$intituleModele = new ModeleIntitules ();

		// Appliquer les tris
		$tacheModele = $this->session->getTriageTaches()  ->trier($tacheModele);
		$tacheModele = $this->session->getFiltrageTaches()->filtrer($tacheModele);

		$dataCorps = [];
		$dataCorps['idUtilisateur'] = $this->session ->getIdUtilisateur();
		$dataCorps['statuts']       = $intituleModele->getStatutsUtilisateur        ($this->session->getIdUtilisateur() );
		$dataCorps['priorites']     = $intituleModele->getPrioritesUtilisateur      ($this->session->getIdUtilisateur() );
		$dataCorps['pagerTaches']   = $tacheModele   ->pager;

		$dataFiltre = [];
		$dataFiltre['trieur'] = $this->session->getTriageTaches();
		$dataFiltre['filtreur'] = $this->session->getFiltrageTaches();

		helper (['form']);

		switch ( $typeVue ) {
			case 'toutes':
				// Constantes
				$nbTachesParPage = $this->session->getNbTachesParPage();

				// Configurer le pager
				$configPager = config (Pager::class);
				$configPager->perPage = $nbTachesParPage;
				
				$dataCorps['taches']        = $tacheModele   ->getCartesUtilisateurPaginees ($this->session->getIdUtilisateur(), $nbTachesParPage);
				$dataCorps['pagerTaches']   = $tacheModele   ->pager;
				$dataCorps['parPage']       = $nbTachesParPage;

				return view ('commun/entete', $dataEntete) . view ('/taches/afficherTachesVue', $dataCorps) . view('/taches/popupFiltreVue', $dataFiltre) .view ('commun/piedpage'); 

			case 'kanban':
				$taches       = $tacheModele   ->getCartesUtilisateur ($this->session->getIdUtilisateur());

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
		return redirect()->to('/taches/toutes');
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

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Modifier une tâche';

		// Charger les modèles
		$tacheModele    = new ModeleTaches ();
		$intituleModele = new ModeleIntitules ();

		// Charger les données
		$dataCorps = [];
		$dataCorps['routeFormulaire'] = '/taches/appliquerModification';

		$tache = $tacheModele->find ($idTache);
		$tache['rappel']      = OutilsConversion::convertirMinutesEnUnite( $tache['rappel'], 'heure' );
		$dataCorps['tache']   = $tache;

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
		//TODO: tester : 
		// return redirect()->back();
	}

	public function changerNbTachesParPage ( ) {
		// Récupérer les données du formulaire
		$data = request()->getPost ();

		$this->session->setNbTachesParPage ( $data['parPage'] );

		//TODO: rediriger vers la page de la vue en cours
	}
}