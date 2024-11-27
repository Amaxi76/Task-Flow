<?php 
namespace App\Controllers;

use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;

class TachesControleur extends BaseController 
{ 
	public function index() { 
		// Données générales de la page
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle
		$tacheModele = new ModeleVueCartesTaches();

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue
		return view('commun/entete', $dataEntete) . view('taches/afficherTachesVue', $dataCorps) . view('commun/piedpage'); 
	}

	public function creer() {
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
		helper(['form']);
		
		// Données générales de la page
		$dataEntete = [];
		$dataEntete['titre'] = 'Tache ajoutée';

		// Récupérer les données du formulaire
		$dataTache = [];
		$dataTache['id_utilisateur'] = $this->request->getPost('id_utilisateur');
		$dataTache['titre'] = $this->request->getPost('titre');
		$dataTache['detail'] = $this->request->getPost('detail');
		$dataTache['echeance'] = $this->request->getPost('echeance');
		$dataTache['id_priorite'] = $this->request->getPost('id_priorite');
		$dataTache['id_statut'] = $this->request->getPost('id_statut');

		// Charger le modèle
		$tacheModele = new ModeleTaches();

		// Insérer les données
		//$tacheModele->insert($data);

		// Charger la vue
		return view('commun/entete', $dataEntete) . view('taches/stockerTacheVue', $dataTache) . view('commun/piedpage'); 
	}
} 