<?php 
namespace App\Controllers;

use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;

class TachesControleur extends BaseController 
{ 
	public function index() { 
		helper(['form']);

		// Données générales de la page
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger les modèles
		$tacheModele = new ModeleVueCartesTaches();
		$intituleModele = new ModeleIntitules();

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['statuts']     = $intituleModele->getStatutsUtilisateur(1);
		$dataCorps['priorites']   = $intituleModele->getPrioritesUtilisateur(1);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue
		return view('commun/entete', $dataEntete) . view('taches/afficherTachesVue', $dataCorps) . view('commun/piedpage'); 
	}

	public function creer() {
		helper(['form']);
		
		// Données générales de la page
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