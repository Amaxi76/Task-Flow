<?php 
namespace App\Controllers;

use App\Models\Taches\Filtrage;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use Config\Pager;   

class TachesControleur extends BaseController 
{ 
	private Filtrage $filtrage;

	private function setFiltrageTachesSession() {
		if( !session()->has('filtrageTaches') ) {
			$this->filtrage = new Filtrage();
			session()->set('filtrageTaches', $this->filtrage);
		}
		$this->filtrage = session()->get('filtrageTaches');
	}

	public function __construct() {
		$this->setFiltrageTachesSession();
	}

	public function editerFiltrage(){
		/*return view('taches/filtrageTachesVue', [
			'filtres_simples' => $this->filtrage->filtres_simples,
			'filtres_multiples' => $this->filtrage->filtres_multiples,
			'tris' => $this->filtrage->tris,
		]);*/
		helper(['form']);
		return view('taches/filtrageTachesVue');
	}

	public function appliquerFiltrage()
    {
        // Ici tu peux récupérer les valeurs du formulaire et appliquer la logique de filtrage
        // ou simplement les afficher.
        $data = $this->request->getPost();
        var_dump($data); // Debug pour voir les données soumises

		$this->filtrage->setTri('titre', $data['tri_titre']);
		$this->filtrage->setTri('ajoute_le', $data['tri_ajoute_le']);
		$this->filtrage->setTri('echeance', $data['tri_echeance']);

		$this->filtrage->setFiltreSimple('date_min', $data['date_min']);
		$this->filtrage->setFiltreSimple('date_max', $data['date_max']);
		$this->filtrage->setFiltreSimple('contient', $data['contient']);

		/*$this->filtrage->addFiltreMultiple('priorite', $data['priorite']);
		$this->filtrage->addFiltreMultiple('statut', $data['statut']);*/

		// Sauvegarder les valeurs dans la session
		session()->set('filtrageTaches', $this->filtrage);

        // Recharger la vue avec des valeurs mises à jour
        return redirect()->to('/taches/filtres/editer');
    }

	public function index() 
	{
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle des tâches
		$tacheModele = new ModeleVueCartesTaches();
		$intituleModele = new ModeleIntitules();

		// Appliquer les filtrages de la session
		$this->filtrage->filtrage($tacheModele);

		// Configurer le pager
		$configPager = config(Pager::class); 
		$configPager->perPage = 4;

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['statuts']     = $intituleModele->getStatutsUtilisateur(1);
		$dataCorps['priorites']   = $intituleModele->getPrioritesUtilisateur(1);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue 
		helper(['form']);
		return view('commun/entete', $dataEntete) . view('/taches/afficherTachesVue', $dataCorps) . view('commun/piedpage'); 
	}

	public function ajouter() {
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger les modèles
		$prioriteModele = new ModeleIntitules();
		$statusModele   = new ModeleIntitules();

		// Charger les données
		$dataCorps = [];
		$dataCorps['priorites'] = $prioriteModele->getPrioritesUtilisateur(1);
		$dataCorps['statuts']   = $statusModele  ->getStatutsUtilisateur(1);

		// Charger la vue
		helper(['form']);
		return view('commun/entete', $dataEntete) . view('taches/ajouterTacheVue', $dataCorps) . view('commun/piedpage'); 
	}

	public function stocker(){
		// Données générales de la page
		$dataEntete = [];
		$dataEntete['titre'] = 'Tache ajoutée';

		// Récupérer les données du formulaire
		$request = \Config\Services::request();
		$data['tache'] = $request->getPost();

		// Charger le modèle
		$tacheModele = new ModeleTaches();

		// Insérer les données
		$tacheModele->insert($data['tache']);

		// Charger la vue
		return view('commun/entete', $dataEntete) . view('taches/stockerTacheVue', $data) . view('commun/piedpage'); 
	}
} 