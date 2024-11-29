<?php 
namespace App\Controllers;
use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;

class TriageFiltrageControleur extends BaseController 
{
	private int $idUtilisateur;
	private ServiceTriageTaches $trieur;
	private ServiceFiltrageTaches $filtreur;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/

	public function __construct() {
		$session = session();
		$this->idUtilisateur = $session->get('id');

		$this->initialiserServicesSession();
	}

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

	public function index(){
		// Charger les outils
		helper(['form']);

		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$data = [];
		$data['trieur']    = $this->trieur;
		$data['filtreur']  = $this->filtreur;
		$data['priorites'] = $intituleModele->getPrioritesUtilisateur( $this->idUtilisateur );
		$data['statuts']   = $intituleModele->getStatutsUtilisateur( $this->idUtilisateur );

		// Charger la vue
		return view('taches/filtrageTriageTachesVue', $data);
	}

	public function appliquer()
	{
		// Récupérer les données soumises via le formulaire
		$data = $this->request->getPost();

		// Appliquer les modifications de tri
		$this->appliquerModificationsFiltres( $data );
		$this->appliquerModificationsTris( $data );

		// Rediriger vers la page d'édition pour voir les filtres appliqués
		return redirect()->to('/taches');
	}

	/*---------------------------------------*/
	/*                METHODES               */
	/*---------------------------------------*/

	//TODO: à voir pour améliorer cette partie pour pas mettre en dur
	private function appliquerModificationsTris( $data ) {
		// réintialiser les valeurs de tri
		$this->trieur->reinitialiser();

		// Vérification des données avant de les appliquer
		if (!empty($data['tri_titre'])) {
			$this->trieur->setTri('titre', $data['tri_titre']);
		}
		if (!empty($data['tri_date_ajout'])) {
			$this->trieur->setTri('date_ajout', $data['tri_date_ajout']);
		}
		if (!empty($data['tri_date_echeance'])) {
			$this->trieur->setTri('date_echeance', $data['tri_date_echeance']);
		}

		// Mettre à jour les valeurs de tri dans la session
		$this->trieur->setDansSession();
	}

	private function appliquerModificationsFiltres( $data ) {
		// réintialiser les valeurs de filtre
		$this->filtreur->reinitialiser();

		// Vérification des données avant de les appliquer
		if(!empty($data['deb_date_echeance'])) {
			$this->filtreur->setTri('deb_date_echeance', date('Y-m-d H:i:s', strtotime($data['deb_date_echeance']))); //$data['deb_date_echeance']
		}
		if(!empty($data['fin_date_echeance'])) {
			$this->filtreur->setTri('fin_date_echeance', date('Y-m-d H:i:s', strtotime($data['fin_date_echeance']))); //$data['fin_date_echeance']
		}
		if(!empty($data['contient'])) {
			$this->filtreur->setTri('contient', $data['contient']);
		}
		if(!empty($data['priorite'])) {
			$this->filtreur->setTri('priorite', $data['priorite']);
		}
		if(!empty($data['statut'])) {
			$this->filtreur->setTri('statut', $data['statut']);
		}
	
		// Mettre à jour les valeurs de filtre dans la session
		$this->filtreur->setDansSession();
	}
} 