<?php 
namespace App\Controllers;
use App\Models\Taches\ServiceTriageTaches;
use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ModeleIntitules;
use App\Models\Utilisateurs\SessionUtilisateur;

class TriageFiltrageControleur extends BaseController 
{
	private SessionUtilisateur $session;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/

	public function __construct() {
		$this->session = new SessionUtilisateur();
		//$this->initialiserServicesSession();
	}

	/*private function initialiserServicesSession() {
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
	}*/

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	public function index(){
		// Charger le modèle
		$intituleModele = new ModeleIntitules();

		// Charger les données
		$data = [];
		$data['trieur']    = $this->session ->getTriageTaches();
		$data['filtreur']  = $this->session ->getFiltrageTaches();
		$data['priorites'] = $intituleModele->getPrioritesUtilisateur( $this->session->getIdUtilisateur() );
		$data['statuts']   = $intituleModele->getStatutsUtilisateur  ( $this->session->getIdUtilisateur() );

		// Charger la vue
		helper(['form']);
		return view('taches/filtrageTriageTachesVue', $data);
	}

	public function appliquer() {
		// Récupérer les données soumises via le formulaire
		$data = $this->request->getPost();

		// Appliquer les modifications de tri
		$this->appliquerModificationsFiltres( $data );
		$this->appliquerModificationsTris   ( $data );

		// Rediriger vers la page d'édition pour voir les filtres appliqués
		return redirect()->to('/taches');
	}

	/*---------------------------------------*/
	/*                METHODES               */
	/*---------------------------------------*/

	//TODO: à voir pour améliorer cette partie pour pas mettre en dur
	private function appliquerModificationsTris( $data ) {
		// récupérer le trieur de la session
		$trieur = $this->session->getTriageTaches();

		// réintialiser les valeurs de tri
		$trieur->reinitialiser();

		// Vérification des données avant de les appliquer
		if (!empty($data['tri_titre'])) {
			$trieur->setTri('titre', $data['tri_titre']);
		}
		if (!empty($data['tri_date_ajout'])) {
			$trieur->setTri('date_ajout', $data['tri_date_ajout']);
		}
		if (!empty($data['tri_date_echeance'])) {
			$trieur->setTri('date_echeance', $data['tri_date_echeance']);
		}

		// Mettre à jour les valeurs de tri dans la session
		$this->session->setTriageTaches($trieur);
	}

	private function appliquerModificationsFiltres( $data ) {
		// récupérer le filtreur de la session
		$filtreur = $this->session->getFiltrageTaches();

		// réintialiser les valeurs de filtre
		$filtreur->reinitialiser();

		// Vérification des données avant de les appliquer
		if(!empty($data['deb_date_echeance'])) {
			$filtreur->setTri('deb_date_echeance', date('Y-m-d H:i:s', strtotime($data['deb_date_echeance'])));
		}
		if(!empty($data['fin_date_echeance'])) {
			$filtreur->setTri('fin_date_echeance', date('Y-m-d H:i:s', strtotime($data['fin_date_echeance'])));
		}
		if(!empty($data['contient'])) {
			$filtreur->setTri('contient', $data['contient']);
		}
		if(!empty($data['priorite'])) {
			$filtreur->setTri('priorite', $data['priorite']);
		}
		if(!empty($data['statut'])) {
			$filtreur->setTri('statut', $data['statut']);
		}
	
		// Mettre à jour les valeurs de filtre dans la session
		$this->session->setFiltrageTaches($filtreur);
	}
} 