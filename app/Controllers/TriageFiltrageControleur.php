<?php 
namespace App\Controllers;
use App\Models\Taches\ServiceTriageTaches;

class TriageFiltrageControleur extends BaseController 
{
	private ServiceTriageTaches $trieur;

	public function __construct() {
		//dd('trieur');
		if( ServiceTriageTaches::estPresentEnSession() ) {
			$this->trieur = ServiceTriageTaches::getDepuisSession();
		}
		else {
			$this->trieur = new ServiceTriageTaches();
			$this->trieur->setDansSession();
		}
	}

	public function index(){
		// Charger les outils
		helper(['form']);

		// Charger les données
		$data = [];
		$data['trieur'] = $this->trieur;

		// Charger la vue
		return view('taches/filtrageTriageTachesVue', $data);
	}

	public function appliquer()
	{
		// Récupérer les données soumises via le formulaire
		$data = $this->request->getPost();

		// Appliquer les modifications de tri
		$this->appliquerModificationsTri( $data );

		// Rediriger vers la page d'édition pour voir les filtres appliqués
		return redirect()->to('/taches');
	}
	
	private function appliquerModificationsTri( $data ) {
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

} 